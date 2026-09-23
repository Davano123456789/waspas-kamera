<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kamera;

class KameraController extends Controller
{
    public function index()
    {
        $kameras = Kamera::with('evaluasi')->orderBy('kode')->get();
        return view('admin.kamera.index', compact('kameras'));
    }

    public function create()
    {
        return view('admin.kamera.create');
    }

    public function show($id)
    {
        $kamera = Kamera::findOrFail($id);
        return view('admin.kamera.show', compact('kamera'));
    }

    public function edit($id)
    {
        $kamera = Kamera::findOrFail($id);
        return view('admin.kamera.edit', compact('kamera'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:10', 'unique:kamera,kode'],
            'nama' => ['required', 'string', 'max:255'],
            'merk' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
        ], [
            'kode.unique' => 'Kode kamera sudah digunakan.',
        ]);

        Kamera::create($validated);

        return redirect()->route('kamera.index')->with('success', 'Data Kamera berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $kamera = Kamera::findOrFail($id);

        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:10', 'unique:kamera,kode,' . $id],
            'nama' => ['required', 'string', 'max:255'],
            'merk' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
        ]);

        $kamera->update($validated);

        return redirect()->route('kamera.index')->with('success', 'Data Kamera berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kamera = Kamera::findOrFail($id);
        $kamera->delete();

        return redirect()->route('kamera.index')->with('success', 'Data Kamera berhasil dihapus.');
    }
}
