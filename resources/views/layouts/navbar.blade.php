<header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200/80 px-6 lg:px-8 flex items-center justify-between sticky top-0 z-30">
    <!-- Mobile Sidebar Toggle -->
    <button onclick="toggleSidebar()" class="lg:hidden w-10 h-10 rounded-xl flex items-center justify-center text-slate-600 hover:bg-slate-100 transition">
        <i class="fa-solid fa-bars text-lg"></i>
    </button>

    <!-- Right Profile Info -->
    <div class="flex items-center gap-3 cursor-pointer group">
        <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center ring-2 ring-indigo-500/20 shadow-sm uppercase">
            {{ substr(Auth::user()->name ?? 'U', 0, 2) }}
        </div>
        <div class="hidden sm:block text-left">
            <h4 class="text-sm font-bold text-slate-800 leading-tight">{{ Auth::user()->name ?? 'Pengguna' }}</h4>
            <p class="text-[11px] text-slate-400 font-medium capitalize">{{ Auth::user()->role ?? 'Guest' }}</p>
        </div>
    </div>
</header>
