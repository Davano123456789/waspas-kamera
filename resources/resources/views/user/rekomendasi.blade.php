@extends('layouts.master')

@section('title', 'Cari Rekomendasi Kamera - SPK WASPAS')

@section('content')
<div class="space-y-10">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <span class="px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold uppercase border border-indigo-100">
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
                <a href="{{ route('user.rekomendasi') }}" class="text-xs font-bold text-slate-500 hover:text-indigo-600 transition flex items-center gap-1">
                    <i class="fa-solid fa-rotate-left"></i> Reset Ke Bobot Standar
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($kriterias as $kr)
                    @php
                        $userVal = $customWeights[$kr->id] ?? $kr->bobot;
                    @endphp
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-3 hover:border-indigo-200 transition">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="w-7 h-7 rounded-lg bg-indigo-600 text-white font-extrabold flex items-center justify-center text-xs">
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
                                <span class="font-black text-indigo-600" id="valLabel_{{ $kr->id }}">{{ (int)$userVal }}</span>
                            </div>
                            <input type="range" 
                                   min="10" 
                                   max="100" 
                                   step="1" 
                                   name="bobot[{{ $kr->id }}]" 
                                   value="{{ (int)$userVal }}" 
                                   oninput="document.getElementById('valLabel_{{ $kr->id }}').innerText = this.value" 
                                   class="w-full accent-indigo-600 cursor-pointer">
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pt-4 border-t border-slate-100 text-right">
                <button type="submit" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-indigo-600/30 transition-all inline-flex items-center gap-2">
                    <i class="fa-solid fa-calculator"></i> Hitung Rekomendasi WASPAS Sekarang
                </button>
            </div>
        </form>
    </div>

    <!-- WASPAS Custom Recommendation Results -->
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-xl font-extrabold text-slate-800 tracking-tight">Hasil Kamera Ter-Rekomendasi Untuk Anda</h3>
                <p class="text-xs text-slate-400 font-medium mt-0.5">Hasil perangkingan WASPAS berbasis preferensi bobot kustom yang Anda masukkan</p>
            </div>
        </div>

        @if(count($rankings) > 0)
            @php $topMatch = $rankings[0]; @endphp
            
            <!-- Top Match Banner -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-indigo-700 to-blue-600 p-8 text-white shadow-xl shadow-indigo-500/20">
                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex items-center gap-6">
                        <div class="w-24 h-24 rounded-2xl bg-white p-2 flex items-center justify-center shrink-0 shadow-md">
                            @if($topMatch['kamera']->gambar)
                                <img src="{{ asset('storage/' . $topMatch['kamera']->gambar) }}" alt="{{ $topMatch['kamera']->nama }}" class="w-full h-full object-cover rounded-xl">
                            @else
                                <i class="fa-solid fa-camera-retro text-indigo-600 text-4xl"></i>
                            @endif
                        </div>
                        <div class="space-y-1">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-400 text-amber-950 text-xs font-black uppercase shadow-xs">
                                <i class="fa-solid fa-star"></i> Paling Cocok Untuk Anda (#1)
                            </span>
                            <h3 class="text-2xl font-extrabold text-white tracking-tight">{{ $topMatch['kamera']->nama }}</h3>
                            <p class="text-indigo-100 text-xs font-medium">
                                Merk: {{ $topMatch['kamera']->merk }} • Harga: Rp {{ number_format($topMatch['kamera']->harga, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="bg-white/15 backdrop-blur-md border border-white/20 p-5 rounded-2xl text-center min-w-[180px]">
                        <p class="text-xs font-bold text-indigo-100 uppercase tracking-wider">Skor Kecocokan WASPAS</p>
                        <h4 class="text-3xl font-black text-white mt-1">{{ number_format($topMatch['qi'], 4) }}</h4>
                        <a href="{{ route('user.kamera.detail', $topMatch['kamera']->id) }}" class="inline-block mt-2 px-3 py-1 bg-white text-indigo-700 rounded-lg text-xs font-bold hover:bg-indigo-50 transition">
                            Lihat Detail &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <!-- Grid Cards for All Ranked Cameras -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($rankings as $item)
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-200 overflow-hidden flex flex-col justify-between">
                        <div>
                            <!-- Card Header Image & Rank Badge -->
                            <div class="relative h-48 bg-slate-100 overflow-hidden flex items-center justify-center p-4">
                                @if($item['kamera']->gambar)
                                    <img src="{{ asset('storage/' . $item['kamera']->gambar) }}" alt="{{ $item['kamera']->nama }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fa-solid fa-camera text-slate-300 text-5xl"></i>
                                @endif

                                <div class="absolute top-3 left-3">
                                    @if($item['rank'] == 1)
                                        <span class="px-3 py-1 bg-amber-500 text-white rounded-full text-xs font-black shadow-md flex items-center gap-1">
                                            <i class="fa-solid fa-trophy text-amber-200"></i> Rank #1
                                        </span>
                                    @elseif($item['rank'] == 2)
                                        <span class="px-3 py-1 bg-slate-700 text-white rounded-full text-xs font-extrabold shadow-md">
                                            Rank #2
                                        </span>
                                    @elseif($item['rank'] == 3)
                                        <span class="px-3 py-1 bg-amber-800 text-white rounded-full text-xs font-extrabold shadow-md">
                                            Rank #3
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 bg-slate-200 text-slate-700 rounded-full text-xs font-bold">
                                            Rank #{{ $item['rank'] }}
                                        </span>
                                    @endif
                                </div>

                                <div class="absolute bottom-3 right-3 bg-white/90 backdrop-blur-sm px-2.5 py-1 rounded-xl text-indigo-700 font-black text-xs shadow-sm">
                                    Score: {{ number_format($item['qi'], 4) }}
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-6 space-y-3">
                                <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-slate-100 text-slate-600 uppercase">
                                    {{ $item['kamera']->merk }}
                                </span>
                                <h4 class="font-extrabold text-slate-800 text-base leading-snug">{{ $item['kamera']->nama }}</h4>
                                <p class="text-xs text-slate-400 line-clamp-2">{{ $item['kamera']->deskripsi ?? 'Spesifikasi kamera performa tinggi.' }}</p>

                                <div class="pt-2 border-t border-slate-100 flex items-center justify-between">
                                    <span class="text-xs text-slate-400 font-medium">Perkiraan Harga:</span>
                                    <span class="text-sm font-extrabold text-slate-800">Rp {{ number_format($item['kamera']->harga, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer Action -->
                        <div class="px-6 pb-6 pt-0">
                            <a href="{{ route('user.kamera.detail', $item['kamera']->id) }}" class="w-full py-2.5 bg-slate-100 hover:bg-indigo-600 hover:text-white text-slate-700 font-bold text-xs rounded-xl transition-all flex items-center justify-center gap-1.5">
                                <span>Lihat Spesifikasi Lengkap</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection
