<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evaluasi;
use App\Models\Kamera;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use RuntimeException;

class EvaluasiSeeder extends Seeder
{
    /**
     * Data spesifikasi asli tiap kamera (sumber: Excel "DATA KAMERA (2).xlsx", Sheet2 baris 2-42).
     * - Kriteria tipe "rentang" (C1, C2, C3, C7, C9): diisi angka asli, skornya dicari
     *   otomatis lewat SubKriteria::matchForValue() - sama seperti input admin.
     * - Kriteria tipe "pilihan" (C4, C5, C6, C8): diisi nama sub-kriteria.
     */
    private array $data = [
            'A1' => ['C1' => 24.2, 'C2' => 102400, 'C3' => 580, 'C4' => 'Full Frame', 'C5' => 'Ada', 'C6' => 'Ada', 'C7' => 6072, 'C8' => '4K', 'C9' => 35599000], // Canon EOS R6 Mark ii
            'A2' => ['C1' => 26.2, 'C2' => 102400, 'C3' => 250, 'C4' => 'Full Frame', 'C5' => 'Ada', 'C6' => 'Tidak ada', 'C7' => 4779, 'C8' => '4K', 'C9' => 16074025], // Canon EOS RP
            'A3' => ['C1' => 24.2, 'C2' => 102400, 'C3' => 370, 'C4' => 'Full Frame', 'C5' => 'Ada', 'C6' => 'Tidak ada', 'C7' => 1053, 'C8' => '4K', 'C9' => 23699500], // Canon EOS R8
            'A4' => ['C1' => 45, 'C2' => 51200, 'C3' => 320, 'C4' => 'Full Frame', 'C5' => 'Ada', 'C6' => 'Ada', 'C7' => 6000, 'C8' => '8K', 'C9' => 82399500], // Canon EOS R5 Mark ii
            'A5' => ['C1' => 45, 'C2' => 51200, 'C3' => 320, 'C4' => 'Full Frame', 'C5' => 'Ada', 'C6' => 'Ada', 'C7' => 5940, 'C8' => '8K', 'C9' => 76827000], // Canon EOS R5
            'A6' => ['C1' => 24, 'C2' => 102400, 'C3' => 600, 'C4' => 'Full Frame', 'C5' => 'Ada', 'C6' => 'Ada', 'C7' => 6000, 'C8' => '4K', 'C9' => 51999000], // Canon EOS R6 Mark iii
            'A7' => ['C1' => 24.2, 'C2' => 51200, 'C3' => 310, 'C4' => 'APS-C', 'C5' => 'Ada', 'C6' => 'Tidak ada', 'C7' => 651, 'C8' => '4K', 'C9' => 9449000], // Canon EOS R50
            'A8' => ['C1' => 26.2, 'C2' => 40000, 'C3' => 1200, 'C4' => 'Full Frame', 'C5' => 'Ada', 'C6' => 'Tidak ada', 'C7' => 45, 'C8' => 'Full HD', 'C9' => 15249500], // Canon EOS 6D Mark ii
            'A9' => ['C1' => 18, 'C2' => 6400, 'C3' => 1100, 'C4' => 'APS-C', 'C5' => 'Tidak ada', 'C6' => 'Tidak ada', 'C7' => 9, 'C8' => 'Full HD', 'C9' => 3606450], // Canon EOS 60D
            'A10' => ['C1' => 18, 'C2' => 6400, 'C3' => 500, 'C4' => 'APS-C', 'C5' => 'Ada', 'C6' => 'Tidak ada', 'C7' => 9, 'C8' => 'Full HD', 'C9' => 2638000], // Canon EOS 1300D
            'A11' => ['C1' => 33, 'C2' => 102400, 'C3' => 580, 'C4' => 'Full Frame', 'C5' => 'Ada', 'C6' => 'Ada', 'C7' => 759, 'C8' => '4K', 'C9' => 32989000], // Sony A7 IV
            'A12' => ['C1' => 24.2, 'C2' => 204800, 'C3' => 710, 'C4' => 'Full Frame', 'C5' => 'Ada', 'C6' => 'Ada', 'C7' => 693, 'C8' => '4K', 'C9' => 16074025], // Sony A7 III
            'A13' => ['C1' => 61, 'C2' => 102400, 'C3' => 530, 'C4' => 'Full Frame', 'C5' => 'Ada', 'C6' => 'Ada', 'C7' => 693, 'C8' => '4K', 'C9' => 23699500], // Sony A7R V
            'A14' => ['C1' => 24.2, 'C2' => 102400, 'C3' => 410, 'C4' => 'APS-C', 'C5' => 'Ada', 'C6' => 'Tidak ada', 'C7' => 425, 'C8' => '4K', 'C9' => 12694000], // Sony A6400
            'A15' => ['C1' => 24.2, 'C2' => 102400, 'C3' => 720, 'C4' => 'APS-C', 'C5' => 'Ada', 'C6' => 'Ada', 'C7' => 425, 'C8' => '4K', 'C9' => 12920000], // Sony A6600
            'A16' => ['C1' => 24.2, 'C2' => 51200, 'C3' => 440, 'C4' => 'APS-C', 'C5' => 'Ada', 'C6' => 'Tidak ada', 'C7' => 425, 'C8' => '4K', 'C9' => 10994000], // Sony ZV-E10
            'A17' => ['C1' => 50.1, 'C2' => 102400, 'C3' => 530, 'C4' => 'Full Frame', 'C5' => 'Ada', 'C6' => 'Ada', 'C7' => 759, 'C8' => '8K', 'C9' => 82949000], // Sony A1
            'A18' => ['C1' => 33, 'C2' => 204800, 'C3' => 740, 'C4' => 'Full Frame', 'C5' => 'Ada', 'C6' => 'Ada', 'C7' => 759, 'C8' => '4K', 'C9' => 28894000], // Sony A7c II
            'A19' => ['C1' => 24, 'C2' => 25600, 'C3' => 360, 'C4' => 'APS-C', 'C5' => 'Ada', 'C6' => 'Tidak ada', 'C7' => 179, 'C8' => 'Full HD', 'C9' => 6500000], // Sony A6000
            'A20' => ['C1' => 24.2, 'C2' => 204800, 'C3' => 370, 'C4' => 'Full Frame', 'C5' => 'Ada', 'C6' => 'Ada', 'C7' => 779, 'C8' => '4K', 'C9' => 23239500], // Lumix S5 Mark II
            'A21' => ['C1' => 20.3, 'C2' => 25600, 'C3' => 290, 'C4' => 'APS-C', 'C5' => 'Ada', 'C6' => 'Ada', 'C7' => 49, 'C8' => '4K', 'C9' => 12999000], // Lumix G97
            'A22' => ['C1' => 24.2, 'C2' => 51200, 'C3' => 400, 'C4' => 'Full Frame', 'C5' => 'Ada', 'C6' => 'Ada', 'C7' => 779, 'C8' => '8K', 'C9' => 37862000], // Lumix S1 Mark II E
            'A23' => ['C1' => 24.2, 'C2' => 51200, 'C3' => 300, 'C4' => 'Full Frame', 'C5' => 'Ada', 'C6' => 'Ada', 'C7' => 779, 'C8' => '4K', 'C9' => 20999000], // Lumix S9
            'A24' => ['C1' => 25.2, 'C2' => 25600, 'C3' => 400, 'C4' => 'APS-C', 'C5' => 'Ada', 'C6' => 'Ada', 'C7' => 779, 'C8' => '4K', 'C9' => 18999500], // Lumix G9 Mark II
            'A25' => ['C1' => 40.2, 'C2' => 51200, 'C3' => 580, 'C4' => 'APS-C', 'C5' => 'Ada', 'C6' => 'Ada', 'C7' => 425, 'C8' => '4K', 'C9' => 25699000], // Fujifilm X-T5
            'A26' => ['C1' => 26.1, 'C2' => 51200, 'C3' => 600, 'C4' => 'APS-C', 'C5' => 'Ada', 'C6' => 'Ada', 'C7' => 425, 'C8' => '4K', 'C9' => 16074025], // Fujifilm X-T4
            'A27' => ['C1' => 26.1, 'C2' => 51200, 'C3' => 750, 'C4' => 'APS-C', 'C5' => 'Ada', 'C6' => 'Ada', 'C7' => 425, 'C8' => '4K', 'C9' => 20724000], // Fujifilm X-S20
            'A28' => ['C1' => 40.2, 'C2' => 51200, 'C3' => 680, 'C4' => 'APS-C', 'C5' => 'Ada', 'C6' => 'Ada', 'C7' => 425, 'C8' => '8K', 'C9' => 29749000], // Fujifilm X-H2
            'A29' => ['C1' => 26.1, 'C2' => 51200, 'C3' => 720, 'C4' => 'APS-C', 'C5' => 'Ada', 'C6' => 'Ada', 'C7' => 425, 'C8' => '8K', 'C9' => 36499000], // Fujifilm X-H2S
            'A30' => ['C1' => 26.1, 'C2' => 51200, 'C3' => 380, 'C4' => 'APS-C', 'C5' => 'Ada', 'C6' => 'Tidak ada', 'C7' => 425, 'C8' => '4K', 'C9' => 13119500], // Fujifilm X-T30 II
            'A31' => ['C1' => 26.1, 'C2' => 51200, 'C3' => 440, 'C4' => 'APS-C', 'C5' => 'Ada', 'C6' => 'Tidak ada', 'C7' => 425, 'C8' => '4K', 'C9' => 28649000], // Fujifilm X-Pro3
            'A32' => ['C1' => 24, 'C2' => 51200, 'C3' => 330, 'C4' => 'APS-C', 'C5' => 'Ada', 'C6' => 'Tidak ada', 'C7' => 91, 'C8' => '4K', 'C9' => 6800000], // Fujifilm X-T100
            'A33' => ['C1' => 45.7, 'C2' => 102400, 'C3' => 740, 'C4' => 'Full Frame', 'C5' => 'Ada', 'C6' => 'Ada', 'C7' => 493, 'C8' => '8K', 'C9' => 98999000], // Nikon Z9
            'A34' => ['C1' => 45.7, 'C2' => 102400, 'C3' => 340, 'C4' => 'Full Frame', 'C5' => 'Ada', 'C6' => 'Ada', 'C7' => 493, 'C8' => '8K', 'C9' => 59499000], // Nikon Z8
            'A35' => ['C1' => 45.7, 'C2' => 51200, 'C3' => 420, 'C4' => 'Full Frame', 'C5' => 'Ada', 'C6' => 'Ada', 'C7' => 493, 'C8' => '4K', 'C9' => 43799000], // Nikon Z7 II
            'A36' => ['C1' => 24.5, 'C2' => 51200, 'C3' => 410, 'C4' => 'Full Frame', 'C5' => 'Ada', 'C6' => 'Ada', 'C7' => 273, 'C8' => '4K', 'C9' => 23859500], // Nikon Z6 II
            'A37' => ['C1' => 24.3, 'C2' => 51200, 'C3' => 470, 'C4' => 'Full Frame', 'C5' => 'Ada', 'C6' => 'Ada', 'C7' => 273, 'C8' => '4K', 'C9' => 14849000], // Nikon Z5
            'A38' => ['C1' => 45.7, 'C2' => 25600, 'C3' => 1840, 'C4' => 'Full Frame', 'C5' => 'Ada', 'C6' => 'Tidak ada', 'C7' => 153, 'C8' => 'Full HD', 'C9' => 39849500], // Nikon D850
            'A39' => ['C1' => 24.5, 'C2' => 51200, 'C3' => 2260, 'C4' => 'Full Frame', 'C5' => 'Ada', 'C6' => 'Tidak ada', 'C7' => 51, 'C8' => 'Full HD', 'C9' => 22140000], // Nikon D780
            'A40' => ['C1' => 20.9, 'C2' => 51200, 'C3' => 320, 'C4' => 'APS-C', 'C5' => 'Ada', 'C6' => 'Tidak ada', 'C7' => 209, 'C8' => '4K', 'C9' => 13999000], // Nikon Z50
            'A41' => ['C1' => 20.9, 'C2' => 51200, 'C3' => 330, 'C4' => 'APS-C', 'C5' => 'Ada', 'C6' => 'Tidak ada', 'C7' => 209, 'C8' => '4K', 'C9' => 9899000], // Nikon Z30
    ];

    public function run(): void
    {
        $kriterias = Kriteria::with('subKriteria')->get()->keyBy('kode');
        $kameras = Kamera::all()->keyBy('kode');

        foreach ($this->data as $kodeKamera => $nilaiPerKriteria) {
            $kamera = $kameras->get($kodeKamera)
                ?? throw new RuntimeException("Kamera {$kodeKamera} belum ada. Jalankan WaspasSeeder dulu.");

            foreach ($nilaiPerKriteria as $kodeKriteria => $nilaiAsli) {
                $kriteria = $kriterias->get($kodeKriteria)
                    ?? throw new RuntimeException("Kriteria {$kodeKriteria} belum ada. Jalankan KriteriaSeeder dulu.");

                $sub = $kriteria->tipe_input === 'rentang'
                    ? SubKriteria::matchForValue($kriteria->id, (float) $nilaiAsli)
                    : $kriteria->subKriteria->firstWhere('nama', $nilaiAsli);

                if (!$sub) {
                    throw new RuntimeException("Nilai '{$nilaiAsli}' untuk {$kodeKriteria} ({$kodeKamera}) tidak cocok dengan sub-kriteria manapun.");
                }

                Evaluasi::updateOrCreate(
                    ['kamera_id' => $kamera->id, 'kriteria_id' => $kriteria->id],
                    ['sub_kriteria_id' => $sub->id, 'nilai' => $sub->nilai, 'nilai_asli' => (string) $nilaiAsli]
                );
            }
        }
    }
}
