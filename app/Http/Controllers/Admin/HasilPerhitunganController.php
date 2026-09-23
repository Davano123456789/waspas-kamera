<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Kamera;
use App\Models\PerhitunganBatch;
use App\Models\PerhitunganHasil;
use App\Services\WaspasService;

class HasilPerhitunganController extends Controller
{
    protected $waspasService;

    public function __construct(WaspasService $waspasService)
    {
        $this->waspasService = $waspasService;
    }

    public function index()
    {
        $batches = PerhitunganBatch::withCount('hasil')->with('creator')->orderByDesc('created_at')->get();
        return view('admin.hasil.index', compact('batches'));
    }

    public function pilih()
    {
        $kameras = Kamera::orderBy('nama')->get();
        return view('admin.hasil.pilih', compact('kameras'));
    }

    public function preview(Request $request)
    {
        $kameraIds = $request->input('kamera_ids', []);

        if (empty($kameraIds)) {
            return back()->withErrors(['kamera_ids' => 'Pilih minimal satu kamera untuk dihitung.']);
        }

        $data = $this->waspasService->calculate(null, 0.5, $kameraIds);

        return view('admin.hasil.preview', array_merge($data, ['kameraIds' => $kameraIds]));
    }

    public function store(Request $request)
    {
        $kameraIds = $request->input('kamera_ids', []);

        if (empty($kameraIds)) {
            return redirect()->route('hasil.pilih')->withErrors(['kamera_ids' => 'Pilih minimal satu kamera untuk dihitung.']);
        }

        $data = $this->waspasService->calculate(null, 0.5, $kameraIds);

        $batch = PerhitunganBatch::create([
            'kode_batch' => 'BATCH-' . strtoupper(Str::random(8)),
            'created_by' => Auth::id(),
        ]);

        foreach ($data['rankings'] as $row) {
            PerhitunganHasil::create([
                'batch_id' => $batch->id,
                'kamera_id' => $row['kamera']->id,
                'kode_kamera' => $row['kamera']->kode,
                'nama_kamera' => $row['kamera']->nama,
                'merk' => $row['kamera']->merk,
                'q1' => $row['q1'],
                'q2' => $row['q2'],
                'qi' => $row['qi'],
                'rank' => $row['rank'],
            ]);
        }

        return redirect()->route('hasil.show', $batch->id)->with('success', 'Hasil perhitungan berhasil disimpan ke riwayat.');
    }

    public function show($id)
    {
        $batch = PerhitunganBatch::with(['hasil' => function ($q) {
            $q->orderBy('rank');
        }, 'creator'])->findOrFail($id);

        return view('admin.hasil.show', compact('batch'));
    }

    public function destroy($id)
    {
        $batch = PerhitunganBatch::findOrFail($id);
        $batch->delete();

        return redirect()->route('hasil.index')->with('success', 'Riwayat perhitungan berhasil dihapus.');
    }
}
