<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * PostingEngagement Model - Mewakili engagement data posting
 * 
 * Model ini menangani data engagement (interaksi) untuk setiap posting.
 * Engagement mencakup jumlah likes, comments, dan shares dari suatu posting.
 * Setiap posting memiliki satu record engagement yang automatically dibuat saat posting dibuat.
 * 
 * @property int $id - ID unik engagement
 * @property int $posting_id - ID posting yang terkait
 * @property int $likes - Jumlah likes yang diterima posting
 * @property int $comments - Jumlah comments yang diterima posting
 * @property int $shares - Jumlah shares yang diterima posting
 */
class PostingEngagement extends Model
{
    protected $fillable = ['posting_id', 'likes', 'comments', 'shares'];

    public function posting()
    {
        return $this->belongsTo(Posting::class);
    }

    /**
     * Hitung total engagement (likes + comments + shares)
     * Digunakan untuk menampilkan ringkasan engagement di UI
     * 
     * @return int Total engagement
     */
    public function getTotalEngagement()
    {
        return $this->likes + $this->comments + $this->shares;
    }
}
