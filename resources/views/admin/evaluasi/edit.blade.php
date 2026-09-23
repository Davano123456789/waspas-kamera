@extends('layouts.master')

@section('title', 'Edit Evaluasi ' . $kamera->nama . ' - SPK WASPAS')

@section('content')
<div class="space-y-8 max-w-4xl mx-auto">

    <!-- Header Section -->
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('evaluasi.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition mb-2 inline-block">
                &larr; Kembali ke Daftar Penilaian
            </a>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">
                Input Penilaian: <span class="text-indigo-600">{{ $kamera->nama }}</span>
            </h2>
            <p class="text-xs text-slate-400 font-medium mt-1">Silakan pilih atau isi nilai yang paling sesuai dengan spesifikasi kamera.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold space-y-1">
            @foreach($errors->all() as $err)
                <p><i class="fa-solid fa-circle-exclamation text-sm mr-1"></i> {{ $err }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('evaluasi.storeOrUpdate', $kamera->id) }}" method="POST" class="space-y-6">
        @csrf

        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 lg:p-8 space-y-6">
            @foreach($kriterias as $kr)
                @php
                    $existing = $existingEvaluasi[$kr->id] ?? null;
                    $selectedSub = $existing ? $existing->sub_kriteria_id : null;
                    $currentRaw = $existing ? $existing->nilai_asli : '';
                @endphp

                <div class="pb-6 border-b border-slate-100 last:border-b-0 last:pb-0">
                    <h4 class="font-bold text-slate-800 text-sm">{{ $kr->nama }}</h4>
                    <p class="text-xs text-slate-400 font-medium mb-3">
                        {{ $kr->kode }} (Bobot: {{ rtrim(rtrim(number_format($kr->bobot_normalisasi, 2), '0'), '.') }}, Tipe: {{ ucfirst($kr->atribut) }})
                    </p>

                    @if($kr->tipe_input === 'rentang')
                        <input type="number"
                               step="0.01"
                               name="evaluasi[{{ $kr->id }}][nilai_manual]"
                               value="{{ $currentRaw }}"
                               placeholder="Masukkan nilai..."
                               required
                               class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:ring-2 focus:ring-indigo-600 focus:outline-none">

                        @if($kr->subKriteria->count())
                            <div class="mt-3 p-3.5 rounded-xl bg-indigo-50/60 border border-indigo-100 text-xs text-indigo-900 space-y-1">
                                <p class="font-bold flex items-center gap-1.5">
                                    <i class="fa-solid fa-circle-info"></i> Panduan Nilai
                                </p>
                                <ul class="space-y-0.5 pl-1">
                                    @foreach($kr->subKriteria->sortByDesc('nilai') as $sub)
                                        @php
                                            $min = $sub->nilai_min !== null ? rtrim(rtrim(number_format($sub->nilai_min, 2, '.', ''), '0'), '.') : '0';
                                            $maks = $sub->nilai_maks !== null ? rtrim(rtrim(number_format($sub->nilai_maks, 2, '.', ''), '0'), '.') : '∞';
                                        @endphp
                                        <li>
                                            <strong>{{ $sub->nilai }} ({{ $sub->nama }})</strong>:
                                            Batas Rentang {{ $min }} s.d. {{ $maks }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @else
                        <select name="evaluasi[{{ $kr->id }}][sub_kriteria_id]"
                                required
                                class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:ring-2 focus:ring-indigo-600 focus:outline-none">
                            <option value="">-- Pilih Penilaian --</option>
                            @foreach($kr->subKriteria as $sub)
                                <option value="{{ $sub->id }}" {{ $selectedSub == $sub->id ? 'selected' : '' }}>
                                    {{ $sub->nama }} (Skor {{ $sub->nilai }})
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>
            @endforeach

            <div class="pt-4 flex items-center justify-end gap-3">
                <a href="{{ route('evaluasi.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-md shadow-indigo-600/30 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Penilaian
                </button>
            </div>
        </div>
    </form>

</div>
@endsection
