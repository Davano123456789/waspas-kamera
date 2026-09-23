@extends('layouts.master')

@section('title', 'Edit Kriteria - SPK WASPAS')

@section('content')
<div class="space-y-8 max-w-4xl mx-auto">

    <!-- Header & Back Link -->
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('kriteria.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-900 transition inline-flex items-center gap-1 mb-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Data Kriteria
            </a>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Edit Kriteria {{ $kriteria->kode }}</h2>
            <p class="text-xs text-slate-400 font-medium mt-0.5">Ubah detail kriteria dan kelola pilihan sub-kriteria konversi nilai</p>
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

    <!-- Main Edit Form Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 lg:p-8 space-y-6">
        <h3 class="font-bold text-slate-800 text-base border-b border-slate-100 pb-3">Informasi Utama Kriteria</h3>

        <form action="{{ route('kriteria.update', $kriteria->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kode Kriteria <span class="text-rose-500">*</span></label>
                    <input type="text" 
                           name="kode" 
                           value="{{ old('kode', $kriteria->kode) }}" 
                           required 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:ring-2 focus:ring-slate-900 focus:bg-white focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Bobot Mentah <span class="text-rose-500">*</span></label>
                    <input type="number" 
                           step="0.01" 
                           name="bobot" 
                           value="{{ old('bobot', $kriteria->bobot) }}" 
                           required 
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:ring-2 focus:ring-slate-900 focus:bg-white focus:outline-none transition">
                    <p class="text-[11px] text-slate-400 mt-1 font-medium">Bobot Normalisasi: {{ number_format($kriteria->bobot_normalisasi, 4) }} ({{ number_format($kriteria->bobot_normalisasi * 100, 2) }}%)</p>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Kriteria <span class="text-rose-500">*</span></label>
                <input type="text" 
                       name="nama" 
                       value="{{ old('nama', $kriteria->nama) }}" 
                       required 
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:ring-2 focus:ring-slate-900 focus:bg-white focus:outline-none transition">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Atribut / Sifat Kriteria <span class="text-rose-500">*</span></label>
                    <select name="atribut" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:ring-2 focus:ring-slate-900 focus:bg-white focus:outline-none transition">
                        <option value="benefit" {{ old('atribut', $kriteria->atribut) === 'benefit' ? 'selected' : '' }}>Benefit (Semakin tinggi semakin baik)</option>
                        <option value="cost" {{ old('atribut', $kriteria->atribut) === 'cost' ? 'selected' : '' }}>Cost (Semakin rendah semakin baik)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tipe Input <span class="text-rose-500">*</span></label>
                    <select name="tipe_input" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 focus:ring-2 focus:ring-slate-900 focus:bg-white focus:outline-none transition">
                        <option value="pilihan" {{ old('tipe_input', $kriteria->tipe_input) === 'pilihan' ? 'selected' : '' }}>Pilihan (Dropdown)</option>
                        <option value="rentang" {{ old('tipe_input', $kriteria->tipe_input) === 'rentang' ? 'selected' : '' }}>Rentang (Input Manual Angka)</option>
                    </select>
                    <p class="text-[11px] text-slate-400 mt-1 font-medium">Mengubah tipe tidak otomatis mengubah sub-kriteria yang sudah ada — lengkapi batas min/maks di bawah kalau beralih ke Rentang.</p>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('kriteria.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-slate-900 hover:bg-blue-950 text-white font-bold text-xs rounded-xl shadow-lg shadow-slate-900/20 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i>
                    <span>Perbarui Kriteria</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Sub-Kriteria Options Management Section -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 lg:p-8 space-y-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
            <div>
                <h3 class="font-bold text-slate-800 text-base">Pilihan Sub-Kriteria & Skor Konversi</h3>
                <p class="text-xs text-slate-400 font-medium mt-0.5">Kelola rentang nilai spesifikasi dan skor numerik WASPAS (1-5)</p>
            </div>
            <span class="px-3 py-1 rounded-full text-xs font-extrabold bg-indigo-50 text-indigo-700 border border-indigo-100">
                {{ $kriteria->subKriteria->count() }} Pilihan Sub-Kriteria
            </span>
        </div>

        <!-- Form Add/Edit Sub-Kriteria Option -->
        <form id="subKriteriaForm" action="{{ route('sub-kriteria.store') }}" method="POST" class="bg-slate-50 p-4 rounded-2xl border border-slate-200/80 space-y-3">
            @csrf
            <input type="hidden" name="kriteria_id" value="{{ $kriteria->id }}">
            <div id="subMethodField"></div>
            <p id="subFormLabel" class="text-xs font-bold text-slate-700 uppercase">Tambah Pilihan Sub-Kriteria Baru</p>
            <div class="grid grid-cols-1 sm:grid-cols-{{ $kriteria->tipe_input === 'rentang' ? '5' : '3' }} gap-3">
                <div class="sm:col-span-2">
                    <input type="text" id="subNama" name="nama" placeholder="Label (misal: > 40 MP)" required class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-medium focus:ring-2 focus:ring-slate-900 focus:outline-none">
                </div>
                <div>
                    <input type="number" min="1" id="subNilai" name="nilai" placeholder="Skor Numerik" required class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-medium focus:ring-2 focus:ring-slate-900 focus:outline-none">
                </div>
                @if($kriteria->tipe_input === 'rentang')
                    <div>
                        <input type="number" step="0.01" id="subMin" name="nilai_min" placeholder="Batas Min" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-medium focus:ring-2 focus:ring-slate-900 focus:outline-none">
                    </div>
                    <div>
                        <input type="number" step="0.01" id="subMaks" name="nilai_maks" placeholder="Batas Maks" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-medium focus:ring-2 focus:ring-slate-900 focus:outline-none">
                    </div>
                @endif
            </div>
            @if($kriteria->tipe_input === 'rentang')
                <p class="text-[11px] text-slate-400 font-medium">Isi minimal salah satu batas (boleh kosongkan salah satu untuk rentang terbuka, misal "&gt; 40 MP" cukup isi Batas Min).</p>
            @endif
            <div class="text-right flex items-center justify-end gap-2">
                <button type="button" id="subCancelBtn" onclick="cancelEditSubKriteria()" class="hidden px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-bold transition">
                    Batal Edit
                </button>
                <button type="submit" id="subSubmitBtn" class="px-5 py-2 bg-slate-900 hover:bg-blue-950 text-white rounded-xl text-xs font-bold transition inline-flex items-center gap-1.5">
                    <i class="fa-solid fa-plus text-[10px]" id="subSubmitIcon"></i>
                    <span id="subSubmitText">Tambah Sub-Kriteria</span>
                </button>
            </div>
        </form>

        <!-- Sub-Kriteria List Table -->
        <div class="border border-slate-100 rounded-2xl overflow-hidden">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-400 font-extrabold uppercase tracking-wider border-b border-slate-100">
                        <th class="py-3.5 px-5">Label</th>
                        @if($kriteria->tipe_input === 'rentang')
                            <th class="py-3.5 px-5">Rentang</th>
                        @endif
                        <th class="py-3.5 px-5">Skor Konversi Numerik</th>
                        <th class="py-3.5 px-5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium text-slate-700">
                    @forelse($kriteria->subKriteria as $sub)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="py-3.5 px-5 font-bold text-slate-800">{{ $sub->nama }}</td>
                            @if($kriteria->tipe_input === 'rentang')
                                <td class="py-3.5 px-5 text-slate-500">
                                    {{ $sub->nilai_min !== null ? rtrim(rtrim(number_format($sub->nilai_min, 2, '.', ''), '0'), '.') : '−∞' }}
                                    &ndash;
                                    {{ $sub->nilai_maks !== null ? rtrim(rtrim(number_format($sub->nilai_maks, 2, '.', ''), '0'), '.') : '∞' }}
                                </td>
                            @endif
                            <td class="py-3.5 px-5">
                                <span class="px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-700 font-extrabold text-xs">
                                    Skor {{ $sub->nilai }}
                                </span>
                            </td>
                            <td class="py-3.5 px-5 text-center">
                                <div class="inline-flex items-center gap-1.5">
                                    <button type="button"
                                            onclick="editSubKriteria(this)"
                                            data-id="{{ $sub->id }}"
                                            data-nama="{{ $sub->nama }}"
                                            data-nilai="{{ $sub->nilai }}"
                                            data-min="{{ $sub->nilai_min }}"
                                            data-maks="{{ $sub->nilai_maks }}"
                                            data-update-url="{{ route('sub-kriteria.update', $sub->id) }}"
                                            class="px-3 py-1 bg-amber-50 hover:bg-amber-100 text-amber-600 rounded-lg text-xs font-bold transition flex items-center gap-1">
                                        <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                        <span>Edit</span>
                                    </button>
                                    <form action="{{ route('sub-kriteria.destroy', $sub->id) }}" method="POST" onsubmit="confirmDelete(event, this, 'Hapus Sub-Kriteria?', 'Pilihan sub-kriteria {{ $sub->nama }} akan dihapus!')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs font-bold transition flex items-center gap-1">
                                            <i class="fa-solid fa-trash text-[10px]"></i>
                                            <span>Hapus</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $kriteria->tipe_input === 'rentang' ? 4 : 3 }}" class="py-6 text-center text-slate-400 font-medium">Belum ada pilihan sub-kriteria yang ditambahkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('scripts')
<script>
    const subStoreUrl = "{{ route('sub-kriteria.store') }}";

    function editSubKriteria(btn) {
        document.getElementById('subNama').value = btn.dataset.nama;
        document.getElementById('subNilai').value = btn.dataset.nilai;

        const minField = document.getElementById('subMin');
        const maksField = document.getElementById('subMaks');
        if (minField) minField.value = btn.dataset.min !== '' ? btn.dataset.min : '';
        if (maksField) maksField.value = btn.dataset.maks !== '' ? btn.dataset.maks : '';

        document.getElementById('subKriteriaForm').action = btn.dataset.updateUrl;
        document.getElementById('subMethodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
        document.getElementById('subFormLabel').textContent = 'Edit Sub-Kriteria: ' + btn.dataset.nama;
        document.getElementById('subSubmitIcon').className = 'fa-solid fa-floppy-disk text-[10px]';
        document.getElementById('subSubmitText').textContent = 'Simpan Perubahan';
        document.getElementById('subCancelBtn').classList.remove('hidden');

        document.getElementById('subKriteriaForm').scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function cancelEditSubKriteria() {
        document.getElementById('subKriteriaForm').reset();
        document.getElementById('subKriteriaForm').action = subStoreUrl;
        document.getElementById('subMethodField').innerHTML = '';
        document.getElementById('subFormLabel').textContent = 'Tambah Pilihan Sub-Kriteria Baru';
        document.getElementById('subSubmitIcon').className = 'fa-solid fa-plus text-[10px]';
        document.getElementById('subSubmitText').textContent = 'Tambah Sub-Kriteria';
        document.getElementById('subCancelBtn').classList.add('hidden');
    }
</script>
@endpush
@endsection
