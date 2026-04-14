<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Posting Model - Mewakili posting media sosial ASN
 * 
 * Model ini menangani data posting yang dibuat oleh ASN (Aparatur Sipil Negara)
 * di berbagai platform media sosial (Instagram, TikTok, YouTube, Facebook).
 * Setiap posting memiliki status verifikasi dan dapat memiliki engagement data.
 * 
 * @property int $id - ID unik posting
 * @property int $user_id - ID ASN yang membuat posting
 * @property int $pilar_id - ID pilar/kategori posting
 * @property int $wilayah_id - ID wilayah ASN
 * @property string $url - Link/URL posting di media sosial
 * @property string $platform - Platform media sosial (Instagram/TikTok/YouTube/Facebook)
 * @property string $caption - Caption/deskripsi posting
 * @property datetime $posted_date - Tanggal posting dibuat di media sosial
 * @property string $status - Status posting (PENDING/VERIFIED/REJECTED/DRAFT)
 * @property int $verified_by - ID user yang melakukan verifikasi
 * @property datetime $verified_at - Waktu posting diverifikasi
 * @property string $rejection_reason - Alasan ditolak (jika status REJECTED)
 */
class Posting extends Model
{
    protected $fillable = [
        'user_id',
        'pilar_id',
        'wilayah_id',
        'url',
        'platform',
        'caption',
        'posted_date',
        'status',
        'verified_by',
        'verified_at',
        'rejection_reason',
    ];

    protected $casts = [
        'posted_date' => 'datetime',
        'verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pilar()
    {
        return $this->belongsTo(Pilar::class);
    }

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function engagement()
    {
        return $this->hasOne(PostingEngagement::class);
    }

    public function verificationHistories()
    {
        return $this->hasMany(VerificationHistory::class);
    }

    /**
     * Cek apakah posting masih dalam status pending
     * 
     * @return bool
     */
    public function isPending()
    {
        return $this->status === 'PENDING';
    }

    /**
     * Cek apakah posting sudah diverifikasi
     * 
     * @return bool
     */
    public function isVerified()
    {
        return $this->status === 'VERIFIED';
    }
}
