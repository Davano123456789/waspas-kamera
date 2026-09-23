@extends('layouts.master')

@section('title', 'Riwayat Perhitungan WASPAS - SPK Pemilihan Kamera')

@section('content')
<div class="space-y-8">

    <!-- Header Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-950 via-slate-900 to-blue-950 p-8 lg:p-10 text-white shadow-xl shadow-slate-900/20 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
        <div>
            <h2 class="text-xl lg:text-2xl font-extrabold text-white tracking-tight">Riwayat Perhitungan WASPAS</h2>
            <p class="text-slate-300/90 text-sm mt-1">Daftar seluruh perhitungan yang pernah Anda simpan.</p>
        </div>
        <a href="{{ route('hasil.pilih') }}" class="inline-flex items-center gap-2 px-5 py-3 bg-amber-500 hover:bg-amber-400 text-slate-900 font-bold text-sm rounded-xl shadow-md shadow-amber-500/30 transition-all shrink-0">
            <i class="fa-solid fa-play"></i> Jalankan Perhitungan Baru
        </a>
    </div>

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold space-y-1">
            @foreach($errors->all() as $err)
                <p><i class="fa-solid fa-circle-exclamation text-sm mr-1"></i> {{ $err }}</p>
            @endforeach
        </div>
    @endif

    <!-- Riwayat Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100">
            <h3 class="font-bold text-slate-800 text-base">Daftar Sesi Perhitungan</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-400 text-[11px] font-extrabold uppercase tracking-wider border-b border-slate-100">
                        <th class="py-4 px-6">No</th>
                        <th class="py-4 px-6">Tanggal</th>
                        <th class="py-4 px-6">Kode Batch</th>
                        <th class="py-4 px-6">Jumlah Kamera</th>
                        <th class="py-4 px-6">Dijalankan Oleh</th>
                        <th class="py-4 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                    @forelse($batches as $i => $batch)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 text-slate-400">{{ $i + 1 }}</td>
                            <td class="py-4 px-6">
                                <i class="fa-regular fa-calendar text-slate-400 mr-1.5"></i>
                                {{ $batch->created_at->translatedFormat('d F Y') }}
                            </td>
                            <td class="py-4 px-6 font-mono text-slate-500">{{ $batch->kode_batch }}</td>
                            <td class="py-4 px-6 font-bold text-slate-800">{{ $batch->hasil_count }} Kamera</td>
                            <td class="py-4 px-6 text-slate-600">{{ $batch->creator->name ?? '-' }}</td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('hasil.show', $batch->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full text-xs font-bold transition">
                                        <i class="fa-solid fa-eye"></i> Lihat Detail
                                    </a>
                                    <form action="{{ route('hasil.destroy', $batch->id) }}" method="POST" onsubmit="confirmDelete(event, this, 'Hapus Riwayat?', 'Riwayat perhitungan {{ $batch->kode_batch }} akan dihapus permanen!')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-full text-xs font-bold transition">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Belum ada riwayat perhitungan. Klik "Jalankan Perhitungan Baru" untuk memulai.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
