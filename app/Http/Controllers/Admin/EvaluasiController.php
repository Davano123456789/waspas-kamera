<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kamera;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use App\Models\Evaluasi;

class EvaluasiController extends Controller
{
    public function index()
    {
        $kriterias = Kriteria::orderBy('kode')->get();
        $kameras = Kamera::with('evaluasi')->orderBy('kode')->get();

        return view('admin.evaluasi.index', compact('kriterias', 'kameras'));
    }

    public function edit($kameraId)
    {
        $kamera = Kamera::findOrFail($kameraId);
        $kriterias = Kriteria::with('subKriteria')->orderBy('kode')->get();

        $existingEvaluasi = Evaluasi::where('kamera_id', $kameraId)
            ->get()
            ->keyBy('kriteria_id');

        return view('admin.evaluasi.edit', compact('kamera', 'kriterias', 'existingEvaluasi'));
    }

    public function storeOrUpdate(Request $request, $kameraId)
    {
        $kamera = Kamera::findOrFail($kameraId);
        $evaluasiInput = $request->input('evaluasi', []);
        $kriterias = Kriteria::whereIn('id', array_keys($evaluasiInput))->get()->keyBy('id');

        foreach ($evaluasiInput as $kriteriaId => $data) {
            $kriteria = $kriterias->get($kriteriaId);

            if ($kriteria && $kriteria->tipe_input === 'rentang') {
                $nilaiManual = $data['nilai_manual'] ?? null;

                if ($nilaiManual === null || $nilaiManual === '') {
                    return back()->withErrors([
                        "evaluasi.$kriteriaId" => 'Nilai untuk kriteria ' . $kriteria->nama . ' wajib diisi.',
                    ])->withInput();
                }

                $match = SubKriteria::matchForValue($kriteriaId, (float) $nilaiManual);

                if (!$match) {
                    return back()->withErrors([
                        "evaluasi.$kriteriaId" => 'Nilai ' . $nilaiManual . ' untuk kriteria ' . $kriteria->nama . ' tidak masuk rentang sub-kriteria manapun. Lengkapi rentang sub-kriteria terlebih dahulu.',
                    ])->withInput();
                }

                Evaluasi::updateOrCreate(
                    [
                        'kamera_id' => $kameraId,
                        'kriteria_id' => $kriteriaId,
                    ],
                    [
                        'sub_kriteria_id' => $match->id,
                        'nilai' => $match->nilai,
                        'nilai_asli' => $nilaiManual,
                    ]
                );

                continue;
            }

            $subKriteriaId = $data['sub_kriteria_id'] ?? null;
            $nilai = $data['nilai'] ?? 1;
            $nilaiAsli = $data['nilai_asli'] ?? null;

            // If sub_kriteria_id is selected, get its default score & name
            if ($subKriteriaId) {
                $sub = SubKriteria::find($subKriteriaId);
                if ($sub) {
                    $nilai = $sub->nilai;
                    if (empty($nilaiAsli)) {
                        $nilaiAsli = $sub->nama;
                    }
                }
            }

            Evaluasi::updateOrCreate(
                [
                    'kamera_id' => $kameraId,
                    'kriteria_id' => $kriteriaId,
                ],
                [
                    'sub_kriteria_id' => $subKriteriaId ?: null,
                    'nilai' => $nilai,
                    'nilai_asli' => $nilaiAsli,
                ]
            );
        }

        return redirect()->route('evaluasi.index')->with('success', 'Matriks penilaian untuk ' . $kamera->nama . ' berhasil diperbarui.');
    }
}
