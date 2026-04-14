<?php

namespace Database\Seeders;

use App\Models\Wilayah;
use Illuminate\Database\Seeder;

class WilayahSeeder extends Seeder
{
    public function run(): void
    {
        $wilayahs = [
            ['name' => 'Bubutan', 'code' => 'SBY-001'],
            ['name' => 'Gubeng', 'code' => 'SBY-002'],
            ['name' => 'Sukolilo', 'code' => 'SBY-003'],
            ['name' => 'Tegalsari', 'code' => 'SBY-004'],
            ['name' => 'Wonokromo', 'code' => 'SBY-005'],
        ];

        foreach ($wilayahs as $wilayah) {
            Wilayah::firstOrCreate($wilayah);
        }
    }
}
