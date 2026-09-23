@extends('layouts.master')

@section('title', 'Data Kamera - SPK WASPAS Pemilihan Kamera')

@section('content')
<div class="space-y-8">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Data Kamera</h2>
            <p class="text-xs text-slate-400 font-medium mt-1">Kelola master data kamera yang dihitung dengan metode WASPAS</p>
        </div>
        <a href="{{ route('kamera.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-900 hover:bg-blue-950 text-white font-bold text-xs rounded-xl shadow-md shadow-slate-900/20 transition-all">
            <i class="fa-solid fa-plus"></i> Tambah Kamera
        </a>
    </div>



    @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold space-y-1">
            @foreach($errors->all() as $err)
                <p><i class="fa-solid fa-circle-exclamation text-sm mr-1"></i> {{ $err }}</p>
            @endforeach
        </div>
    @endif

    <!-- Data Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 text-base">Daftar Kamera</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-400 text-[11px] font-extrabold uppercase tracking-wider border-b border-slate-100">
                        <th class="py-4 px-6">Kode</th>
                        <th class="py-4 px-6">Kamera</th>
                        <th class="py-4 px-6">Merk</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                    @forelse($kameras as $item)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-extrabold text-slate-900">{{ $item->kode }}</td>
                            <td class="py-4 px-6">
                                <h4 class="font-bold text-slate-800 text-sm">{{ $item->nama }}</h4>
                                <p class="text-xs text-slate-400 truncate max-w-xs">{{ $item->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-xs font-extrabold bg-slate-100 text-slate-700">
                                    {{ $item->merk }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('kamera.show', $item->id) }}" class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 flex items-center justify-center transition" title="Detail Kamera">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>
                                    <a href="{{ route('kamera.edit', $item->id) }}" class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 flex items-center justify-center transition" title="Edit Kamera">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>
                                    <form action="{{ route('kamera.destroy', $item->id) }}" method="POST" onsubmit="confirmDelete(event, this, 'Hapus Kamera?', 'Kamera {{ $item->nama }} akan dihapus permanen dari sistem!')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center transition" title="Hapus Kamera">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400 text-sm">Belum ada data kamera. Klik "Tambah Kamera" untuk membuat baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
