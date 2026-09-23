@extends('layouts.master')

@section('title', 'Pilih Alternatif Kamera - SPK WASPAS')

@section('content')
<div class="space-y-8">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-start gap-3">
            <div class="w-11 h-11 rounded-xl bg-indigo-600 text-white flex items-center justify-center shrink-0">
                <i class="fa-solid fa-filter"></i>
            </div>
            <div>
                <h2 class="text-xl font-extrabold text-slate-800 tracking-tight">Pilih Alternatif Kamera</h2>
                <p class="text-xs text-slate-400 font-medium mt-0.5">Tentukan kamera mana saja yang akan diikutkan dalam proses perhitungan perangkingan WASPAS.</p>
            </div>
        </div>
        <div class="relative w-full sm:w-64">
            <input type="text" id="searchKamera" onkeyup="filterKamera()" placeholder="Cari kamera..."
                   class="w-full pl-4 pr-10 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:ring-2 focus:ring-indigo-600 focus:outline-none">
            <i class="fa-solid fa-magnifying-glass absolute right-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
        </div>
    </div>

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold space-y-1">
            @foreach($errors->all() as $err)
                <p><i class="fa-solid fa-circle-exclamation text-sm mr-1"></i> {{ $err }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('hasil.preview') }}" method="POST">
        @csrf

        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 text-slate-500 text-xs font-extrabold uppercase tracking-wider border-b border-slate-100">
                            <th class="py-4 px-6">No</th>
                            <th class="py-4 px-6">
                                <label class="inline-flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" id="selectAll" onclick="toggleAll(this)" class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600">
                                    Pilih Semua
                                </label>
                            </th>
                            <th class="py-4 px-6">Kode</th>
                            <th class="py-4 px-6">Nama Kamera</th>
                            <th class="py-4 px-6">Merk</th>
                        </tr>
                    </thead>
                    <tbody id="kameraTableBody" class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                        @forelse($kameras as $i => $kam)
                            <tr class="kamera-row hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 text-slate-400">{{ $i + 1 }}</td>
                                <td class="py-4 px-6">
                                    <input type="checkbox" name="kamera_ids[]" value="{{ $kam->id }}" class="kamera-checkbox w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600">
                                </td>
                                <td class="py-4 px-6 font-extrabold text-indigo-600">{{ $kam->kode }}</td>
                                <td class="py-4 px-6 font-bold text-slate-800 kamera-nama">{{ $kam->nama }}</td>
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">{{ $kam->merk }}</span>
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

            <div class="p-6 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('hasil.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-md shadow-indigo-600/30 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-arrow-right"></i>
                    <span>Lanjutkan ke Pratinjau Perhitungan</span>
                </button>
            </div>
        </div>
    </form>

</div>

@push('scripts')
<script>
    function toggleAll(source) {
        document.querySelectorAll('.kamera-checkbox').forEach(cb => {
            if (cb.closest('tr').style.display !== 'none') {
                cb.checked = source.checked;
            }
        });
    }

    function filterKamera() {
        const keyword = document.getElementById('searchKamera').value.toLowerCase();
        document.querySelectorAll('.kamera-row').forEach(row => {
            const nama = row.querySelector('.kamera-nama').textContent.toLowerCase();
            row.style.display = nama.includes(keyword) ? '' : 'none';
        });
    }
</script>
@endpush
@endsection
