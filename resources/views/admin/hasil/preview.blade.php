@extends('layouts.master')

@section('title', 'Pratinjau Perhitungan WASPAS - SPK Pemilihan Kamera')

@section('content')
<div class="space-y-8">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('hasil.pilih') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition mb-2 inline-block">
                &larr; Kembali ke Pilih Alternatif
            </a>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Tahapan Perhitungan WASPAS</h2>
            <p class="text-xs text-slate-400 font-medium mt-1">Pratinjau hasil sebelum disimpan ke riwayat. Melibatkan {{ count($kameras) }} alternatif kamera.</p>
        </div>
        <form action="{{ route('hasil.store') }}" method="POST">
            @csrf
            @foreach($kameraIds as $id)
                <input type="hidden" name="kamera_ids[]" value="{{ $id }}">
            @endforeach
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl shadow-md shadow-emerald-600/30 transition-all">
                <i class="fa-solid fa-floppy-disk"></i> Simpan Hasil & Konfirmasi Ranking
            </button>
        </form>
    </div>

    <!-- STEP 1: Matriks Keputusan X -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <span class="px-2.5 py-1 rounded-full text-xs font-extrabold bg-indigo-50 text-indigo-600 uppercase">Langkah 1</span>
            <h3 class="font-extrabold text-slate-800 text-base mt-2">Matriks Keputusan</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-extrabold uppercase border-b border-slate-100">
                        <th class="py-3.5 px-5">Kode</th>
                        <th class="py-3.5 px-5">Kamera</th>
                        @foreach($kriterias as $kr)
                            <th class="py-3.5 px-4 text-center">
                                <span class="text-indigo-600 font-black">{{ $kr->kode }}</span>
                                <span class="block text-[10px] text-slate-400 font-normal capitalize">{{ $kr->nama }}</span>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                    @foreach($kameras as $kam)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3.5 px-5 font-extrabold text-indigo-600">{{ $kam->kode }}</td>
                            <td class="py-3.5 px-5 font-bold text-slate-800">{{ $kam->nama }}</td>
                            @foreach($kriterias as $kr)
                                <td class="py-3.5 px-4 text-center font-bold text-slate-800">
                                    {{ $matrixX[$kam->id][$kr->id] ?? 0 }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- STEP 2: Matriks Normalisasi R -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <span class="px-2.5 py-1 rounded-full text-xs font-extrabold bg-blue-50 text-blue-600 uppercase">Langkah 2</span>
            <h3 class="font-extrabold text-slate-800 text-base mt-2">Matriks Normalisasi</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-extrabold uppercase border-b border-slate-100">
                        <th class="py-3.5 px-5">Kode</th>
                        <th class="py-3.5 px-5">Kamera</th>
                        @foreach($kriterias as $kr)
                            <th class="py-3.5 px-4 text-center">
                                <span class="text-indigo-600 font-black">{{ $kr->kode }}</span>
                                <span class="block text-[10px] uppercase font-bold {{ $kr->atribut === 'benefit' ? 'text-emerald-600' : 'text-rose-600' }}">{{ $kr->atribut }}</span>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @foreach($kameras as $kam)
                        <tr class="hover:bg-slate-50/50">
                            <td class="py-3.5 px-5 font-extrabold text-indigo-600">{{ $kam->kode }}</td>
                            <td class="py-3.5 px-5 font-bold text-slate-800">{{ $kam->nama }}</td>
                            @foreach($kriterias as $kr)
                                <td class="py-3.5 px-4 text-center font-mono font-bold text-slate-800">
                                    {{ number_format($matrixR[$kam->id][$kr->id] ?? 0, 2) }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- STEP 3-5: WSM, WPM, Qi -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50/50">
            <span class="px-2.5 py-1 rounded-full text-xs font-extrabold bg-emerald-50 text-emerald-600 uppercase">Langkah 3, 4 & 5</span>
            <h3 class="font-extrabold text-slate-800 text-base mt-2">Kalkulasi WSM, WPM & Qi</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-extrabold uppercase border-b border-slate-100">
                        <th class="py-4 px-6">Kode Kamera</th>
                        <th class="py-4 px-6">Nama Kamera</th>
                        <th class="py-4 px-6 text-center">WSM</th>
                        <th class="py-4 px-6 text-center">WPM</th>
                        <th class="py-4 px-6 text-center">Qi</th>
                        <th class="py-4 px-6 text-center">Peringkat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-semibold text-slate-700">
                    @foreach($rankings as $row)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-4 px-6 font-extrabold text-indigo-600">{{ $row['kamera']->kode }}</td>
                            <td class="py-4 px-6 font-bold text-slate-800">{{ $row['kamera']->nama }}</td>
                            <td class="py-4 px-6 text-center font-mono text-slate-700">{{ number_format($row['q1'], 3) }}</td>
                            <td class="py-4 px-6 text-center font-mono text-slate-700">{{ number_format($row['q2'], 3) }}</td>
                            <td class="py-4 px-6 text-center font-mono font-extrabold text-indigo-600 text-sm">{{ number_format($row['qi'], 3) }}</td>
                            <td class="py-4 px-6 text-center">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">Rank {{ $row['rank'] }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
