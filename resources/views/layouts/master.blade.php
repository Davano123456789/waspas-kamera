<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SPK WASPAS - Pemilihan Kamera')</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome CDN for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom smooth scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="font-sans antialiased text-slate-800 bg-[#f4f6fb] min-h-screen flex flex-col">

    <div class="flex flex-1 min-h-screen">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-x-hidden">
            <!-- Navbar -->
            @include('layouts.navbar')

            <!-- Main Body View -->
            <main class="flex-1 p-6 lg:p-8 max-w-7xl w-full mx-auto">
                @yield('content')
            </main>

            <!-- Footer -->
            @include('layouts.footer')
        </div>
    </div>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Mobile Sidebar Toggle
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('sidebarBackdrop').classList.toggle('hidden');
        }

        // Global SweetAlert Delete Confirmation Helper
        function confirmDelete(event, formElement, title = 'Apakah Anda yakin?', text = 'Data yang dihapus tidak dapat dikembalikan!') {
            event.preventDefault();
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-xl font-bold px-5 py-2.5',
                    cancelButton: 'rounded-xl font-bold px-5 py-2.5'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    formElement.submit();
                }
            });
        }

        // Global Session Flash Alerts
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
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#0f172a',
                    customClass: { popup: 'rounded-3xl', confirmButton: 'rounded-xl font-bold px-5 py-2.5' }
                });
            @endif

            @if(session('info'))
                Swal.fire({
                    icon: 'info',
                    title: 'Informasi',
                    text: "{{ session('info') }}",
                    confirmButtonColor: '#0f172a',
                    customClass: { popup: 'rounded-3xl', confirmButton: 'rounded-xl font-bold px-5 py-2.5' }
                });
            @endif
        });
    </script>

    @stack('scripts')
</body>
</html>
