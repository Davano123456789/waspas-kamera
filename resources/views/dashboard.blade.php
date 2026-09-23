@extends('layouts.master')

@section('title', 'Dashboard - SPK WASPAS Pemilihan Kamera')

@section('content')
<div class="space-y-8">

    <!-- Welcome Hero Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-950 via-slate-900 to-blue-950 p-8 lg:p-10 text-white shadow-xl shadow-slate-900/20">
        <!-- Decorative background glow -->
        <div class="absolute -right-10 -bottom-10 w-72 h-72 rounded-full bg-blue-500/10 blur-2xl pointer-events-none"></div>
        <div class="absolute right-32 -top-10 w-48 h-48 rounded-full bg-slate-500/20 blur-xl pointer-events-none"></div>

        <div class="relative z-10 max-w-2xl space-y-3">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 text-white/90 text-xs font-semibold backdrop-blur-sm border border-white/10">
                <i class="fa-solid fa-sparkles text-amber-300"></i> Sistem Pendukung Keputusan
            </span>
            <h2 class="text-2xl lg:text-3xl font-extrabold text-white tracking-tight leading-snug">
                Selamat Datang di SPK WASPAS Kamera 👋
            </h2>
            <p class="text-slate-300/90 text-sm leading-relaxed font-normal">
                Kelola data kriteria, data kamera, dan dapatkan perangkingan rekomendasi kamera terbaik secara akurat menggunakan metode WASPAS (Weighted Aggregated Sum Product Assessment).
            </p>
        </div>
    </div>

    <!-- Quick Stats Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Stat Card 1 -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Kriteria</p>
                    <h3 class="text-2xl font-extrabold text-slate-800 mt-1">{{ $totalKriteria }} Kriteria</h3>
                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600 mt-2 bg-emerald-50 px-2 py-0.5 rounded-md">
                        <i class="fa-solid fa-check text-[10px]"></i> Benefit & Cost
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-sliders"></i>
                </div>
            </div>
        </div>

        <!-- Stat Card 2 -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Data Kamera</p>
                    <h3 class="text-2xl font-extrabold text-slate-800 mt-1">{{ $totalKamera }} Kamera</h3>
                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-indigo-600 mt-2 bg-indigo-50 px-2 py-0.5 rounded-md">
                        <i class="fa-solid fa-camera text-[10px]"></i> Alternatif $A_i$
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-camera-retro"></i>
                </div>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Role Hak Akses</p>
                    <h3 class="text-2xl font-extrabold text-slate-800 mt-1">Admin & User</h3>
                    <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-purple-600 mt-2 bg-purple-50 px-2 py-0.5 rounded-md">
                        <i class="fa-solid fa-users text-[10px]"></i> Multi-Role Active
                    </span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl font-bold">
                    <i class="fa-solid fa-user-shield"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
