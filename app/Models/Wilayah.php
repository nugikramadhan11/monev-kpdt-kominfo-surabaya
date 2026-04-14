<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Wilayah Model - Mewakili wilayah/daerah administratif
 * 
 * Model ini merepresentasikan wilayah geografis dalam sistem.
 * Setiap Wilayah dapat memiliki banyak OPD dan pengguna (ASN/PIMPINAN).
 * Wilayah digunakan untuk mengorganisir data posting berdasarkan lokasi.
 * 
 * @property int $id - ID unik wilayah
 * @property string $name - Nama wilayah
 * @property string $code - Kode unik wilayah
 */
class Wilayah extends Model
{
    protected $fillable = ['name', 'code'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function opds()
    {
        return $this->hasMany(OPD::class);
    }

    public function postings()
    {
        return $this->hasMany(Posting::class);
    }
}
