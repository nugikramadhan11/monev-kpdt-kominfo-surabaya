<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Posting;
use App\Models\User;
use App\Models\OPD;
use App\Models\Wilayah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * DashboardController - Dashboard monitoring untuk PIMPINAN
 * 
 * Controller ini menampilkan overview performance ASN yang dipimpin:
 * - Status ASN (ON_TARGET/AT_RISK/BELOW_TARGET)
 * - Statistik KPI (jumlah ON_TARGET, AT_RISK, BELOW_TARGET)
 * - Filter berdasarkan OPD dan Wilayah
 * - Top 5 posting berdasarkan engagement
 * - Total engagement dalam bulan berjalan
 */
class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard monitoring untuk PIMPINAN
     * 
     * Menampilkan statistik KPI, filter OPD/Wilayah, daftar ASN dengan status mereka,
     * dan top 5 posting dengan engagement tertinggi.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $currentMonth = Carbon::now();

        // Get filter values
        $selectedOPD = $request->get('opd_id');
        $selectedWilayah = $request->get('wilayah_id');

        // Get all OPDs and Wilayahs for filter dropdowns
        $opds = OPD::orderBy('name')->get();
        $wilayahs = Wilayah::orderBy('name')->get();

        // Build base query for ASN
        $asnQuery = User::whereHas('roles', function ($q) {
            $q->where('name', 'ASN');
        });

        // Apply filters
        if ($selectedOPD) {
            $asnQuery->where('opd_id', $selectedOPD);
        }
        if ($selectedWilayah) {
            $asnQuery->where('wilayah_id', $selectedWilayah);
        }

        $asnUsers = $asnQuery->with('opd', 'wilayah')->get();

        // Calculate KPI for each ASN
        $asnStats = $asnUsers->map(function ($asn) use ($currentMonth) {
            $postings = $asn->postings()
                ->whereYear('created_at', $currentMonth->year)
                ->whereMonth('created_at', $currentMonth->month)
                ->where('status', 'VERIFIED')
                ->count();

            return [
                'asn' => $asn,
                'postings' => $postings,
                'status' => $postings >= 4 ? 'ON_TARGET' : ($postings > 0 ? 'AT_RISK' : 'BELOW_TARGET'),
            ];
        });

        $onTarget = $asnStats->where('status', 'ON_TARGET')->count();
        $atRisk = $asnStats->where('status', 'AT_RISK')->count();
        $belowTarget = $asnStats->where('status', 'BELOW_TARGET')->count();

        // Top engagement from all wilayah
        $topPostings = Posting::where('status', 'VERIFIED')
            ->whereYear('created_at', $currentMonth->year)
            ->whereMonth('created_at', $currentMonth->month)
            ->with('engagement', 'user', 'wilayah')
            ->get()
            ->sortByDesc(function ($p) {
                return $p->engagement?->getTotalEngagement() ?? 0;
            })
            ->take(5);

        return view('pimpinan.dashboard', [
            'user' => $user,
            'asnStats' => $asnStats,
            'onTarget' => $onTarget,
            'atRisk' => $atRisk,
            'belowTarget' => $belowTarget,
            'topPostings' => $topPostings,
            'opds' => $opds,
            'wilayahs' => $wilayahs,
            'selectedOPD' => $selectedOPD,
            'selectedWilayah' => $selectedWilayah,
            'currentMonth' => $currentMonth,
        ]);
    }
}

