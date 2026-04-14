<?php

namespace Database\Seeders;

use App\Models\Pilar;
use Illuminate\Database\Seeder;

class PilarSeeder extends Seeder
{
    public function run(): void
    {
        $pilars = [
            [
                'name' => 'Lingkungan',
                'hashtag' => '#PilarLingkungan',
                'color' => '#10b981',
                'icon' => '🌱',
            ],
            [
                'name' => 'Sosbud',
                'hashtag' => '#PilarSosbud',
                'color' => '#f59e0b',
                'icon' => '👥',
            ],
            [
                'name' => 'Ekonomi',
                'hashtag' => '#PilarEkonomi',
                'color' => '#3b82f6',
                'icon' => '💰',
            ],
            [
                'name' => 'Kemasyarakatan',
                'hashtag' => '#PilarKemasyarakatan',
                'color' => '#ef4444',
                'icon' => '🏘️',
            ],
        ];

        foreach ($pilars as $pilar) {
            Pilar::firstOrCreate(['hashtag' => $pilar['hashtag']], $pilar);
        }
    }
}
