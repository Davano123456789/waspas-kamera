@extends('layouts.master')

@section('title', 'Hasil Perangkingan Kamera - SPK WASPAS')

@section('content')
<div class="space-y-8">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Hasil Perangkingan WASPAS</h2>
            <p class="text-xs text-slate-400 font-medium mt-1">Laporan urutan rekomendasi kamera terbaik berdasarkan akumulasi metode WASPAS</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('waspas.cetak') }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-md shadow-indigo-500/20 transition-all">
                <i class="fa-solid fa-print"></i> Cetak Laporan
            </a>
        </div>
    </div>

    <!-- Top Recommendation Highlight Card -->
    @if(count($rankings) > 0)
        @php $winner = $rankings[0]; @endphp
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-amber-500 via-amber-600 to-indigo-700 p-8 lg:p-10 text-white shadow-xl shadow-amber-500/20">
            <div class="absolute -right-10 -bottom-10 w-72 h-72 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="flex items-center gap-6">
                    <div class="w-24 h-24 rounded-2xl bg-white p-2 flex items-center justify-center shrink-0 shadow-lg">
                        <i class="fa-solid fa-trophy text-amber-500 text-4xl"></i>
                    </div>
                    <div class="space-y-1">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 text-white text-xs font-extrabold backdrop-blur-sm border border-white/20 uppercase">
                            <i class="fa-solid fa-crown text-amber-300"></i> Rekomendasi Utama #1
                        </span>
                        <h3 class="text-2xl font-black text-white tracking-tight">{{ $winner['kamera']->nama }}</h3>
                        <p class="text-amber-100 text-xs font-medium">
                            Merk: {{ $winner['kamera']->merk }}
                        </p>
                    </div>
                </div>

                <div class="bg-white/15 backdrop-blur-md border border-white/20 p-5 rounded-2xl text-center min-w-[180px]">
                    <p class="text-xs font-bold text-amber-100 uppercase tracking-wider">Qi</p>
                    <h4 class="text-3xl font-black text-white mt-1">{{ number_format($winner['qi'], 3) }}</h4>
                    <span class="text-[10px] text-amber-200 block mt-1">Nilai Preferensi Tertinggi</span>
                </div>
            </div>
        </div>
    @endif

    <!-- Ranking Table -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800 text-base">Tabel Urutan Perangkingan WASPAS</h3>
            <span class="text-xs text-slate-400 font-medium">Diurutkan dari skor $Q_i$ terbesar ke terkecil</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-400 text-[11px] font-extrabold uppercase tracking-wider border-b border-slate-100">
                        <th class="py-4 px-6 text-center">Peringkat</th>
                        <th class="py-4 px-6">Kode & Kamera</th>
                        <th class="py-4 px-6">Merk</th>
                        <th class="py-4 px-6 text-center">WSM</th>
                        <th class="py-4 px-6 text-center">WPM</th>
                        <th class="py-4 px-6 text-center">Qi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                    @forelse($rankings as $row)
                        <tr class="hover:bg-slate-50/50 transition {{ $row['rank'] == 1 ? 'bg-amber-50/30 font-bold' : '' }}">
                            <td class="py-4 px-6 text-center">
                                @if($row['rank'] == 1)
                                    <span class="w-9 h-9 rounded-xl bg-amber-500 text-white font-black inline-flex items-center justify-center text-sm shadow-md shadow-amber-500/30">
                                        1
                                    </span>
                                @elseif($row['rank'] == 2)
                                    <span class="w-9 h-9 rounded-xl bg-slate-300 text-slate-800 font-black inline-flex items-center justify-center text-sm">
                                        2
                                    </span>
                                @elseif($row['rank'] == 3)
                                    <span class="w-9 h-9 rounded-xl bg-amber-700 text-white font-black inline-flex items-center justify-center text-sm">
                                        3
                                    </span>
                                @else
                                    <span class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 font-bold inline-flex items-center justify-center text-xs">
                                        {{ $row['rank'] }}
                                    </span>
                                @endif
                            </td>

                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <span class="font-extrabold text-indigo-600 text-xs bg-indigo-50 px-2 py-1 rounded-md">{{ $row['kamera']->kode }}</span>
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-sm">{{ $row['kamera']->nama }}</h4>
                                        <p class="text-xs text-slate-400 truncate max-w-xs">{{ $row['kamera']->deskripsi ?? '' }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                                    {{ $row['kamera']->merk }}
                                </span>
                            </td>

                            <td class="py-4 px-6 text-center font-mono text-xs text-slate-600">
                                {{ number_format($row['q1'], 3) }}
                            </td>

                            <td class="py-4 px-6 text-center font-mono text-xs text-slate-600">
                                {{ number_format($row['q2'], 3) }}
                            </td>

                            <td class="py-4 px-6 text-center font-mono font-black text-indigo-600 text-base">
                                {{ number_format($row['qi'], 3) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400">Belum ada data hasil perangkingan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
