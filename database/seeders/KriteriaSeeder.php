<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;
use App\Models\SubKriteria;

class KriteriaSeeder extends Seeder
{
    public function run(): void
    {
        // Total bobot mentah = 788, dipakai untuk bobot_normalisasi
        $totalBobot = 788;

        $kriteriasData = [
            ['kode' => 'C1', 'nama' => 'Resolusi', 'atribut' => 'benefit', 'tipe_input' => 'rentang', 'bobot' => 90],
            ['kode' => 'C2', 'nama' => 'Iso', 'atribut' => 'benefit', 'tipe_input' => 'rentang', 'bobot' => 92],
            ['kode' => 'C3', 'nama' => 'Baterai', 'atribut' => 'benefit', 'tipe_input' => 'rentang', 'bobot' => 92],
            ['kode' => 'C4', 'nama' => 'Sensor', 'atribut' => 'benefit', 'tipe_input' => 'pilihan', 'bobot' => 78],
            ['kode' => 'C5', 'nama' => 'Wifi', 'atribut' => 'benefit', 'tipe_input' => 'pilihan', 'bobot' => 78],
            ['kode' => 'C6', 'nama' => 'Stabilizer', 'atribut' => 'benefit', 'tipe_input' => 'pilihan', 'bobot' => 90],
            ['kode' => 'C7', 'nama' => 'Autofocus', 'atribut' => 'benefit', 'tipe_input' => 'rentang', 'bobot' => 94],
            ['kode' => 'C8', 'nama' => 'Kualitas Video', 'atribut' => 'benefit', 'tipe_input' => 'pilihan', 'bobot' => 86],
            ['kode' => 'C9', 'nama' => 'Kriteria Harga', 'atribut' => 'cost', 'tipe_input' => 'rentang', 'bobot' => 88],
        ];

        $kriterias = [];
        foreach ($kriteriasData as $item) {
            $kriterias[$item['kode']] = Kriteria::create([
                'kode' => $item['kode'],
                'nama' => $item['nama'],
                'atribut' => $item['atribut'],
                'tipe_input' => $item['tipe_input'],
                'bobot' => $item['bobot'],
                'bobot_normalisasi' => $item['bobot'] / $totalBobot,
            ]);
        }

        // Sub-Kriteria: kolom nilai_min/nilai_maks hanya diisi untuk kriteria tipe "rentang".
        // Konvensi: batas "> x" ditulis min = x + 1 (angka bulat berikutnya), BUKAN x.
        // Ini penting supaya nilai yang persis == x tetap jatuh ke bucket di bawahnya
        // (sesuai label, misal "51.201 – 100.000" memang menyertakan 100.000, bukan bucket ">100.000").
        $subKriteriaData = [
            'C1' => [ // Resolusi - Rentang (pakai granularitas 0.1 karena MP kamera sering desimal, mis. 24.2 MP)
                ['nama' => '> 40 MP', 'nilai' => 3, 'min' => 40.1, 'maks' => null],
                ['nama' => '25 – 40 MP', 'nilai' => 2, 'min' => 24.1, 'maks' => 40],
                ['nama' => '≤ 24 MP', 'nilai' => 1, 'min' => null, 'maks' => 24],
            ],
            'C2' => [ // ISO - Rentang
                ['nama' => '> 100.000', 'nilai' => 3, 'min' => 100001, 'maks' => null],
                ['nama' => '51.201 – 100.000', 'nilai' => 2, 'min' => 51201, 'maks' => 100000],
                ['nama' => '≤ 51.200', 'nilai' => 1, 'min' => null, 'maks' => 51200],
            ],
            'C3' => [ // Baterai - Rentang
                ['nama' => '> 800 shoot', 'nilai' => 3, 'min' => 801, 'maks' => null],
                ['nama' => '401 shoot – 800 shoot', 'nilai' => 2, 'min' => 401, 'maks' => 800],
                ['nama' => '≤ 400 shoot', 'nilai' => 1, 'min' => null, 'maks' => 400],
            ],
            'C4' => [ // Sensor - Pilihan
                ['nama' => 'Full Frame', 'nilai' => 2],
                ['nama' => 'APS-C', 'nilai' => 1],
            ],
            'C5' => [ // Wifi - Pilihan
                ['nama' => 'Ada', 'nilai' => 2],
                ['nama' => 'Tidak ada', 'nilai' => 1],
            ],
            'C6' => [ // Stabilizer - Pilihan
                ['nama' => 'Ada', 'nilai' => 2],
                ['nama' => 'Tidak ada', 'nilai' => 1],
            ],
            'C7' => [ // Autofocus - Rentang
                ['nama' => '> 200 titik', 'nilai' => 3, 'min' => 201, 'maks' => null],
                ['nama' => '51 – 200 titik', 'nilai' => 2, 'min' => 51, 'maks' => 200],
                ['nama' => '≤ 50 titik', 'nilai' => 1, 'min' => null, 'maks' => 50],
            ],
            'C8' => [ // Kualitas Video - Pilihan
                ['nama' => '8K', 'nilai' => 3],
                ['nama' => '4K', 'nilai' => 2],
                ['nama' => 'Full HD', 'nilai' => 1],
            ],
            'C9' => [ // Harga - Rentang
                ['nama' => '≤ Rp 5.000.000', 'nilai' => 5, 'min' => null, 'maks' => 5000000],
                ['nama' => 'Rp 5.000.000 – Rp 10.000.000', 'nilai' => 4, 'min' => 5000001, 'maks' => 10000000],
                ['nama' => 'Rp 10.000.000 – Rp 20.000.000', 'nilai' => 3, 'min' => 10000001, 'maks' => 20000000],
                ['nama' => 'Rp 20.000.000 – Rp 30.000.000', 'nilai' => 2, 'min' => 20000001, 'maks' => 30000000],
                ['nama' => '> Rp 30.000.000', 'nilai' => 1, 'min' => 30000001, 'maks' => null],
            ],
        ];

        foreach ($subKriteriaData as $kodeKriteria => $subs) {
            foreach ($subs as $s) {
                SubKriteria::create([
                    'kriteria_id' => $kriterias[$kodeKriteria]->id,
                    'nama' => $s['nama'],
                    'nilai' => $s['nilai'],
                    'nilai_min' => $s['min'] ?? null,
                    'nilai_maks' => $s['maks'] ?? null,
                ]);
            }
        }
    }
}
