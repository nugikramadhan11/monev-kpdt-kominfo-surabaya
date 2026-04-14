<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::firstOrCreate(
            ['nip' => '199001012018041001'],
            [
                'name' => 'Luffy',
                'email' => 'luffy@kpdt.local',
                'password' => Hash::make('luffy123'),
            ]
        );
        $admin->assignRole('ADMIN');

        // Pimpinan untuk setiap wilayah
        $pimpinans = [
            ['name' => 'Jinbei', 'nip' => '197505222005011001', 'wilayah_id' => 1, 'password' => 'jinbei123'],
            ['name' => 'Boa', 'nip' => '197506232006012001', 'wilayah_id' => 2, 'password' => 'boa123'],
            ['name' => 'Hancock', 'nip' => '197507242007013001', 'wilayah_id' => 3, 'password' => 'hancock123'],
            ['name' => 'Crocodile', 'nip' => '197508252008014001', 'wilayah_id' => 4, 'password' => 'crocodile123'],
            ['name' => 'Mihawk', 'nip' => '197509262009015001', 'wilayah_id' => 5, 'password' => 'mihawk123'],
        ];

        foreach ($pimpinans as $data) {
            $pimpinan = User::firstOrCreate(
                ['nip' => $data['nip']],
                [
                    'name' => $data['name'],
                    'email' => strtolower($data['name']) . '@kpdt.local',
                    'wilayah_id' => $data['wilayah_id'],
                    'password' => Hash::make($data['password']),
                ]
            );
            $pimpinan->assignRole('PIMPINAN');
        }

        // ASN
        $asnData = [
            ['name' => 'Nami', 'nip' => '198905122015032001', 'wilayah_id' => 1, 'opd_id' => 1, 'password' => 'nami123'],
            ['name' => 'Robin', 'nip' => '198707152014022002', 'wilayah_id' => 2, 'opd_id' => 2, 'password' => 'robin123'],
            ['name' => 'Chopper', 'nip' => '199912012020031003', 'wilayah_id' => 3, 'opd_id' => 3, 'password' => 'chopper123'],
            ['name' => 'Sanji', 'nip' => '198803102013021004', 'wilayah_id' => 4, 'opd_id' => 4, 'password' => 'sanji123'],
            ['name' => 'Zoro', 'nip' => '198606182012011005', 'wilayah_id' => 5, 'opd_id' => 5, 'password' => 'zoro123'],
        ];

        foreach ($asnData as $data) {
            $asn = User::firstOrCreate(
                ['nip' => $data['nip']],
                [
                    'name' => $data['name'],
                    'email' => strtolower($data['name']) . '@kpdt.local',
                    'wilayah_id' => $data['wilayah_id'],
                    'opd_id' => $data['opd_id'],
                    'password' => Hash::make($data['password']),
                ]
            );
            $asn->assignRole('ASN');
        }
    }
}

