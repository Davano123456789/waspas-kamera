@extends('layouts.master')

@section('title', 'Tambah Kriteria Baru - SPK WASPAS')

@section('content')
<div class="space-y-8 max-w-3xl mx-auto">

    <!-- Header & Back Link -->
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('kriteria.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-900 transition inline-flex items-center gap-1 mb-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Data Kriteria
            </a>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Tambah Kriteria Baru</h2>
            <p class="text-xs text-slate-400 font-medium mt-0.5">Isi formulir berikut untuk menambahkan kriteria acuan penilaian baru</p>
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
        <form action="{{ route('kriteria.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kode Kriteria <span class="text-rose-500">*</span></label>
                    <input type="text" 
                           name="kode" 
                           value="{{ old('kode') }}"
                           placeholder="misal: C10" 
                           required 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:ring-2 focus:ring-slate-900 focus:bg-white focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Bobot Mentah <span class="text-rose-500">*</span></label>
                    <input type="number" 
                           step="0.01" 
                           name="bobot" 
                           value="{{ old('bobot') }}"
                           placeholder="misal: 90" 
                           required 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:ring-2 focus:ring-slate-900 focus:bg-white focus:outline-none transition">
                    <p class="text-[11px] text-slate-400 mt-1 font-medium">Sistem akan otomatis menghitung bobot ternormalisasi ($w_j$).</p>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Kriteria <span class="text-rose-500">*</span></label>
                <input type="text" 
                       name="nama" 
                       value="{{ old('nama') }}"
                       placeholder="misal: Ketahanan Baterai" 
                       required 
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:ring-2 focus:ring-slate-900 focus:bg-white focus:outline-none transition">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Atribut / Sifat Kriteria <span class="text-rose-500">*</span></label>
                    <select name="atribut" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:ring-2 focus:ring-slate-900 focus:bg-white focus:outline-none transition">
                        <option value="benefit" {{ old('atribut') === 'benefit' ? 'selected' : '' }}>Benefit (Semakin tinggi semakin baik)</option>
                        <option value="cost" {{ old('atribut') === 'cost' ? 'selected' : '' }}>Cost (Semakin rendah semakin baik)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tipe Input <span class="text-rose-500">*</span></label>
                    <select name="tipe_input" id="tipeInputSelect" required onchange="onTipeInputChange()" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:ring-2 focus:ring-slate-900 focus:bg-white focus:outline-none transition">
                        <option value="pilihan" {{ old('tipe_input', 'pilihan') === 'pilihan' ? 'selected' : '' }}>Pilihan (Dropdown)</option>
                        <option value="rentang" {{ old('tipe_input') === 'rentang' ? 'selected' : '' }}>Rentang (Input Manual Angka)</option>
                    </select>
                </div>
            </div>

            <!-- Sub-Kriteria Builder -->
            <div class="pt-4 border-t border-slate-100 space-y-3" id="subKriteriaBuilder">
                <div class="flex items-center justify-between">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Sub-Kriteria</label>
                        <p class="text-[11px] text-slate-400 font-medium mt-0.5">
                            <span id="hintPilihan">Isi nama pilihan dan skornya.</span>
                            <span id="hintRentang" class="hidden">Isi label, skor, dan batas minimum/maksimum (boleh salah satu dikosongkan untuk rentang terbuka, misal "&gt; 40 MP" cukup isi minimum).</span>
                        </p>
                    </div>
                    <button type="button" onclick="addSubRow()" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition inline-flex items-center gap-1.5">
                        <i class="fa-solid fa-plus text-[10px]"></i> Tambah Baris
                    </button>
                </div>

                <div id="subKriteriaRows" class="space-y-2"></div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('kriteria.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-blue-950 text-white font-bold text-xs rounded-xl shadow-lg shadow-slate-900/20 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Simpan Kriteria</span>
                </button>
            </div>
        </form>
    </div>

</div>

@push('scripts')
<script>
    let subRowIndex = 0;

    function currentTipeInput() {
        return document.getElementById('tipeInputSelect').value;
    }

    function addSubRow() {
        const i = subRowIndex++;
        const isRentang = currentTipeInput() === 'rentang';
        const wrapper = document.createElement('div');
        wrapper.className = 'p-3 rounded-xl bg-slate-50 border border-slate-200/80 grid grid-cols-1 sm:grid-cols-12 gap-2 items-center sub-row';
        wrapper.innerHTML = `
            <div class="sm:col-span-4">
                <input type="text" name="sub[${i}][nama]" placeholder="Label (misal: > 40 MP)" required
                    class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-medium focus:ring-2 focus:ring-slate-900 focus:outline-none">
            </div>
            <div class="sm:col-span-2">
                <input type="number" step="1" min="1" name="sub[${i}][nilai]" placeholder="Skor" required
                    class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-bold text-center focus:ring-2 focus:ring-slate-900 focus:outline-none">
            </div>
            <div class="sm:col-span-2 range-field ${isRentang ? '' : 'hidden'}">
                <input type="number" step="0.01" name="sub[${i}][nilai_min]" placeholder="Min"
                    class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-medium focus:ring-2 focus:ring-slate-900 focus:outline-none">
            </div>
            <div class="sm:col-span-2 range-field ${isRentang ? '' : 'hidden'}">
                <input type="number" step="0.01" name="sub[${i}][nilai_maks]" placeholder="Maks"
                    class="w-full px-3 py-2 bg-white border border-slate-200 rounded-lg text-xs font-medium focus:ring-2 focus:ring-slate-900 focus:outline-none">
            </div>
            <div class="sm:col-span-2 text-right">
                <button type="button" onclick="this.closest('.sub-row').remove()" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs font-bold transition">
                    Hapus
                </button>
            </div>
        `;
        document.getElementById('subKriteriaRows').appendChild(wrapper);
    }

    function onTipeInputChange() {
        const isRentang = currentTipeInput() === 'rentang';
        document.querySelectorAll('.range-field').forEach(el => el.classList.toggle('hidden', !isRentang));
        document.getElementById('hintPilihan').classList.toggle('hidden', isRentang);
        document.getElementById('hintRentang').classList.toggle('hidden', !isRentang);
    }

    // Start with one empty row for convenience
    addSubRow();
    onTipeInputChange();
</script>
@endpush
@endsection
