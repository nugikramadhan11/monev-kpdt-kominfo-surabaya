<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ASN\DashboardController as AsnDashboardController;
use App\Http\Controllers\ASN\PostingController;
use App\Http\Controllers\ASN\EngagementController;
use App\Http\Controllers\ASN\NotificationController;
use App\Http\Controllers\Pimpinan\DashboardController as PimpinanDashboardController;
use App\Http\Controllers\Pimpinan\EvaluationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use Illuminate\Support\Facades\Route;

/**
 * AUTHENTICATION ROUTES - Routes untuk login/logout (public)
 */
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

/**
 * ============================================================
 * ASN ROUTES - Aparatur Sipil Negara
 * ============================================================
 * Middleware: auth, role:ASN
 * Prefix: /asn
 * 
 * Features:
 * - Dashboard: Status performa posting bulan ini
 * - Postings CRUD: Buat, lihat, edit, hapus posting
 * - Notifications: Lihat, tandai baca, hapus notifikasi
 * - Actions: Clear flagging & feedback notifications
 */
Route::middleware(['auth', 'role:ASN'])->prefix('asn')->group(function () {
    // Dashboard & Dashboard Actions
    Route::get('/dashboard', [AsnDashboardController::class, 'index'])->name('asn.dashboard');
    Route::delete('/flagging', [AsnDashboardController::class, 'clearFlagging'])->name('asn.flagging.clear');
    Route::delete('/feedback', [AsnDashboardController::class, 'clearFeedback'])->name('asn.feedback.clear');
    
    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('asn.notifications.index');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('asn.notifications.unread-count');
    Route::get('/notifications/fetch', [NotificationController::class, 'getNotifications'])->name('asn.notifications.fetch');
    Route::put('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('asn.notifications.read');
    Route::put('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('asn.notifications.mark-all-read');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'delete'])->name('asn.notifications.delete');
    Route::delete('/notifications', [NotificationController::class, 'deleteAll'])->name('asn.notifications.delete-all');
    
    Route::resource('postings', PostingController::class, ['as' => 'asn']);
    Route::post('postings/verify-url', [PostingController::class, 'verifyUrl'])->name('asn.postings.verify-url');
    Route::put('postings/{posting}/engagement', [EngagementController::class, 'update'])->name('asn.engagement.update');
});

// Pimpinan Routes
Route::middleware(['auth', 'role:PIMPINAN'])->prefix('pimpinan')->group(function () {
    Route::get('/dashboard', [PimpinanDashboardController::class, 'index'])->name('pimpinan.dashboard');
    Route::get('/evaluations', [EvaluationController::class, 'index'])->name('pimpinan.evaluations.index');
    Route::get('/evaluations/{asn}', [EvaluationController::class, 'show'])->name('pimpinan.evaluations.show');
    Route::put('/evaluations/{asn}', [EvaluationController::class, 'update'])->name('pimpinan.evaluations.update');
    Route::delete('/evaluations/{asn}/feedback', [EvaluationController::class, 'clearFeedback'])->name('pimpinan.evaluations.clear-feedback');
    Route::post('/run-flagging', [EvaluationController::class, 'runFlagging'])->name('pimpinan.run-flagging');
});

// Admin Routes
Route::middleware(['auth', 'role:ADMIN'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // User Management
    Route::post('/users', [AdminDashboardController::class, 'storeUser'])->name('admin.users.store');
    Route::put('/users/{user}', [AdminDashboardController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminDashboardController::class, 'destroyUser'])->name('admin.users.destroy');
    
    // Wilayah Management
    Route::post('/wilayahs', [AdminDashboardController::class, 'storeWilayah'])->name('admin.wilayahs.store');
    Route::put('/wilayahs/{wilayah}', [AdminDashboardController::class, 'updateWilayah'])->name('admin.wilayahs.update');
    Route::delete('/wilayahs/{wilayah}', [AdminDashboardController::class, 'destroyWilayah'])->name('admin.wilayahs.destroy');
    
    // Pilar Management
    Route::post('/pilars', [AdminDashboardController::class, 'storePilar'])->name('admin.pilars.store');
    Route::put('/pilars/{pilar}', [AdminDashboardController::class, 'updatePilar'])->name('admin.pilars.update');
    Route::delete('/pilars/{pilar}', [AdminDashboardController::class, 'destroyPilar'])->name('admin.pilars.destroy');
    
    // OPD Management
    Route::post('/opds', [AdminDashboardController::class, 'storeOPD'])->name('admin.opds.store');
    Route::put('/opds/{opd}', [AdminDashboardController::class, 'updateOPD'])->name('admin.opds.update');
    Route::delete('/opds/{opd}', [AdminDashboardController::class, 'destroyOPD'])->name('admin.opds.destroy');
});
