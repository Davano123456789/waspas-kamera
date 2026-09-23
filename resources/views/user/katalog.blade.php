@extends('layouts.master')

@section('title', 'Katalog Kamera - SPK WASPAS')

@section('content')
<div class="space-y-8">

    <!-- Header & Search Bar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Katalog Kamera</h2>
            <p class="text-xs text-slate-400 font-medium mt-1">Jelajahi seluruh koleksi kamera yang tersedia beserta rincian spesifikasinya</p>
        </div>

        <form action="{{ route('user.katalog') }}" method="GET" class="flex items-center gap-3 w-full md:w-auto">
            <div class="relative flex-1 md:w-72">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="Cari nama atau merk..." 
                       class="w-full pl-9 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-medium focus:ring-2 focus:ring-slate-900 focus:outline-none">
            </div>
            <button type="submit" class="px-4 py-2.5 bg-slate-900 hover:bg-blue-950 text-white rounded-xl text-xs font-bold transition">
                Cari
            </button>
        </form>
    </div>

    <!-- Brand Filter Badges -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2">
        <a href="{{ route('user.katalog') }}" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition {{ !request('merk') ? 'bg-slate-900 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            Semua Brand
        </a>
        @foreach($brands as $brand)
            <a href="{{ route('user.katalog', ['merk' => $brand]) }}" class="px-3.5 py-1.5 rounded-full text-xs font-bold transition {{ request('merk') === $brand ? 'bg-slate-900 text-white' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                {{ $brand }}
            </a>
        @endforeach
    </div>

    <!-- Camera Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($kameras as $kam)
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-200 overflow-hidden flex flex-col justify-between">
                <div>
                    <!-- Content -->
                    <div class="p-5 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] font-bold text-slate-900 uppercase">{{ $kam->kode }}</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-slate-100 text-slate-700 uppercase">
                                {{ $kam->merk }}
                            </span>
                        </div>
                        <h4 class="font-extrabold text-slate-800 text-sm leading-snug line-clamp-1">{{ $kam->nama }}</h4>
                        <p class="text-xs text-slate-400 line-clamp-2">{{ $kam->deskripsi ?? 'Kamera berkualitas tinggi.' }}</p>
                    </div>
                </div>

                <div class="px-5 pb-5 pt-0">
                    <a href="{{ route('user.kamera.detail', $kam->id) }}" class="w-full py-2 bg-slate-100 hover:bg-slate-900 hover:text-white text-slate-800 font-bold text-xs rounded-xl transition flex items-center justify-center gap-1">
                        <span>Detail Spesifikasi</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-slate-400 bg-white rounded-3xl border border-slate-200">
                <i class="fa-solid fa-camera-slash text-4xl mb-3"></i>
                <p class="text-sm font-semibold">Tidak ada data kamera yang ditemukan.</p>
            </div>
        @endforelse
    </div>

</div>
@endsection
