<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wilayah;
use App\Models\Pilar;
use App\Models\OPD;
use App\Models\Posting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

/**
 * DashboardController - Admin dashboard untuk manajemen master data
 * 
 * Controller ini mengelola admin dashboard dan operasi CRUD untuk:
 * - User Management (Create, Update, Delete user)
 * - Wilayah Management
 * - Pilar Management (kategori posting)
 * - OPD Management (organisasi perangkat daerah)
 */
class DashboardController extends Controller
{
    /**
     * Menampilkan admin dashboard dengan master data
     * 
     * Menampilkan semua users, wilayahs, pilars, opds, dan jumlah posting pending.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::with('roles')->get();
        $wilayahs = Wilayah::all();
        $pilars = Pilar::all();
        $opds = OPD::with('wilayah')->get();
        $pendingPostings = Posting::where('status', 'PENDING')->count();

        return view('admin.dashboard', [
            'users' => $users,
            'wilayahs' => $wilayahs,
            'pilars' => $pilars,
            'opds' => $opds,
            'pendingPostings' => $pendingPostings,
        ]);
    }

    /**
     * Menyimpan user baru ke database
     * Membuat user baru dengan role tertentu (ASN/PIMPINAN/ADMIN).
     * Email dan NIP harus unik di database.
     */
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'nip' => 'nullable|unique:users',
            'role' => 'required|in:ASN,PIMPINAN,ADMIN',
            'wilayah_id' => 'nullable|exists:wilayahs,id',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nip' => $validated['nip'],
            'wilayah_id' => $validated['wilayah_id'],
            'password' => Hash::make($validated['password']),
        ]);

        $user->assignRole($validated['role']);

        return back()->with('success', 'User berhasil dibuat');
    }

    /**
     * Update user yang sudah ada
     * Update data user dan role mereka.
     */
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nip' => 'nullable|unique:users,nip,' . $user->id,
            'role' => 'required|in:ASN,PIMPINAN,ADMIN',
            'wilayah_id' => 'nullable|exists:wilayahs,id',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nip' => $validated['nip'],
            'wilayah_id' => $validated['wilayah_id'],
        ]);

        $user->syncRoles($validated['role']);

        return back()->with('success', 'User berhasil diperbarui');
    }

    /**
     * Menghapus user dari database
     * Tidak bisa menghapus user yang sedang login (self).
     */
    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors('Tidak bisa menghapus akun sendiri');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus');
    }

    // Wilayah Management
    public function storeWilayah(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:wilayahs',
            'code' => 'required|string|unique:wilayahs',
        ]);

        Wilayah::create($validated);
        return back()->with('success', 'Wilayah berhasil dibuat');
    }

    public function updateWilayah(Request $request, Wilayah $wilayah)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:wilayahs,name,' . $wilayah->id,
            'code' => 'required|string|unique:wilayahs,code,' . $wilayah->id,
        ]);

        $wilayah->update($validated);
        return back()->with('success', 'Wilayah berhasil diperbarui');
    }

    public function destroyWilayah(Wilayah $wilayah)
    {
        $wilayah->delete();
        return back()->with('success', 'Wilayah berhasil dihapus');
    }

    // Pilar Management
    public function storePilar(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'hashtag' => 'required|string|unique:pilars',
            'color' => 'required|string',
        ]);

        Pilar::create($validated);
        return back()->with('success', 'Pilar berhasil dibuat');
    }

    public function updatePilar(Request $request, Pilar $pilar)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'hashtag' => 'required|string|unique:pilars,hashtag,' . $pilar->id,
            'color' => 'required|string',
        ]);

        $pilar->update($validated);
        return back()->with('success', 'Pilar berhasil diperbarui');
    }

    public function destroyPilar(Pilar $pilar)
    {
        $pilar->delete();
        return back()->with('success', 'Pilar berhasil dihapus');
    }

    // OPD Management
    public function storeOPD(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'kode' => 'required|string|unique:opds',
            'wilayah_id' => 'required|exists:wilayahs,id',
        ]);

        OPD::create($validated);
        return back()->with('success', 'OPD berhasil dibuat');
    }

    public function updateOPD(Request $request, OPD $opd)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'kode' => 'required|string|unique:opds,kode,' . $opd->id,
            'wilayah_id' => 'required|exists:wilayahs,id',
        ]);

        $opd->update($validated);
        return back()->with('success', 'OPD berhasil diperbarui');
    }

    public function destroyOPD(OPD $opd)
    {
        $opd->delete();
        return back()->with('success', 'OPD berhasil dihapus');
    }
}
