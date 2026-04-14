<?php

namespace App\Http\Controllers\ASN;

use App\Http\Controllers\Controller;
use App\Models\Posting;
use App\Models\PostingEngagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * EngagementController - Mengelola data engagement posting
 * 
 * Controller ini menangani update engagement (likes, comments, shares) dari posting.
 * Engagement dapat diupdate setelah posting dibuat.
 */
class EngagementController extends Controller
{
    /**
     * Update engagement data posting
     * 
     * Update jumlah likes, comments, dan shares untuk posting.
     * Jika posting masih dalam status DRAFT, akan diubah menjadi PENDING.
     * Authorization: Hanya pemilik posting yang bisa update.
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Posting $posting
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Posting $posting)
    {
        // Only owner can update engagement
        if ($posting->user_id !== Auth::id()) {
            return redirect()->back()->withErrors('Unauthorized');
        }

        $validated = $request->validate([
            'likes' => 'required|integer|min:0',
            'comments' => 'required|integer|min:0',
            'shares' => 'required|integer|min:0',
        ]);

        // Change status to PENDING if still DRAFT
        if ($posting->status === 'DRAFT') {
            $posting->update(['status' => 'PENDING']);
        }

        $posting->engagement()->update($validated);

        return redirect()->back()->with('success', 'Engagement berhasil diupdate');
    }
}
