<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * VerificationHistory Model - Mewakili riwayat verifikasi posting
 * 
 * Model ini mencatat setiap perubahan status verifikasi posting untuk audit trail.
 * Digunakan untuk melacak siapa yang melakukan verifikasi, kapan, dan apa alasannya.
 * Berguna untuk keperluan reporting dan troubleshooting.
 * 
 * @property int $id - ID unik history record
 * @property int $posting_id - ID posting yang diverifikasi
 * @property int $verified_by - ID user yang melakukan verifikasi
 * @property string $action - Aksi yang dilakukan (VERIFIED/REJECTED/RESUBMITTED)
 * @property string $reason - Alasan untuk aksi (khususnya untuk REJECTED)
 */
class VerificationHistory extends Model
{
    protected $fillable = ['posting_id', 'verified_by', 'action', 'reason'];

    public function posting()
    {
        return $this->belongsTo(Posting::class);
    }

    /**
     * Dapatkan user yang melakukan verifikasi
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
