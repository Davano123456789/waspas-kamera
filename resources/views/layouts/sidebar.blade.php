<!-- Mobile Backdrop -->
<div id="sidebarBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden"></div>

<aside id="sidebar" class="w-64 bg-white border-r border-slate-200/80 flex flex-col shrink-0 h-screen fixed lg:sticky top-0 left-0 z-50 -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
    <!-- Brand / Logo -->
    <div class="h-20 flex items-center px-6 border-b border-slate-100">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <div>
                <h1 class="font-extrabold text-slate-900 text-lg leading-tight tracking-tight">WASPAS<span class="text-blue-900">Cam</span></h1>
                <p class="text-[11px] text-slate-400 font-medium tracking-wide">SPK Pemilihan Kamera</p>
            </div>
        </a>
    </div>

    <!-- Navigation Menu -->
    <div class="flex-1 py-6 px-4 space-y-1 overflow-y-auto">
        <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Menu Utama</p>

        @if(Auth::check() && Auth::user()->role === 'admin')
            <!-- Dashboard -->
            <a href="{{ url('/') }}"
               class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->is('admin/dashboard') || request()->is('/') ? 'bg-slate-900 text-white shadow-md shadow-slate-900/25' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900' }}">
                <i class="fa-solid fa-house text-base {{ request()->is('admin/dashboard') || request()->is('/') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Dashboard</span>
            </a>

            <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-6 mb-2">Master Data</p>

            <!-- Data Kamera -->
            <a href="{{ route('kamera.index') }}" 
               class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->is('admin/kamera*') ? 'bg-slate-900 text-white shadow-md shadow-slate-900/25' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900' }}">
                <i class="fa-solid fa-camera text-base {{ request()->is('admin/kamera*') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Data Kamera</span>
            </a>

            <!-- Data Kriteria -->
            <a href="{{ route('kriteria.index') }}" 
               class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->is('admin/kriteria*') ? 'bg-slate-900 text-white shadow-md shadow-slate-900/25' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900' }}">
                <i class="fa-solid fa-sliders text-base {{ request()->is('admin/kriteria*') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Data Kriteria</span>
            </a>

            <!-- Matriks Penilaian -->
            <a href="{{ route('evaluasi.index') }}" 
               class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->is('admin/evaluasi*') ? 'bg-slate-900 text-white shadow-md shadow-slate-900/25' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900' }}">
                <i class="fa-solid fa-table-cells text-base {{ request()->is('admin/evaluasi*') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Penilaian</span>
            </a>

            <p class="px-3 text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-6 mb-2">Metode WASPAS</p>

            <!-- Riwayat Perhitungan -->
            <a href="{{ route('hasil.index') }}"
               class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->is('admin/hasil-perhitungan*') ? 'bg-slate-900 text-white shadow-md shadow-slate-900/25' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900' }}">
                <i class="fa-solid fa-trophy text-base {{ request()->is('admin/hasil-perhitungan*') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Perhitungan</span>
            </a>
        @else
            <!-- Katalog Kamera -->
            <a href="{{ route('user.katalog') }}"
               class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->is('user/katalog*') || request()->is('user/kamera*') ? 'bg-slate-900 text-white shadow-md shadow-slate-900/25' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900' }}">
                <i class="fa-solid fa-camera text-base {{ request()->is('user/katalog*') || request()->is('user/kamera*') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Katalog Kamera</span>
            </a>

            <!-- Set Preferensi -->
            <a href="{{ route('user.rekomendasi') }}"
               class="flex items-center gap-3.5 px-3.5 py-3 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->is('user/rekomendasi*') ? 'bg-slate-900 text-white shadow-md shadow-slate-900/25' : 'text-slate-600 hover:bg-slate-100/80 hover:text-slate-900' }}">
                <i class="fa-solid fa-sliders text-base {{ request()->is('user/rekomendasi*') ? 'text-white' : 'text-slate-400' }}"></i>
                <span>Cari Rekomendasi</span>
            </a>
        @endif
    </div>

    <!-- User / Logout Footer -->
    <div class="p-4 border-t border-slate-100">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-100/80 text-slate-600 hover:text-red-600 transition-all duration-200 group">
                <div class="w-9 h-9 rounded-lg bg-red-50 text-red-500 flex items-center justify-center group-hover:bg-red-500 group-hover:text-white transition-all">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </div>
                <span class="text-sm font-semibold">Keluar</span>
            </button>
        </form>
    </div>
</aside>
