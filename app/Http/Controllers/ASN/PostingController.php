<?php

namespace App\Http\Controllers\ASN;

use App\Http\Controllers\Controller;
use App\Models\Posting;
use App\Models\PostingEngagement;
use App\Models\Pilar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * PostingController - Mengelola operasi CRUD posting untuk ASN
 * 
 * Controller ini menangani semua operasi terkait posting media sosial:
 * - Menampilkan daftar posting ASN
 * - Membuat posting baru
 * - Menampilkan detail posting
 * - Mengedit posting (hanya untuk status DRAFT/REJECTED)
 * - Menghapus posting (hanya untuk status DRAFT/REJECTED)
 * - Verifikasi URL duplicate
 * 
 * Validasi dan Authorization:
 * - Hanya ASN bisa mengakses posting mereka sendiri
 * - Status posting: PENDING (sedang proses), VERIFIED (terverifikasi), REJECTED (ditolak), DRAFT (draf)
 * - Posting langsung ter-verifikasi otomatis saat dibuat oleh ASN
 * - Engagement data (likes, comments, shares) di-input manual oleh ASN
 */
class PostingController extends Controller
{

    /**
     * Menampilkan daftar posting ASN yang sedang login
     * 
     * Menampilkan posting dalam urutan terbaru dengan pagination 10 item per halaman.
     * Hanya posting milik user yang sedang login yang ditampilkan (data privacy).
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        // Explicitly query only postings belonging to current user
        $postings = Posting::where('user_id', $user->id)
            ->with('pilar', 'engagement')
            ->latest()
            ->paginate(10);
        
        return view('asn.postings.index', compact('postings'));
    }

    /**
     * Menampilkan form untuk membuat posting baru
     * 
     * Mengambil daftar semua pilar yang tersedia untuk dropdown pilihan.
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $pilars = Pilar::all();
        return view('asn.postings.create', compact('pilars'));
    }

    /**
     * Menyimpan posting baru ke database
     * 
     * Proses pembuatan posting:
     * 1. Validasi input (URL, platform, tanggal, engagement)
     * 2. Cek duplicate URL untuk user yang sama - mencegah upload URL yang sama 2x
     * 3. Buat record posting dengan status VERIFIED (otomatis terverifikasi)
     * 4. Buat record engagement dengan nilai likes/comments/shares dari input
     * 5. Redirect ke detail posting dengan pesan sukses
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'url' => [
                'required',
                'url',
                function ($attribute, $value, $fail) use ($user) {
                    // Check if URL already exists for this user
                    $exists = Posting::where('user_id', $user->id)
                        ->where('url', $value)
                        ->exists();
                    
                    if ($exists) {
                        $fail('URL ini sudah pernah Anda upload sebelumnya.');
                    }
                },
            ],
            'platform' => 'required|in:Instagram,TikTok,YouTube,Facebook',
            'pilar_id' => 'required|exists:pilars,id',
            'caption' => 'nullable|string',
            'posted_date' => 'required|date',
            'likes' => 'required|integer|min:0',
            'comments' => 'required|integer|min:0',
            'shares' => 'required|integer|min:0',
        ]);
        
        $posting = Posting::create([
            'user_id' => $user->id,
            'wilayah_id' => $user->wilayah_id,
            'pilar_id' => $validated['pilar_id'],
            'url' => $validated['url'],
            'platform' => $validated['platform'],
            'caption' => $validated['caption'],
            'posted_date' => $validated['posted_date'],
            'status' => 'VERIFIED',
            'verified_by' => $user->id,
            'verified_at' => now(),
        ]);

        // Create engagement record with user-provided values
        PostingEngagement::create([
            'posting_id' => $posting->id,
            'likes' => $validated['likes'],
            'comments' => $validated['comments'],
            'shares' => $validated['shares'],
        ]);

        return redirect()->route('asn.postings.show', $posting)->with('success', 'Posting berhasil terupload');
    }

    /**
     * Menampilkan detail posting (hanya jika user adalah pemilik posting)
     * 
     * Authorization: Hanya pemilik posting yang bisa view detail.
     * Menampilkan full data posting termasuk pilar dan engagement info.
     * 
     * @param \App\Models\Posting $posting
     * @return \Illuminate\View\View
     */
    public function show(Posting $posting)
    {
        $this->authorize('view', $posting);
        $posting->load('pilar', 'engagement');
        return view('asn.postings.show', compact('posting'));
    }

    /**
     * Menampilkan form untuk edit posting
     * 
     * Authorization: Hanya pemilik posting yang bisa edit.
     * Hanya posting dengan status DRAFT atau REJECTED yang bisa diedit.
     * 
     * @param \App\Models\Posting $posting
     * @return \Illuminate\View\View
     */
    public function edit(Posting $posting)
    {
        $this->authorize('update', $posting);
        $pilars = Pilar::all();
        $posting->load('pilar');
        return view('asn.postings.edit', compact('posting', 'pilars'));
    }

    /**
     * Update posting yang ada
     * 
     * Proses update posting:
     * 1. Validasi bahwa hanya posting DRAFT/REJECTED yang bisa diedit
     * 2. Validasi input (sama dengan store)
     * 3. Update posting data dan set status menjadi PENDING
     * 4. Update engagement record dengan nilai baru
     * 5. Redirect ke detail posting dengan pesan sukses
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Posting $posting
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Posting $posting)
    {
        $this->authorize('update', $posting);

        if (!in_array($posting->status, ['DRAFT', 'REJECTED'])) {
            return redirect()->back()->withErrors('Posting tidak bisa diedit');
        }

        $user = Auth::user();

        $validated = $request->validate([
            'url' => [
                'required',
                'url',
                function ($attribute, $value, $fail) use ($user, $posting) {
                    // Check if URL already exists for this user (exclude current posting)
                    $exists = Posting::where('user_id', $user->id)
                        ->where('url', $value)
                        ->where('id', '!=', $posting->id)
                        ->exists();
                    
                    if ($exists) {
                        $fail('URL ini sudah pernah Anda upload sebelumnya.');
                    }
                },
            ],
            'platform' => 'required|in:Instagram,TikTok,YouTube,Facebook',
            'pilar_id' => 'required|exists:pilars,id',
            'caption' => 'nullable|string',
            'posted_date' => 'required|date',
            'likes' => 'required|integer|min:0',
            'comments' => 'required|integer|min:0',
            'shares' => 'required|integer|min:0',
        ]);

        $posting->update($validated + ['status' => 'PENDING']);

        // Update engagement record
        $posting->engagement()->update([
            'likes' => $validated['likes'],
            'comments' => $validated['comments'],
            'shares' => $validated['shares'],
        ]);

        return redirect()->route('asn.postings.show', $posting)->with('success', 'Posting berhasil diperbarui');
    }

    /**
     * Menghapus posting
     * 
     * Hanya posting dengan status DRAFT atau REJECTED yang bisa dihapus.
     * Akan menghapus posting dan engagement record terkaitnya.
     * 
     * @param \App\Models\Posting $posting
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Posting $posting)
    {
        $this->authorize('delete', $posting);

        if (!in_array($posting->status, ['DRAFT', 'REJECTED'])) {
            return redirect()->back()->withErrors('Posting tidak bisa dihapus');
        }

        $posting->engagement()->delete();
        $posting->delete();

        return redirect()->route('asn.postings.index')->with('success', 'Posting berhasil dihapus');
    }

    /**
     * Verifikasi URL duplicate melalui AJAX call
     * 
     * Endpoint untuk real-time validation URL di forms.
     * Mencegah ASN mengupload URL yang sudah pernah di-upload sebelumnya.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyUrl(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        $user = Auth::user();
        $url = $request->url;

        // Check if URL already exists for this user
        $isDuplicate = Posting::where('user_id', $user->id)
            ->where('url', $url)
            ->exists();

        if ($isDuplicate) {
            return response()->json([
                'valid' => false,
                'message' => 'URL ini sudah pernah Anda upload sebelumnya.',
            ], 422);
        }

        return response()->json([
            'valid' => true,
            'message' => 'URL valid dan dapat di-upload.',
        ]);
    }
}
