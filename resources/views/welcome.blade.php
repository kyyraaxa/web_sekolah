<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MTs. NW Karang Juli - Official Website</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-heading { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Custom Background Animasi Cairan (Liquid Mesh) */
        .liquid-bg {
            background: linear-gradient(135deg, #047857 0%, #10b981 40%, #f59e0b 100%);
            background-size: 200% 200%;
            animation: liquidMovement 15s ease infinite;
        }

        @keyframes liquidMovement {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
    </style>
</head>
<body class="liquid-bg text-zinc-900 antialiased min-h-screen flex flex-col justify-between selection:bg-emerald-600 selection:text-white relative">

    <!-- Ornamen Cairan Abstrak Tambahan di Latar Belakang -->
    <div class="absolute top-[-10%] left-[-10%] w-[50vw] h-[50vw] bg-emerald-400/30 rounded-full blur-[120px] pointer-events-none animate-pulse"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40vw] h-[40vw] bg-amber-300/30 rounded-full blur-[100px] pointer-events-none"></div>

    {{-- 1. Navbar Kaca Kristal --}}
    <header class="w-full sticky top-0 z-50 px-4 md:px-6 py-3">
        <nav class="mx-auto max-w-7xl bg-white/20 dark:bg-zinc-900/20 backdrop-blur-xl border border-white/30 dark:border-white/10 rounded-2xl px-6 py-3 flex justify-between items-center shadow-lg shadow-emerald-950/10">
            {{-- Kiri: Logo & Nama Sekolah --}}
            <a href="/" class="flex items-center gap-3 group">
                <div class="p-1.5 bg-white/40 backdrop-blur-md border border-white/40 rounded-xl transition group-hover:scale-105 shadow-sm">
                    <img src="{{ asset('img/logonw.png') }}" alt="Logo MTs. NW" class="w-9 h-9 object-contain">
                </div>
                <div>
                    <span class="font-heading font-extrabold text-sm md:text-base tracking-tight block text-white drop-shadow-sm leading-tight">MTs. NW Karang Juli</span>
                    <span class="text-[9px] md:text-[10px] text-emerald-100 font-semibold block tracking-widest uppercase opacity-90">YPP NW KADINDI</span>
                </div>
            </a>
            
            {{-- Kanan: Navigasi Menu & Akses --}}
            <div class="flex items-center gap-6">
                <!-- Menu Navigasi (Desktop Only) -->
                <div class="hidden md:flex items-center gap-6 text-sm font-semibold text-white/90">
                    <a href="/" class="text-white border-b-2 border-white pb-0.5 drop-shadow-sm">Beranda</a>
                    <a href="{{ route('visi-misi') }}" class="hover:text-amber-200 transition pb-0.5">Visi Misi</a>
                    <a href="{{ route('profil') }}" class="hover:text-amber-200 transition pb-0.5">Profil</a>
                    <a href="{{ route('postingan') }}" class="hover:text-amber-200 transition pb-0.5">Postingan</a>
                </div>
                
                <!-- Tombol Aksi Kaca -->
                <div class="flex items-center gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-xs md:text-sm font-bold text-emerald-900 bg-white hover:bg-emerald-50 rounded-xl transition shadow-md">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-xs md:text-sm font-bold text-white hover:text-amber-100 transition">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-xs md:text-sm font-bold text-emerald-900 bg-white/90 hover:bg-white border border-white/50 rounded-xl transition shadow-md transform hover:-translate-y-0.5">
                            Registrasi
                        </a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    {{-- 2. Hero Section (Liquid Glass Card) --}}
    <main class="w-full flex-1 flex items-center justify-center relative z-10 py-12 md:py-20 px-4 md:px-6">
        <div class="text-center flex flex-col items-center max-w-4xl mx-auto w-full">
            
            {{-- Lencana Selamat Datang Kaca Semi-Transparan --}}
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-[11px] font-bold bg-white/10 text-white border border-white/20 backdrop-blur-md shadow-sm mb-6 uppercase tracking-wider">
                <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span> Official Website Portal
            </span>

            {{-- Judul Utama dengan Bayangan Teks Lembut --}}
            <h1 class="font-heading text-4xl md:text-6xl font-extrabold tracking-tight text-white leading-[1.15] mb-6 drop-shadow-md">
                Welcome To <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 via-amber-200 to-white drop-shadow-sm">
                    MTs. NW Karang Juli
                </span>
            </h1>

            {{-- Deskripsi --}}
            <p class="text-emerald-50/80 text-sm md:text-base max-w-xl mx-auto leading-relaxed mb-10 drop-shadow-sm font-medium">
                Pusat integrasi data akademik siswa, layanan administrasi digital, dan media komunikasi resmi civitas akademika Madrasah.
            </p>

            {{-- MASTERPIECE: Liquid Glass Card (Papan Nama Utama) --}}
            <div class="w-full max-w-2xl bg-white/10 dark:bg-zinc-900/10 backdrop-blur-2xl p-6 md:p-8 rounded-3xl shadow-2xl shadow-emerald-950/30 border border-white/30 dark:border-white/10 relative group transition-all duration-500 hover:scale-[1.01] hover:border-white/50">
                
                {{-- Refleksi Kilau Kaca Gradasi --}}
                <div class="absolute inset-0 bg-gradient-to-tr from-white/0 via-white/5 to-white/20 rounded-3xl pointer-events-none"></div>

                <div class="flex flex-col sm:flex-row items-center justify-between gap-6 relative z-10">
                    <!-- Kiri: Logo Transparan & Identitas -->
                    <div class="flex flex-col sm:flex-row items-center gap-4 text-center sm:text-left">
                        <div class="p-2 bg-white/10 rounded-2xl border border-white/20 backdrop-blur-md shadow-inner">
                            <img src="{{ asset('img/logonw.png') }}" alt="Logo Madrasah" class="w-16 h-16 md:w-20 md:h-20 object-contain transform transition duration-500 group-hover:rotate-3">
                        </div>
                        <div>
                            <h2 class="font-heading text-xl font-bold text-white tracking-tight leading-snug drop-shadow-sm">
                                Madrasah Tsanawiyah <br class="hidden sm:inline"> Nahdlatul Wathan
                            </h2>
                            <p class="text-xs font-bold text-amber-300 mt-1 tracking-wider uppercase drop-shadow-sm">
                                Terakreditasi BAN-PDM
                            </p>
                        </div>
                    </div>

                    <!-- Kanan: Tombol Akses Utama Gaya Liquid Glass -->
                    <div class="w-full sm:w-auto border-t sm:border-t-0 sm:border-l border-white/20 pt-4 sm:pt-0 sm:pl-6 flex flex-col justify-center">
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3.5 font-bold text-sm text-emerald-950 bg-gradient-to-r from-amber-300 to-yellow-400 hover:from-white hover:to-white rounded-xl transition-all duration-300 shadow-lg shadow-amber-500/20 transform hover:-translate-y-0.5">
                            <span>Mulai Akses</span>
                            <svg class="w-4 h-4 text-emerald-950 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </main>

    {{-- 3. Footer Transparan --}}
    <footer class="w-full px-4 md:px-6 py-4 relative z-10">
        <div class="mx-auto max-w-7xl bg-black/10 backdrop-blur-md border border-white/10 rounded-xl py-3 text-center text-xs font-medium text-emerald-100/70 tracking-wide">
            &copy; {{ date('Y') }} MTs. NW Karang Juli. Seluruh Hak Cipta Dilindungi.
        </div>
    </footer>

</body>
</html>