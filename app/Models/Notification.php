<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Notification Model - Mewakili notifikasi untuk user (ASN)
 * 
 * Model ini menangani semua notifikasi system yang dikirim ke user.
 * Ada dua tipe notifikasi:
 * 1. FLAGGING - Notifikasi ketika ASN di-flag karena underperfoming
 * 2. EVALUATION_FEEDBACK - Notifikasi ketika PIMPINAN memberikan feedback evaluasi
 * 
 * @property int $id - ID unik notifikasi
 * @property int $user_id - ID ASN yang menerima notifikasi
 * @property string $type - Tipe notifikasi (FLAGGING/EVALUATION_FEEDBACK)
 * @property string $title - Judul notifikasi
 * @property string $message - Isi pesan notifikasi
 * @property string $icon - Icon untuk notifikasi
 * @property string $color - Warna badge notifikasi
 * @property string $action_url - URL untuk action notifikasi
 * @property boolean $is_read - Status apakah notifikasi sudah dibaca
 * @property datetime $read_at - Waktu notifikasi dibaca
 */
class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'icon',
        'color',
        'action_url',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    /**
     * Get the user that owns the notification
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }

    /**
     * Scope untuk mendapatkan notifikasi yang belum dibaca
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope: recent first
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
