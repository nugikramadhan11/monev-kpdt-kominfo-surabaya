<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Evaluation;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    /**
     * Display monitoring list for current month
     */
    public function index()
    {
        $user = Auth::user();
        $currentMonth = Carbon::now();
        
        // Get all ASN from all wilayah (same query as DashboardController)
        $asnUsers = User::whereHas('roles', function ($q) {
            $q->where('name', 'ASN');
        })
            ->with('evaluations', 'wilayah', 'opd')
            ->get();

        // Calculate posting count for each ASN
        $asnUsers = $asnUsers->map(function ($asn) use ($currentMonth) {
            $postingCount = $asn->postings()
                ->whereYear('created_at', $currentMonth->year)
                ->whereMonth('created_at', $currentMonth->month)
                ->where('status', 'VERIFIED')
                ->count();

            // Add attributes to model
            $asn->posting_count_this_month = $postingCount;
            $asn->is_flagged = $asn->flagged_week ?? false;
            // Add status attribute for display
            $asn->status = $postingCount >= 4 ? 'ON_TARGET' : ($postingCount > 0 ? 'AT_RISK' : 'BELOW_TARGET');

            return $asn;
        });

        // Get current month evaluations
        $evaluations = Evaluation::where('evaluation_month', '>=', now()->startOfMonth())
            ->where('evaluation_month', '<', now()->addMonth()->startOfMonth())
            ->get()
            ->keyBy('user_id');

        return view('pimpinan.evaluations.index', compact('asnUsers', 'evaluations', 'user'));
    }

    /**
     * Show evaluation detail for specific ASN
     */
    public function show(User $asn)
    {
        $user = Auth::user();

        // Check if user is ASN
        if (!$asn->hasRole('ASN')) {
            abort(403, 'Unauthorized');
        }

        $evaluation = $asn->currentEvaluation();

        if (!$evaluation) {
            abort(404, 'Evaluation not found');
        }

        // Get postings for this month with pilar info
        $currentMonth = now();
        $postings = $asn->postings()
            ->whereYear('created_at', $currentMonth->year)
            ->whereMonth('created_at', $currentMonth->month)
            ->where('status', 'VERIFIED')
            ->with('pilar')
            ->orderBy('posted_date', 'desc')
            ->get();

        // Pilar breakdown count
        $pilarBreakdown = $postings->groupBy('pilar_id')->map(function ($items) {
            return [
                'count' => $items->count(),
                'pilar' => $items->first()->pilar,
            ];
        })->values();

        return view('pimpinan.evaluations.show', compact('asn', 'evaluation', 'postings', 'pilarBreakdown'));
    }

    /**
     * Submit evaluation for ASN
     */
    public function update(Request $request, User $asn)
    {
        $user = Auth::user();

        // Check if user is ASN
        if (!$asn->hasRole('ASN')) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        $evaluation = $asn->currentEvaluation();

        if (!$evaluation) {
            abort(404, 'Evaluation not found');
        }

        // Update evaluation
        $evaluation->update([
            'evaluated_by' => $user->id,
            'notes' => $validated['notes'],
            'status' => 'EVALUATED',
        ]);

        // Create notification for evaluation feedback if there are notes
        if ($validated['notes']) {
            $this->createEvaluationNotification($asn, $validated['notes']);
        }

        return redirect()->route('pimpinan.evaluations.index')
            ->with('success', 'Evaluasi berhasil disimpan');
    }

    /**
     * Auto-run flagging for month
     */
    public function runFlagging()
    {
        $user = Auth::user();

        if (!$user->hasRole('PIMPINAN')) {
            abort(403, 'Unauthorized');
        }

        \Artisan::call('posting:flag-underperforming');

        return redirect()->route('pimpinan.evaluations.index')
            ->with('success', 'Auto-flagging selesai dijalankan');
    }

    /**
     * Clear feedback (reset evaluation notes)
     */
    public function clearFeedback(User $asn)
    {
        $user = Auth::user();

        // Check if user is ASN
        if (!$asn->hasRole('ASN')) {
            abort(403, 'Unauthorized');
        }

        $evaluation = $asn->currentEvaluation();

        if (!$evaluation) {
            abort(404, 'Evaluation not found');
        }

        // Reset evaluation
        $evaluation->update([
            'evaluated_by' => null,
            'notes' => null,
            'status' => 'PENDING',
        ]);

        return redirect()->route('pimpinan.evaluations.show', $asn)
            ->with('success', 'Feedback berhasil dihapus. ASN akan melihat evaluasi ulang.');
    }

    /**
     * Create evaluation feedback notification
     */
    private function createEvaluationNotification(User $asn, string $notes)
    {
        // Delete previous evaluation notifications to avoid duplicates
        $asn->notifications()->where('type', 'EVALUATION_FEEDBACK')->delete();

        // Create new notification
        Notification::create([
            'user_id' => $asn->id,
            'type' => 'EVALUATION_FEEDBACK',
            'title' => '💬 Feedback dari Pimpinan',
            'message' => $notes,
            'icon' => '💬',
            'color' => 'blue',
            'action_url' => route('asn.dashboard'),
        ]);
    }
}
