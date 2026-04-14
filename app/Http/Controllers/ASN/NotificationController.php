<?php

namespace App\Http\Controllers\ASN;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * NotificationController - Mengelola notifikasi untuk ASN
 * 
 * Controller ini menangani semua operasi terkait notifikasi ASN:
 * - Menampilkan daftar notifikasi (pagination 15 item per halaman)
 * - Mark notifikasi sebagai read
 * - Mark semua notifikasi sebagai read
 * - Menghapus notifikasi individual
 * - Menghapus semua notifikasi
 * - Fetch notifikasi untuk navbar dropdown (10 notifikasi terbaru)
 * - Get unread count untuk badge di navbar
 * 
 * Tipe notifikasi yang ada:
 * - FLAGGING: Notifikasi ketika ASN di-flag (posting < 4 bulan ini)
 * - EVALUATION_FEEDBACK: Notifikasi feedback dari PIMPINAN
 */
class NotificationController extends Controller
{
    /**
     * Dapatkan jumlah notifikasi yang belum dibaca
     * Endpoint AJAX untuk update badge counter di navbar.
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUnreadCount()
    {
        $count = Auth::user()->unreadNotificationsCount();
        return response()->json(['count' => $count]);
    }

    /**
     * Get all notifications for dropdown
     */
    public function getNotifications()
    {
        $notifications = Auth::user()
            ->notifications()
            ->take(10)
            ->get();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => Auth::user()->unreadNotificationsCount(),
        ]);
    }

    /**
     * Show all notifications page
     */
    public function index()
    {
        $notifications = Auth::user()
            ->notifications()
            ->paginate(15);

        return view('asn.notifications.index', compact('notifications'));
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $notification->markAsRead();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Notifikasi ditandai sebagai dibaca');
    }

    /**
     * Mark all as read
     */
    public function markAllAsRead()
    {
        Auth::user()->notifications()->unread()->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Semua notifikasi ditandai sebagai dibaca');
    }

    /**
     * Delete notification
     */
    public function delete(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $notification->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Notifikasi dihapus');
    }

    /**
     * Delete all notifications
     */
    public function deleteAll()
    {
        Auth::user()->notifications()->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Semua notifikasi dihapus');
    }
}
