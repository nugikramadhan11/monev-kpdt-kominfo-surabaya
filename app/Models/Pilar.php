<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Pilar Model - Kategori/Pilar untuk posting
 * 
 * Model ini merepresentasikan kategori atau pilar untuk mengklasifikasikan posting.
 * Setiap posting harus dikategorikan ke salah satu pilar dengan hashtag spesifik.
 * Pilar memiliki warna dan icon untuk identifikasi visual di UI.
 * 
 * @property int $id - ID unik pilar
 * @property string $name - Nama pilar
 * @property string $hashtag - Hashtag terkait pilar (contoh: #KualitasLayanan)
 * @property string $color - Warna hex untuk pilar
 * @property string $icon - Icon/emoji untuk pilar
 */
class Pilar extends Model
{
    protected $fillable = ['name', 'hashtag', 'color', 'icon'];

    public function postings()
    {
        return $this->hasMany(Posting::class);
    }
}
