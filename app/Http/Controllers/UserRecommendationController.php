<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamera;
use App\Models\Kriteria;
use App\Models\PreferensiUser;
use App\Services\WaspasService;
use Illuminate\Support\Facades\Auth;

class UserRecommendationController extends Controller
{
    protected $waspasService;

    public function __construct(WaspasService $waspasService)
    {
        $this->waspasService = $waspasService;
    }

    public function rekomendasi(Request $request)
    {
        $kriterias = Kriteria::orderBy('kode')->get();
        $customWeights = $request->input('bobot'); // Array [kriteria_id => weight_value]

        if ($request->isMethod('post') && $customWeights) {
            // Save user preference if logged in
            if (Auth::check()) {
                PreferensiUser::create([
                    'user_id' => Auth::id(),
                    'bobot_kustom' => $customWeights,
                ]);
            }

            $waspasData = $this->waspasService->calculate($customWeights);

            return view('user.hasil-rekomendasi', array_merge($waspasData, [
                'customWeights' => $customWeights,
            ]));
        }

        // Check if user has saved preference
        if (Auth::check()) {
            $lastPref = PreferensiUser::where('user_id', Auth::id())->latest()->first();
            if ($lastPref) {
                $customWeights = $lastPref->bobot_kustom;
            }
        }

        return view('user.rekomendasi', [
            'kriterias' => $kriterias,
            'customWeights' => $customWeights,
        ]);
    }

    public function katalog(Request $request)
    {
        $query = Kamera::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('merk', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('merk')) {
            $query->where('merk', $request->merk);
        }

        $kameras = $query->orderBy('nama')->get();
        $brands = Kamera::select('merk')->distinct()->pluck('merk');

        return view('user.katalog', compact('kameras', 'brands'));
    }

    public function detailKamera($id)
    {
        $kamera = Kamera::with(['evaluasi.kriteria', 'evaluasi.subKriteria'])->findOrFail($id);
        return view('user.detail', compact('kamera'));
    }
}
