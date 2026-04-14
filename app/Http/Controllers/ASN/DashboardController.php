<?php

namespace App\Http\Controllers\ASN;

use App\Http\Controllers\Controller;
use App\Models\Posting;
use App\Models\Pilar;
use App\Models\Evaluation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Dashboard untuk ASN - lihat performa posting bulan ini
 */
class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard dengan stats performa
     */
    public function index()
    {
        // Refresh user data dari database untuk memastikan data terbaru (terutama flagging status)
        $user = Auth::user()->fresh();
        $currentMonth = Carbon::now()->format('Y-m');
        
        // Get postings for current month, filtered by current user
        $postings = Posting::where('user_id', $user->id)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->where('status', 'VERIFIED')
            ->with('engagement', 'pilar')
            ->get();

        $verifiedCount = $postings->count();
        $pilarsUsed = $postings->groupBy('pilar_id')->keys();

        // Get total engagement
        $totalEngagement = $postings->sum(function ($p) {
            return $p->engagement?->getTotalEngagement() ?? 0;
        });

        // Calculate score
        $score = ($verifiedCount * 10) + min($totalEngagement, 30);

        // Status check
        $status = $verifiedCount >= 4 ? 'ON_TARGET' : ($verifiedCount > 0 ? 'AT_RISK' : 'BELOW_TARGET');

        // Get current evaluation feedback
        $evaluation = $user->currentEvaluation();

        return view('asn.dashboard', [
            'user' => $user,
            'verifiedCount' => $verifiedCount,
            'pilarsUsed' => $pilarsUsed,
            'totalEngagement' => $totalEngagement,
            'score' => $score,
            'status' => $status,
            'postings' => $postings,
            'evaluation' => $evaluation,
        ]);
    }

    /**
     * Hapus notifikasi flagging
     */
    public function clearFlagging(Request $request)
    {
        $user = Auth::user()->fresh();

        if (!$user->is_flagged) {
            return redirect()->route('asn.dashboard')
                ->with('error', 'Tidak ada flagging untuk dihapus');
        }

        // Reset flagging di database
        $user->update([
            'is_flagged' => false,
            'flagged_at' => null,
        ]);

        // Refresh user model dan update Auth guard
        $user->refresh();
        Auth::setUser($user);

        return redirect()->route('asn.dashboard')
            ->with('success', 'Notif flagging berhasil dihapus. Tingkatkan posting untuk target bulan depan! 💪');
    }

    /**
     * Hapus notifikasi feedback
     */
    public function clearFeedback(Request $request)
    {
        $user = Auth::user()->fresh();
        $evaluation = $user->currentEvaluation();

        if (!$evaluation) {
            return redirect()->route('asn.dashboard')
                ->with('error', 'Tidak ada feedback untuk dihapus');
        }

        // Reset evaluation di database
        $evaluation->update([
            'evaluated_by' => null,
            'notes' => null,
            'status' => 'PENDING',
        ]);

        return redirect()->route('asn.dashboard')
            ->with('success', 'Feedback berhasil dihapus. Sekarang dashboard Anda lebih bersih! 🎉');
    }
}
