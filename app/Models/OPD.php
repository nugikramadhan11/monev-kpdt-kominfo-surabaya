<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * OPD Model - Organisasi Perangkat Daerah
 * 
 * Model ini merepresentasikan organisasi/dinas di daerah.
 * Setiap OPD berada di bawah satu Wilayah dan memiliki banyak user ASN.
 * 
 * @property int $id - ID unik OPD
 * @property int $wilayah_id - ID Wilayah OPD berada
 * @property string $name - Nama OPD
 * @property string $kode - Kode unik OPD
 */
class OPD extends Model
{
    protected $table = 'opds';
    protected $fillable = ['name', 'kode', 'wilayah_id'];

    public function wilayah()
    {
        return $this->belongsTo(Wilayah::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
