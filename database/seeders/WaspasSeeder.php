<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kamera;

class WaspasSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Users (Admin & User)
        User::create([
            'name' => 'Admin WASPAS',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'User Buyer',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // 2. Seed Kamera (Alternatif)
        $kameraData = [
            [
                'kode' => 'A1',
                'nama' => 'Canon EOS 60D',
                'merk' => 'Canon',
                'deskripsi' => 'Kamera DSLR Canon legendaris untuk pemula',
            ],
            [
                'kode' => 'A2',
                'nama' => 'Sony A7 IV',
                'merk' => 'Sony',
                'deskripsi' => 'Kamera mirrorless full-frame hybrid favorit',
            ],
            [
                'kode' => 'A3',
                'nama' => 'Lumix S5 II',
                'merk' => 'Lumix',
                'deskripsi' => 'Kamera mirrorless full-frame andalan videografer',
            ],
            [
                'kode' => 'A4',
                'nama' => 'Fujifilm X-T5',
                'merk' => 'Fujifilm',
                'deskripsi' => 'Kamera APS-C dengan warna khas film simulation',
            ],
            [
                'kode' => 'A5',
                'nama' => 'Nikon Z9',
                'merk' => 'Nikon',
                'deskripsi' => 'Kamera flagship profesional terbaik',
            ],
        ];

        foreach ($kameraData as $k) {
            Kamera::create($k);
        }
    }
}
