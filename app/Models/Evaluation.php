<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Evaluation Model - Mewakili evaluasi performa ASN per bulan
 * 
 * Model ini menangani data evaluasi bulanan untuk setiap ASN.
 * Evaluasi mencakup jumlah posting, status performance, dan catatan dari PIMPINAN.
 * Setiap ASN mendapat satu record evaluasi per bulan.
 * 
 * @property int $id - ID unik evaluasi
 * @property int $user_id - ID ASN yang dievaluasi
 * @property int $evaluated_by - ID PIMPINAN yang memberikan evaluasi
 * @property string $notes - Catatan/feedback dari PIMPINAN
 * @property string $status - Status evaluasi (PENDING/GOOD/NEEDS_IMPROVEMENT)
 * @property int $posting_count - Jumlah posting ASN di bulan evaluasi
 * @property date $evaluation_month - Bulan evaluasi
 */
class Evaluation extends Model
{
    protected $fillable = [
        'user_id',
        'evaluated_by',
        'notes',
        'status',
        'posting_count',
        'evaluation_month',
    ];

    protected $casts = [
        'evaluation_month' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function evaluatedBy()
    {
        return $this->belongsTo(User::class, 'evaluated_by');
    }
}
