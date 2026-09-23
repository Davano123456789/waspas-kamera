@extends('layouts.master')

@section('title', 'Detail Kriteria ' . $kriteria->kode . ' - SPK WASPAS')

@section('content')
<div class="space-y-8 max-w-3xl mx-auto">

    <!-- Header & Back Link -->
    <div>
        <a href="{{ route('kriteria.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-900 transition inline-flex items-center gap-1 mb-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Data Kriteria
        </a>
        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Detail Kriteria {{ $kriteria->kode }}</h2>
        <p class="text-xs text-slate-400 font-medium mt-0.5">Informasi lengkap kriteria (hanya baca)</p>
    </div>

    <!-- Detail Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 lg:p-8 space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kode Kriteria</label>
                <div class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800">
                    {{ $kriteria->kode }}
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Bobot Mentah</label>
                <div class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800">
                    {{ rtrim(rtrim(number_format($kriteria->bobot, 2), '0'), '.') }}
                </div>
                <p class="text-[11px] text-slate-400 mt-1 font-medium">Bobot Normalisasi: {{ number_format($kriteria->bobot_normalisasi, 4) }} ({{ number_format($kriteria->bobot_normalisasi * 100, 2) }}%)</p>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Kriteria</label>
            <div class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800">
                {{ $kriteria->nama }}
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Atribut / Sifat Kriteria</label>
                <div class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800">
                    {{ $kriteria->atribut === 'benefit' ? 'Benefit (Semakin tinggi semakin baik)' : 'Cost (Semakin rendah semakin baik)' }}
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tipe Input</label>
                <div class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800">
                    {{ $kriteria->tipe_input === 'rentang' ? 'Rentang (Input Manual Angka)' : 'Pilihan (Dropdown)' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Sub-Kriteria (Read Only) -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 lg:p-8 space-y-4">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <h3 class="font-bold text-slate-800 text-base">Sub-Kriteria & Skor Konversi</h3>
            <span class="text-xs font-semibold text-slate-500">{{ $kriteria->subKriteria->count() }} Pilihan Sub-Kriteria</span>
        </div>

        <div class="border border-slate-100 rounded-2xl overflow-hidden">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-400 font-extrabold uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-5">Label</th>
                        @if($kriteria->tipe_input === 'rentang')
                            <th class="py-3.5 px-5">Rentang</th>
                        @endif
                        <th class="py-3.5 px-5">Skor Konversi Numerik</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @forelse($kriteria->subKriteria as $sub)
                        <tr>
                            <td class="py-3.5 px-5 font-bold text-slate-800">{{ $sub->nama }}</td>
                            @if($kriteria->tipe_input === 'rentang')
                                <td class="py-3.5 px-5 text-slate-500">
                                    {{ $sub->nilai_min !== null ? rtrim(rtrim(number_format($sub->nilai_min, 2, '.', ''), '0'), '.') : '−∞' }}
                                    &ndash;
                                    {{ $sub->nilai_maks !== null ? rtrim(rtrim(number_format($sub->nilai_maks, 2, '.', ''), '0'), '.') : '∞' }}
                                </td>
                            @endif
                            <td class="py-3.5 px-5 font-semibold text-slate-800">Skor {{ $sub->nilai }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $kriteria->tipe_input === 'rentang' ? 3 : 2 }}" class="py-6 text-center text-slate-400 font-medium">Belum ada sub-kriteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
