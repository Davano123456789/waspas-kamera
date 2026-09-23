@extends('layouts.master')

@section('title', $kamera->nama . ' - Detail Spesifikasi')

@section('content')
<div class="space-y-8 max-w-4xl mx-auto">

    <!-- Back Button -->
    <div>
        <a href="javascript:history.back()" class="text-xs font-bold text-slate-900 hover:text-blue-900 transition inline-flex items-center gap-1">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <!-- Camera Hero Box -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 lg:p-8 space-y-3">
        <div class="flex items-center gap-2">
            <span class="px-2.5 py-1 rounded-full text-xs font-extrabold bg-slate-900 text-white uppercase">{{ $kamera->kode }}</span>
            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700 uppercase">{{ $kamera->merk }}</span>
        </div>
        <h2 class="text-2xl font-black text-slate-800 tracking-tight">{{ $kamera->nama }}</h2>
        <p class="text-xs text-slate-500 leading-relaxed">{{ $kamera->deskripsi ?? 'Kamera berperforma tinggi yang direkomendasikan untuk fotografi & videografi.' }}</p>
    </div>

    <!-- Full Specifications Grid -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 lg:p-8 space-y-6">
        <h3 class="font-extrabold text-slate-800 text-lg border-b border-slate-100 pb-4">
            Spesifikasi Kamera
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @forelse($kamera->evaluasi as $ev)
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-1">
                    <h4 class="text-xs font-bold text-slate-500">{{ $ev->kriteria->nama }}</h4>
                    <p class="text-sm font-extrabold text-slate-900">
                        {{ $ev->nilai_asli ?? $ev->subKriteria?->nama ?? '-' }}
                    </p>
                </div>
            @empty
                <div class="col-span-full text-center text-slate-400 py-4 text-xs">
                    Spesifikasi kriteria belum diisi oleh Admin.
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
