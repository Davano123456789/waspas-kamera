<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kriteria;
use App\Models\SubKriteria;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriterias = Kriteria::with('subKriteria')->orderBy('kode')->get();
        $totalBobot = Kriteria::sum('bobot');

        return view('admin.kriteria.index', compact('kriterias', 'totalBobot'));
    }

    public function create()
    {
        return view('admin.kriteria.create');
    }

    public function show($id)
    {
        $kriteria = Kriteria::with('subKriteria')->findOrFail($id);
        return view('admin.kriteria.show', compact('kriteria'));
    }

    public function edit($id)
    {
        $kriteria = Kriteria::with('subKriteria')->findOrFail($id);
        return view('admin.kriteria.edit', compact('kriteria'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:10', 'unique:kriteria,kode'],
            'nama' => ['required', 'string', 'max:255'],
            'atribut' => ['required', 'in:benefit,cost'],
            'tipe_input' => ['required', 'in:pilihan,rentang'],
            'bobot' => ['required', 'numeric', 'min:0.01'],
            'sub' => ['nullable', 'array'],
            'sub.*.nama' => ['required', 'string', 'max:255'],
            'sub.*.nilai' => ['required', 'integer', 'min:1'],
            'sub.*.nilai_min' => ['nullable', 'numeric'],
            'sub.*.nilai_maks' => ['nullable', 'numeric'],
        ], [
            'kode.unique' => 'Kode kriteria sudah digunakan.',
            'bobot.min' => 'Bobot harus bernilai positif.',
            'sub.*.nama.required' => 'Nama sub-kriteria wajib diisi.',
            'sub.*.nilai.required' => 'Skor sub-kriteria wajib diisi.',
        ]);

        if ($validated['tipe_input'] === 'rentang') {
            foreach ($validated['sub'] ?? [] as $i => $sub) {
                if (($sub['nilai_min'] ?? null) === null && ($sub['nilai_maks'] ?? null) === null) {
                    return back()->withErrors([
                        "sub.$i.nilai_min" => 'Untuk tipe input rentang, isi minimal salah satu batas (minimum atau maksimum) di setiap baris sub-kriteria.',
                    ])->withInput();
                }
            }
        }

        $kriteria = Kriteria::create([
            'kode' => $validated['kode'],
            'nama' => $validated['nama'],
            'atribut' => $validated['atribut'],
            'tipe_input' => $validated['tipe_input'],
            'bobot' => $validated['bobot'],
        ]);

        foreach ($validated['sub'] ?? [] as $sub) {
            SubKriteria::create([
                'kriteria_id' => $kriteria->id,
                'nama' => $sub['nama'],
                'nilai' => $sub['nilai'],
                'nilai_min' => $sub['nilai_min'] ?? null,
                'nilai_maks' => $sub['nilai_maks'] ?? null,
            ]);
        }

        $this->recalculateNormalizedWeights();

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $kriteria = Kriteria::findOrFail($id);

        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:10', 'unique:kriteria,kode,' . $id],
            'nama' => ['required', 'string', 'max:255'],
            'atribut' => ['required', 'in:benefit,cost'],
            'tipe_input' => ['required', 'in:pilihan,rentang'],
            'bobot' => ['required', 'numeric', 'min:0.01'],
        ]);

        $kriteria->update($validated);
        $this->recalculateNormalizedWeights();

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kriteria = Kriteria::findOrFail($id);
        $kriteria->delete();

        $this->recalculateNormalizedWeights();

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil dihapus.');
    }

    public static function recalculateNormalizedWeights()
    {
        $totalBobot = Kriteria::sum('bobot');
        if ($totalBobot > 0) {
            foreach (Kriteria::all() as $kriteria) {
                $kriteria->update([
                    'bobot_normalisasi' => $kriteria->bobot / $totalBobot
                ]);
            }
        }
    }
}
