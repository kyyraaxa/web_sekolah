<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMARTSCHOOL MANAGEMENT SYSTEM</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Script Deteksi Mode Otomatis Sistem Laptop & Inisialisasi Mermaid --}}
    <script src="https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.min.js"></script>
    <script>
        // 1. Cek Preferensi Mode Sistem Laptop/Browser
        const isDark = localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
        
        if (isDark) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        // 2. Setup Tema Diagram Mermaid agar Sinkron
        document.addEventListener("DOMContentLoaded", function() {
            mermaid.initialize({ 
                startOnLoad: true, 
                theme: isDark ? 'dark' : 'neutral',
                themeVariables: {
                    background: isDark ? '#18181b' : '#ffffff',
                    primaryColor: isDark ? '#27272a' : '#f4f4f5',
                    lineColor: isDark ? '#52525b' : '#d4d4d8'
                }
            });
        });
    </script>
</head>
<body class="bg-zinc-50 text-zinc-900 antialiased dark:bg-zinc-950 dark:text-zinc-100 min-h-screen flex flex-col justify-between transition-colors duration-200">
    
    {{-- Navbar --}}
    <nav class="border-b border-zinc-200 bg-white/80 backdrop-blur-md dark:border-zinc-800 dark:bg-zinc-900/80 sticky top-0 z-50">
        <div class="mx-auto max-w-7xl px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-600 text-white rounded-xl shadow-md shadow-blue-500/20">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l9-5-9-5-9 5 9 5zm0 0v6m0-6L3 9m9 5l9-5M9 21h6"></path></svg>
                </div>
                <div>
                    <span class="font-bold text-lg tracking-tight block leading-tight">SMARTSCHOOL MANAGEMENT SYSTEM</span>
                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Sistem Informasi Akademik Digital</span>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition shadow-sm">Masuk Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white transition">Log In</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition shadow-sm">Registrasi</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <main class="mx-auto max-w-7xl px-6 py-16 md:py-24 grid md:grid-cols-2 gap-12 items-center w-full flex-1">
        <div class="space-y-6">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-600 dark:bg-blue-950/50 dark:text-blue-400 border border-blue-200/50 dark:border-blue-800/30">
                <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span> Sistem Terintegrasi V2.0
            </span>
            <h1 class="text-4xl md:text-5xl font-black tracking-tight text-zinc-900 dark:text-white leading-tight">
                Modernisasi Manajemen <span class="text-blue-600">Absensi & Data</span> Sekolah.
            </h1>
            <p class="text-base text-zinc-600 dark:text-zinc-400 max-w-lg leading-relaxed">
                Akses rekap kehadiran siswa, jadwal pelajaran, manajemen nilai, dan pengumuman sekolah terpusat dalam satu platform digital yang responsif.
            </p>
            
            {{-- Tombol Utama Absensi --}}
            <div class="pt-2 pb-6 mb-4">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2.5 px-5 py-2.5 text-sm font-semibold rounded-xl transition shadow-sm bg-zinc-900 text-white hover:bg-zinc-800 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-200">
                    <span>Mulai Absensi Sekarang</span>
                    <svg class="w-4 h-4 text-zinc-400 dark:text-zinc-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        {{-- Grid Pintu Masuk Peran --}}
        <div class="grid grid-cols-2 gap-4">
            <div class="p-6 bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm space-y-4">
                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/50 text-blue-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-zinc-800 dark:text-white">Portal Siswa</h3>
                    <p class="text-xs text-zinc-500 mt-1 dark:text-zinc-400">Cek kehadiran mandiri, rekap nilai, dan tugas kelas.</p>
                </div>
            </div>

            <div class="p-6 bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm space-y-4">
                <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-950/50 text-purple-600 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v12a2 2 0 01-2 2zM12 11l5 5m0 0l-5 5m5-5H7"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-zinc-800 dark:text-white">Ruang Guru</h3>
                    <p class="text-xs text-zinc-500 mt-1 dark:text-zinc-400">Kelola absensi harian, input nilai, dan materi ajar.</p>
                </div>
            </div>

            <div class="p-6 bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm space-y-4 col-span-2">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-green-50 dark:bg-green-950/50 text-green-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-zinc-800 dark:text-white">Orang Tua / Wali</h3>
                            <p class="text-xs text-zinc-500 mt-0.5 dark:text-zinc-400">Pantau absensi real-time dan perkembangan studi anak.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>