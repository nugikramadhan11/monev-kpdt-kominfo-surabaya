<?php

namespace Database\Seeders;

use App\Models\OPD;
use Illuminate\Database\Seeder;

class OpdSeeder extends Seeder
{
    public function run(): void
    {
        $opds = [
            ['name' => 'Dinas Komunikasi', 'kode' => 'DK-001', 'wilayah_id' => 1],
            ['name' => 'Dinas Sosial', 'kode' => 'DS-001', 'wilayah_id' => 2],
            ['name' => 'Dinas Lingkungan', 'kode' => 'DL-001', 'wilayah_id' => 3],
            ['name' => 'Dinas Pendidikan', 'kode' => 'DP-001', 'wilayah_id' => 4],
            ['name' => 'Dinas Kesehatan', 'kode' => 'DKes-001', 'wilayah_id' => 5],
        ];

        foreach ($opds as $opd) {
            OPD::firstOrCreate(['kode' => $opd['kode']], $opd);
        }
    }
}
