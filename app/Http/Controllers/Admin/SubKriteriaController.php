<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubKriteria;

class SubKriteriaController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kriteria_id' => ['required', 'exists:kriteria,id'],
            'nama' => ['required', 'string', 'max:255'],
            'nilai' => ['required', 'integer', 'min:1'],
            'nilai_min' => ['nullable', 'numeric'],
            'nilai_maks' => ['nullable', 'numeric'],
        ]);

        SubKriteria::create($validated);

        return redirect()->route('kriteria.index')->with('success', 'Sub-Kriteria berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $subKriteria = SubKriteria::findOrFail($id);

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nilai' => ['required', 'integer', 'min:1'],
            'nilai_min' => ['nullable', 'numeric'],
            'nilai_maks' => ['nullable', 'numeric'],
        ]);

        $subKriteria->update($validated);

        return redirect()->route('kriteria.index')->with('success', 'Sub-Kriteria berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $subKriteria = SubKriteria::findOrFail($id);
        $subKriteria->delete();

        return redirect()->route('kriteria.index')->with('success', 'Sub-Kriteria berhasil dihapus.');
    }
}
