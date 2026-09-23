@extends('layouts.master')

@section('title', 'Tambah Kamera Baru - SPK WASPAS')

@section('content')
<div class="space-y-8 max-w-3xl mx-auto">

    <!-- Header & Back Link -->
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('kamera.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-900 transition inline-flex items-center gap-1 mb-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Data Kamera
            </a>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Tambah Kamera Baru</h2>
            <p class="text-xs text-slate-400 font-medium mt-0.5">Isi formulir berikut untuk menambahkan data kamera alternatif baru</p>
        </div>
    </div>

    <!-- Alert Error -->
    @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold space-y-1">
            @foreach($errors->all() as $err)
                <p><i class="fa-solid fa-circle-exclamation text-sm mr-1"></i> {{ $err }}</p>
            @endforeach
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 lg:p-8">
        <form action="{{ route('kamera.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kode Kamera <span class="text-rose-500">*</span></label>
                    <input type="text" 
                           name="kode" 
                           value="{{ old('kode') }}"
                           placeholder="misal: A6" 
                           required 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:ring-2 focus:ring-slate-900 focus:bg-white focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Merk Kamera <span class="text-rose-500">*</span></label>
                    <input type="text" 
                           name="merk" 
                           value="{{ old('merk') }}"
                           placeholder="Sony, Canon, Fujifilm..." 
                           required 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:ring-2 focus:ring-slate-900 focus:bg-white focus:outline-none transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Kamera <span class="text-rose-500">*</span></label>
                <input type="text" 
                       name="nama" 
                       value="{{ old('nama') }}"
                       placeholder="misal: Sony Alpha A7 IV" 
                       required 
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:ring-2 focus:ring-slate-900 focus:bg-white focus:outline-none transition">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Deskripsi Ringkas</label>
                <textarea name="deskripsi" 
                          rows="4" 
                          placeholder="Kamera mirrorless full-frame dengan performa tinggi..." 
                          class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:ring-2 focus:ring-slate-900 focus:bg-white focus:outline-none transition">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('kamera.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-blue-950 text-white font-bold text-xs rounded-xl shadow-lg shadow-slate-900/20 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Kamera</span>
                </button>
            </div>
        </form>
    </div>

</div>
@endsection
