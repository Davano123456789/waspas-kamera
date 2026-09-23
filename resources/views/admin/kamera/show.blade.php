@extends('layouts.master')

@section('title', 'Detail Kamera ' . $kamera->nama . ' - SPK WASPAS')

@section('content')
<div class="space-y-8 max-w-3xl mx-auto">

    <!-- Header & Back Link -->
    <div>
        <a href="{{ route('kamera.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-900 transition inline-flex items-center gap-1 mb-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Data Kamera
        </a>
        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Detail Kamera {{ $kamera->kode }}</h2>
        <p class="text-xs text-slate-400 font-medium mt-0.5">Informasi lengkap data kamera (hanya baca)</p>
    </div>

    <!-- Detail Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 lg:p-8 space-y-6">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kode Kamera</label>
                <div class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800">
                    {{ $kamera->kode }}
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Merk Kamera</label>
                <div class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800">
                    {{ $kamera->merk }}
                </div>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Kamera</label>
            <div class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800">
                {{ $kamera->nama }}
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Ringkas</label>
            <div class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 min-h-[6rem] whitespace-pre-line">
                {{ $kamera->deskripsi ?: 'Tidak ada deskripsi' }}
            </div>
        </div>
    </div>

</div>
@endsection
