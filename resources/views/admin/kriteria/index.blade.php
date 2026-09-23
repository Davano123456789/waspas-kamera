@extends('layouts.master')

@section('title', 'Data Kriteria - SPK WASPAS Pemilihan Kamera')

@section('content')
<div class="space-y-8">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Data Kriteria Penilaian</h2>
            <p class="text-xs text-slate-400 font-medium mt-1">Kelola kriteria, bobot, atribut (Benefit/Cost), dan sub-kriteria acuan WASPAS</p>
        </div>
        <a href="{{ route('kriteria.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-slate-900 hover:bg-blue-950 text-white font-bold text-xs rounded-xl shadow-md shadow-slate-900/20 transition-all">
            <i class="fa-solid fa-plus"></i> Tambah Kriteria
        </a>
    </div>

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold space-y-1">
            @foreach($errors->all() as $err)
                <p><i class="fa-solid fa-circle-exclamation text-sm mr-1"></i> {{ $err }}</p>
            @endforeach
        </div>
    @endif

    <!-- Kriteria Data Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 text-base">Daftar Kriteria Penilaian WASPAS</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-400 text-[11px] font-extrabold uppercase tracking-wider border-b border-slate-100">
                        <th class="py-4 px-6">Kode</th>
                        <th class="py-4 px-6">Nama Kriteria</th>
                        <th class="py-4 px-6">Bobot Mentah</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                    @forelse($kriterias as $item)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-extrabold text-indigo-600">{{ $item->kode }}</td>
                            <td class="py-4 px-6 font-bold text-slate-800">{{ $item->nama }}</td>
                            <td class="py-4 px-6 font-semibold text-slate-800">{{ rtrim(rtrim(number_format($item->bobot, 2), '0'), '.') }}</td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('kriteria.show', $item->id) }}" class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 hover:bg-indigo-100 flex items-center justify-center transition" title="Detail Kriteria">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>
                                    <a href="{{ route('kriteria.edit', $item->id) }}" class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 hover:bg-amber-100 flex items-center justify-center transition" title="Edit Kriteria">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                    </a>
                                    <form action="{{ route('kriteria.destroy', $item->id) }}" method="POST" onsubmit="confirmDelete(event, this, 'Hapus Kriteria?', 'Kriteria {{ $item->kode }} ({{ $item->nama }}) akan dihapus permanen!')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center transition" title="Hapus Kriteria">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400 text-sm">Belum ada data kriteria. Klik "Tambah Kriteria" untuk membuat baru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
