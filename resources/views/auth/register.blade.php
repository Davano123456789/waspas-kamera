<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SPK WASPAS Kamera</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased text-slate-800 bg-[#f4f6fb] min-h-screen flex items-center justify-center p-4 lg:p-8">

    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-xl border border-slate-200/80 overflow-hidden grid grid-cols-1 md:grid-cols-2">
        
        <!-- Left Banner Column (Visual Branding) -->
        <div class="relative bg-gradient-to-br from-slate-950 via-slate-900 to-blue-950 p-8 lg:p-12 text-white flex flex-col justify-between overflow-hidden">
            <!-- Background Glow & Shapes -->
            <div class="absolute -right-16 -top-16 w-64 h-64 rounded-full bg-blue-500/10 blur-2xl pointer-events-none"></div>
            <div class="absolute -left-16 -bottom-16 w-64 h-64 rounded-full bg-slate-500/20 blur-2xl pointer-events-none"></div>

            <!-- Top Logo -->
            <div class="relative z-10">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white text-slate-900 flex items-center justify-center font-bold shadow-md text-xl">
                        <i class="fa-solid fa-camera-retro"></i>
                    </div>
                    <span class="font-extrabold text-white text-xl tracking-tight">WASPAS<span class="text-blue-300">Cam</span></span>
                </a>
            </div>

            <!-- Center Illustration / Hero Text -->
            <div class="relative z-10 my-8 space-y-4">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/15 text-xs font-semibold backdrop-blur-sm border border-white/10">
                    <i class="fa-solid fa-user-plus text-amber-300"></i> Buat Akun Baru
                </span>
                <h2 class="text-2xl lg:text-3xl font-extrabold leading-snug tracking-tight text-white">
                    Bergabung dengan WASPAS Kamera
                </h2>
                <p class="text-slate-300/90 text-sm leading-relaxed">
                    Dapatkan rekomendasi kamera terbaik yang dipersonalisasi khusus berdasarkan preferensi budget & kebutuhan fotografi Anda.
                </p>
            </div>

            <!-- Bottom Info -->
            <div class="relative z-10 pt-4 border-t border-white/15 flex items-center justify-between text-xs text-slate-300">
                <span>&copy; {{ date('Y') }} WASPAS Cam</span>
                <a href="{{ url('/') }}" class="hover:text-white transition font-medium">Kembali ke Beranda &rarr;</a>
            </div>
        </div>

        <!-- Right Form Column -->
        <div class="p-8 lg:p-12 flex flex-col justify-center">
            <div class="mb-6">
                <h3 class="text-2xl font-extrabold text-slate-900 tracking-tight">Buat Akun Anda</h3>
                <p class="text-slate-400 text-sm mt-1 font-medium">Isi formulir berikut untuk mendaftar akun</p>
            </div>

            @if($errors->any())
                <div class="mb-4 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold space-y-1">
                    @foreach($errors->all() as $err)
                        <p><i class="fa-solid fa-circle-exclamation text-sm mr-1"></i> {{ $err }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Name Field -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                            <i class="fa-solid fa-user text-sm"></i>
                        </span>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name') }}"
                               placeholder="Nama Lengkap Anda" 
                               required 
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:bg-white transition">
                    </div>
                </div>

                <!-- Email Field -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                            <i class="fa-solid fa-envelope text-sm"></i>
                        </span>
                        <input type="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               placeholder="nama@email.com" 
                               required 
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:bg-white transition">
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </span>
                        <input type="password" 
                               id="passwordInput"
                               name="password" 
                               placeholder="Minimal 8 karakter" 
                               required 
                               class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:bg-white transition">
                        <button type="button" 
                                onclick="togglePasswordVisibility('passwordInput', 'toggleIcon1')" 
                                class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600">
                            <i class="fa-solid fa-eye text-sm" id="toggleIcon1"></i>
                        </button>
                    </div>
                </div>

                <!-- Password Confirmation Field -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Konfirmasi Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                            <i class="fa-solid fa-shield-check text-sm"></i>
                        </span>
                        <input type="password" 
                               id="passwordConfirmInput"
                               name="password_confirmation" 
                               placeholder="Ulangi password Anda" 
                               required 
                               class="w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-900 focus:bg-white transition">
                        <button type="button" 
                                onclick="togglePasswordVisibility('passwordConfirmInput', 'toggleIcon2')" 
                                class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600">
                            <i class="fa-solid fa-eye text-sm" id="toggleIcon2"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full mt-2 py-3 px-4 bg-slate-900 hover:bg-blue-950 text-white font-bold text-sm rounded-xl shadow-lg shadow-slate-900/30 transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>Daftar Akun Sekarang</span>
                </button>
            </form>

            <!-- Bottom Link -->
            <div class="mt-6 text-center pt-4 border-t border-slate-100">
                <p class="text-xs text-slate-500 font-medium">
                    Sudah memiliki akun? 
                    <a href="{{ route('login') }}" class="font-bold text-slate-900 hover:text-blue-900 transition ml-1">
                        Masuk disini
                    </a>
                </p>
            </div>
        </div>

    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function togglePasswordVisibility(inputId, iconId) {
            const pwdInput = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                pwdInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#0f172a',
                    customClass: { popup: 'rounded-3xl', confirmButton: 'rounded-xl font-bold px-5 py-2.5' }
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Pendaftaran',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#0f172a',
                    customClass: { popup: 'rounded-3xl', confirmButton: 'rounded-xl font-bold px-5 py-2.5' }
                });
            @endif
        });
    </script>
</body>
</html>
