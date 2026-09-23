@extends('layouts.master')

@section('title', 'Cari Rekomendasi Kamera - SPK WASPAS')

@section('content')
<div class="space-y-10">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="px-3 py-1 rounded-full bg-slate-900 text-white text-xs font-bold uppercase border border-slate-800">
                <i class="fa-solid fa-sliders text-[10px] mr-1"></i> Rekomendasi Personalisasi
            </span>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight mt-2">Cari Rekomendasi Kamera Sesuai Preferensi Anda</h2>
            <p class="text-xs text-slate-400 font-medium mt-1">Geser slider bobot di bawah ini sesuai prioritas kebutuhan dan kantong Anda, lalu klik "Hitung Rekomendasi"</p>
        </div>
    </div>

    <!-- Weight Preference Adjustment Form -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 lg:p-8">
        <form action="{{ route('user.rekomendasi') }}" method="POST" class="space-y-6">
            @csrf

            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="font-bold text-slate-800 text-base">Atur Prioritas Kriteria Penilaian</h3>
                    <p class="text-xs text-slate-400 font-medium">Beri nilai lebih tinggi pada kriteria yang paling penting bagi Anda</p>
                </div>
                <a href="{{ route('user.rekomendasi') }}" class="text-xs font-bold text-slate-500 hover:text-slate-900 transition flex items-center gap-1">
                    <i class="fa-solid fa-rotate-left"></i> Reset Ke Bobot Standar
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($kriterias as $kr)
                    @php
                        $userVal = $customWeights[$kr->id] ?? $kr->bobot;
                    @endphp
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3 hover:border-slate-400 transition">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-7 h-7 rounded-lg bg-slate-900 text-white font-extrabold flex items-center justify-center text-xs">
                                    {{ $kr->kode }}
                                </span>
                                <h4 class="text-xs font-bold text-slate-800">{{ $kr->nama }}</h4>
                            </div>
                            @if($kr->atribut === 'benefit')
                                <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-emerald-50 text-emerald-600 uppercase">Benefit</span>
                            @else
                                <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-rose-50 text-rose-600 uppercase">Cost</span>
                            @endif
                        </div>

                        <div class="space-y-2">
                            <div class="flex items-center justify-between text-xs">
                                <span class="text-slate-400 font-medium">Tingkat Kepentingan:</span>
                                <span class="font-black text-slate-900" id="valLabel_{{ $kr->id }}">{{ (int)$userVal }}</span>
                            </div>
                            <input type="range" 
                                   min="10" 
                                   max="100" 
                                   step="1" 
                                   name="bobot[{{ $kr->id }}]" 
                                   value="{{ (int)$userVal }}" 
                                   oninput="document.getElementById('valLabel_{{ $kr->id }}').innerText = this.value" 
                                   class="w-full accent-slate-900 cursor-pointer">
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pt-4 border-t border-slate-100 text-right">
                <button type="submit" class="px-8 py-3 bg-slate-900 hover:bg-blue-950 text-white font-bold text-sm rounded-xl shadow-lg shadow-slate-900/30 transition-all inline-flex items-center gap-2">
                    <i class="fa-solid fa-calculator"></i> Hitung Rekomendasi WASPAS Sekarang
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
