@extends('layouts.master')

@section('title', 'Detail Perhitungan ' . $batch->kode_batch . ' - SPK WASPAS')

@section('content')
<div class="space-y-8">

    <!-- Header Section -->
    <div>
        <a href="{{ route('hasil.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition mb-2 inline-block">
            &larr; Kembali ke Riwayat
        </a>
        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Detail Perhitungan {{ $batch->kode_batch }}</h2>
        <p class="text-xs text-slate-400 font-medium mt-1">Dijalankan oleh: {{ $batch->creator->name ?? '-' }}</p>
    </div>

    <!-- Ranking Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h3 class="font-bold text-slate-800 text-base">Tabel Urutan Perangkingan WASPAS</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-400 text-[11px] font-extrabold uppercase tracking-wider border-b border-slate-100">
                        <th class="py-4 px-6 text-center">Peringkat</th>
                        <th class="py-4 px-6">Kode</th>
                        <th class="py-4 px-6">Kamera</th>
                        <th class="py-4 px-6">Merk</th>
                        <th class="py-4 px-6 text-center">WSM</th>
                        <th class="py-4 px-6 text-center">WPM</th>
                        <th class="py-4 px-6 text-center">Qi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                    @forelse($batch->hasil as $row)
                        <tr class="hover:bg-slate-50/50 transition {{ $row->rank == 1 ? 'bg-amber-50/30 font-bold' : '' }}">
                            <td class="py-4 px-6 text-center">
                                <span class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 font-bold inline-flex items-center justify-center text-xs">
                                    {{ $row->rank }}
                                </span>
                            </td>
                            <td class="py-4 px-6 font-extrabold text-indigo-600">{{ $row->kode_kamera }}</td>
                            <td class="py-4 px-6">
                                <span class="font-bold text-slate-800 text-sm">{{ $row->nama_kamera }}</span>
                                @if(!$row->kamera)
                                    <span class="text-[10px] text-slate-400 italic">(data kamera sudah dihapus)</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">{{ $row->merk }}</span>
                            </td>
                            <td class="py-4 px-6 text-center font-mono text-xs text-slate-600">{{ number_format($row->q1, 3) }}</td>
                            <td class="py-4 px-6 text-center font-mono text-xs text-slate-600">{{ number_format($row->q2, 3) }}</td>
                            <td class="py-4 px-6 text-center font-mono font-black text-indigo-600 text-base">{{ number_format($row->qi, 3) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">Tidak ada data hasil.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
