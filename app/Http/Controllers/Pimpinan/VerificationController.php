<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Posting;
use App\Models\VerificationHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        // Get all pending postings from all wilayah
        $pendingPostings = Posting::where('status', 'PENDING')
            ->with('user', 'pilar', 'engagement', 'wilayah')
            ->latest()
            ->paginate(15);

        return view('pimpinan.verification.index', compact('pendingPostings'));
    }

    public function show(Posting $posting)
    {
        $this->authorize('view', $posting);
        $posting->load('user', 'pilar', 'engagement', 'verificationHistories.verifiedBy');
        return view('pimpinan.verification.show', compact('posting'));
    }

    public function approve(Request $request, Posting $posting)
    {
        $this->authorize('update', $posting);

        if ($posting->status !== 'PENDING') {
            return back()->withErrors('Posting tidak bisa diverifikasi');
        }

        $posting->update([
            'status' => 'VERIFIED',
            'verified_by' => Auth::id(),
            'verified_at' => now(),
        ]);

        VerificationHistory::create([
            'posting_id' => $posting->id,
            'verified_by' => Auth::id(),
            'action' => 'APPROVED',
        ]);

        return redirect()->route('pimpinan.verification.index')->with('success', 'Posting berhasil disetujui');
    }

    public function reject(Request $request, Posting $posting)
    {
        $this->authorize('update', $posting);

        $validated = $request->validate([
            'reason' => 'required|string',
        ]);

        if ($posting->status !== 'PENDING') {
            return back()->withErrors('Posting tidak bisa ditolak');
        }

        $posting->update([
            'status' => 'REJECTED',
            'verified_by' => Auth::id(),
            'verified_at' => now(),
            'rejection_reason' => $validated['reason'],
        ]);

        VerificationHistory::create([
            'posting_id' => $posting->id,
            'verified_by' => Auth::id(),
            'action' => 'REJECTED',
            'reason' => $validated['reason'],
        ]);

        return redirect()->route('pimpinan.verification.index')->with('success', 'Posting berhasil ditolak');
    }
}
