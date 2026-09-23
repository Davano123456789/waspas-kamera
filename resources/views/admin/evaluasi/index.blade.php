@extends('layouts.master')

@section('title', 'Daftar Penilaian - SPK WASPAS Pemilihan Kamera')

@section('content')
<div class="space-y-8">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Daftar Penilaian Kamera</h2>
            <p class="text-xs text-slate-400 font-medium mt-1">Berikan nilai untuk setiap kamera berdasarkan kriteria yang telah ditentukan.</p>
        </div>
    </div>

    <!-- List -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-400 text-[11px] font-extrabold uppercase tracking-wider border-b border-slate-100">
                        <th class="py-4 px-6">No</th>
                        <th class="py-4 px-6">Kode</th>
                        <th class="py-4 px-6">Nama Kamera</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                    @forelse($kameras as $i => $kam)
                        @php
                            $isLengkap = $kriterias->count() > 0 && $kam->evaluasi->count() >= $kriterias->count();
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 text-slate-400">{{ $i + 1 }}</td>
                            <td class="py-4 px-6 font-extrabold text-indigo-600">{{ $kam->kode }}</td>
                            <td class="py-4 px-6 font-bold text-slate-800">{{ $kam->nama }}</td>
                            <td class="py-4 px-6">
                                @if($isLengkap)
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-500 text-white">Terisi</span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-300 text-white">Belum Lengkap</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <a href="{{ route('evaluasi.edit', $kam->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full text-xs font-bold transition">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit Nilai
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-slate-400">Belum ada data kamera.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
