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

        // 2. Seed Kamera (Alternatif) - 41 kamera sesuai Excel "DATA KAMERA (2).xlsx" (Sheet2)
        $kameraData = [
            ['kode' => 'A1', 'nama' => 'Canon EOS R6 Mark ii', 'merk' => 'Canon', 'deskripsi' => 'Sensor Full Frame, 24.2 MP, video 4K'],
            ['kode' => 'A2', 'nama' => 'Canon EOS RP', 'merk' => 'Canon', 'deskripsi' => 'Sensor Full Frame, 26.2 MP, video 4K'],
            ['kode' => 'A3', 'nama' => 'Canon EOS R8', 'merk' => 'Canon', 'deskripsi' => 'Sensor Full Frame, 24.2 MP, video 4K'],
            ['kode' => 'A4', 'nama' => 'Canon EOS R5 Mark ii', 'merk' => 'Canon', 'deskripsi' => 'Sensor Full Frame, 45 MP, video 8K'],
            ['kode' => 'A5', 'nama' => 'Canon EOS R5', 'merk' => 'Canon', 'deskripsi' => 'Sensor Full Frame, 45 MP, video 8K'],
            ['kode' => 'A6', 'nama' => 'Canon EOS R6 Mark iii', 'merk' => 'Canon', 'deskripsi' => 'Sensor Full Frame, 24 MP, video 4K'],
            ['kode' => 'A7', 'nama' => 'Canon EOS R50', 'merk' => 'Canon', 'deskripsi' => 'Sensor APS-C, 24.2 MP, video 4K'],
            ['kode' => 'A8', 'nama' => 'Canon EOS 6D Mark ii', 'merk' => 'Canon', 'deskripsi' => 'Sensor Full Frame, 26.2 MP, video Full HD'],
            ['kode' => 'A9', 'nama' => 'Canon EOS 60D', 'merk' => 'Canon', 'deskripsi' => 'Sensor APS-C, 18 MP, video Full HD'],
            ['kode' => 'A10', 'nama' => 'Canon EOS 1300D', 'merk' => 'Canon', 'deskripsi' => 'Sensor APS-C, 18 MP, video Full HD'],
            ['kode' => 'A11', 'nama' => 'Sony A7 IV', 'merk' => 'Sony', 'deskripsi' => 'Sensor Full Frame, 33 MP, video 4K'],
            ['kode' => 'A12', 'nama' => 'Sony A7 III', 'merk' => 'Sony', 'deskripsi' => 'Sensor Full Frame, 24.2 MP, video 4K'],
            ['kode' => 'A13', 'nama' => 'Sony A7R V', 'merk' => 'Sony', 'deskripsi' => 'Sensor Full Frame, 61 MP, video 4K'],
            ['kode' => 'A14', 'nama' => 'Sony A6400', 'merk' => 'Sony', 'deskripsi' => 'Sensor APS-C, 24.2 MP, video 4K'],
            ['kode' => 'A15', 'nama' => 'Sony A6600', 'merk' => 'Sony', 'deskripsi' => 'Sensor APS-C, 24.2 MP, video 4K'],
            ['kode' => 'A16', 'nama' => 'Sony ZV-E10', 'merk' => 'Sony', 'deskripsi' => 'Sensor APS-C, 24.2 MP, video 4K'],
            ['kode' => 'A17', 'nama' => 'Sony A1', 'merk' => 'Sony', 'deskripsi' => 'Sensor Full Frame, 50.1 MP, video 8K'],
            ['kode' => 'A18', 'nama' => 'Sony A7c II', 'merk' => 'Sony', 'deskripsi' => 'Sensor Full Frame, 33 MP, video 4K'],
            ['kode' => 'A19', 'nama' => 'Sony A6000', 'merk' => 'Sony', 'deskripsi' => 'Sensor APS-C, 24 MP, video Full HD'],
            ['kode' => 'A20', 'nama' => 'Lumix S5 Mark II', 'merk' => 'Lumix', 'deskripsi' => 'Sensor Full Frame, 24.2 MP, video 4K'],
            ['kode' => 'A21', 'nama' => 'Lumix G97', 'merk' => 'Lumix', 'deskripsi' => 'Sensor APS-C, 20.3 MP, video 4K'],
            ['kode' => 'A22', 'nama' => 'Lumix S1 Mark II E', 'merk' => 'Lumix', 'deskripsi' => 'Sensor Full Frame, 24.2 MP, video 8K'],
            ['kode' => 'A23', 'nama' => 'Lumix S9', 'merk' => 'Lumix', 'deskripsi' => 'Sensor Full Frame, 24.2 MP, video 4K'],
            ['kode' => 'A24', 'nama' => 'Lumix G9 Mark II', 'merk' => 'Lumix', 'deskripsi' => 'Sensor APS-C, 25.2 MP, video 4K'],
            ['kode' => 'A25', 'nama' => 'Fujifilm X-T5', 'merk' => 'Fujifilm', 'deskripsi' => 'Sensor APS-C, 40.2 MP, video 4K'],
            ['kode' => 'A26', 'nama' => 'Fujifilm X-T4', 'merk' => 'Fujifilm', 'deskripsi' => 'Sensor APS-C, 26.1 MP, video 4K'],
            ['kode' => 'A27', 'nama' => 'Fujifilm X-S20', 'merk' => 'Fujifilm', 'deskripsi' => 'Sensor APS-C, 26.1 MP, video 4K'],
            ['kode' => 'A28', 'nama' => 'Fujifilm X-H2', 'merk' => 'Fujifilm', 'deskripsi' => 'Sensor APS-C, 40.2 MP, video 8K'],
            ['kode' => 'A29', 'nama' => 'Fujifilm X-H2S', 'merk' => 'Fujifilm', 'deskripsi' => 'Sensor APS-C, 26.1 MP, video 8K'],
            ['kode' => 'A30', 'nama' => 'Fujifilm X-T30 II', 'merk' => 'Fujifilm', 'deskripsi' => 'Sensor APS-C, 26.1 MP, video 4K'],
            ['kode' => 'A31', 'nama' => 'Fujifilm X-Pro3', 'merk' => 'Fujifilm', 'deskripsi' => 'Sensor APS-C, 26.1 MP, video 4K'],
            ['kode' => 'A32', 'nama' => 'Fujifilm X-T100', 'merk' => 'Fujifilm', 'deskripsi' => 'Sensor APS-C, 24 MP, video 4K'],
            ['kode' => 'A33', 'nama' => 'Nikon Z9', 'merk' => 'Nikon', 'deskripsi' => 'Sensor Full Frame, 45.7 MP, video 8K'],
            ['kode' => 'A34', 'nama' => 'Nikon Z8', 'merk' => 'Nikon', 'deskripsi' => 'Sensor Full Frame, 45.7 MP, video 8K'],
            ['kode' => 'A35', 'nama' => 'Nikon Z7 II', 'merk' => 'Nikon', 'deskripsi' => 'Sensor Full Frame, 45.7 MP, video 4K'],
            ['kode' => 'A36', 'nama' => 'Nikon Z6 II', 'merk' => 'Nikon', 'deskripsi' => 'Sensor Full Frame, 24.5 MP, video 4K'],
            ['kode' => 'A37', 'nama' => 'Nikon Z5', 'merk' => 'Nikon', 'deskripsi' => 'Sensor Full Frame, 24.3 MP, video 4K'],
            ['kode' => 'A38', 'nama' => 'Nikon D850', 'merk' => 'Nikon', 'deskripsi' => 'Sensor Full Frame, 45.7 MP, video Full HD'],
            ['kode' => 'A39', 'nama' => 'Nikon D780', 'merk' => 'Nikon', 'deskripsi' => 'Sensor Full Frame, 24.5 MP, video Full HD'],
            ['kode' => 'A40', 'nama' => 'Nikon Z50', 'merk' => 'Nikon', 'deskripsi' => 'Sensor APS-C, 20.9 MP, video 4K'],
            ['kode' => 'A41', 'nama' => 'Nikon Z30', 'merk' => 'Nikon', 'deskripsi' => 'Sensor APS-C, 20.9 MP, video 4K'],
        ];

        foreach ($kameraData as $k) {
            Kamera::create($k);
        }
    }
}
