<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\SubKriteriaController;
use App\Http\Controllers\Admin\KameraController;
use App\Http\Controllers\Admin\EvaluasiController;
use App\Http\Controllers\Admin\WaspasController;
use App\Http\Controllers\Admin\HasilPerhitunganController;
use App\Http\Controllers\UserRecommendationController;
use App\Services\WaspasService;
use App\Models\Kamera;
use App\Models\Kriteria;

// Guest Routes (Authentication)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Admin Routes (Role: admin)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function (WaspasService $waspasService) {
        $waspasData = $waspasService->calculate();
        $totalKamera = Kamera::count();
        $totalKriteria = Kriteria::count();
        $kameras = Kamera::with('evaluasi')->take(5)->get();
        $kriterias = Kriteria::orderBy('kode')->get();
        $winner = $waspasData['rankings'][0] ?? null;

        return view('dashboard', compact('waspasData', 'totalKamera', 'totalKriteria', 'kameras', 'kriterias', 'winner'));
    })->name('dashboard');

    Route::resource('kriteria', KriteriaController::class);
    Route::resource('sub-kriteria', SubKriteriaController::class)->only(['store', 'update', 'destroy']);
    Route::resource('kamera', KameraController::class);

    Route::get('/evaluasi', [EvaluasiController::class, 'index'])->name('evaluasi.index');
    Route::get('/evaluasi/{kamera}/edit', [EvaluasiController::class, 'edit'])->name('evaluasi.edit');
    Route::post('/evaluasi/{kamera}', [EvaluasiController::class, 'storeOrUpdate'])->name('evaluasi.storeOrUpdate');

    Route::get('/hasil-perangkingan', [WaspasController::class, 'ranking'])->name('waspas.ranking');
    Route::get('/cetak-laporan', [WaspasController::class, 'cetak'])->name('waspas.cetak');

    Route::get('/hasil-perhitungan/pilih', [HasilPerhitunganController::class, 'pilih'])->name('hasil.pilih');
    Route::post('/hasil-perhitungan/preview', [HasilPerhitunganController::class, 'preview'])->name('hasil.preview');
    Route::get('/hasil-perhitungan/{id}', [HasilPerhitunganController::class, 'show'])->name('hasil.show');
    Route::delete('/hasil-perhitungan/{id}', [HasilPerhitunganController::class, 'destroy'])->name('hasil.destroy');
    Route::post('/hasil-perhitungan', [HasilPerhitunganController::class, 'store'])->name('hasil.store');
    Route::get('/hasil-perhitungan', [HasilPerhitunganController::class, 'index'])->name('hasil.index');
});

// User Routes (Role: user)
Route::middleware(['auth', 'role:user'])->prefix('user')->group(function () {
    Route::get('/rekomendasi', [UserRecommendationController::class, 'rekomendasi'])->name('user.rekomendasi');
    Route::post('/rekomendasi', [UserRecommendationController::class, 'rekomendasi']);
    Route::get('/katalog', [UserRecommendationController::class, 'katalog'])->name('user.katalog');
    Route::get('/kamera/{id}', [UserRecommendationController::class, 'detailKamera'])->name('user.kamera.detail');
});

// Default Root Redirect
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('dashboard')
            : redirect()->route('user.katalog');
    }
    return redirect()->route('login');
});
