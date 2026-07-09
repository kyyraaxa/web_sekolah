<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visi & Misi - MTs. NW Karang Juli</title>
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
<body class="liquid-bg text-zinc-100 antialiased min-h-screen flex flex-col justify-between relative">

    <!-- Ornamen Cairan Latar Belakang -->
    <div class="absolute top-[-10%] left-[-10%] w-[50vw] h-[50vw] bg-emerald-400/20 rounded-full blur-[120px] pointer-events-none"></div>

    {{-- 1. Navbar Kaca Kristal --}}
    <header class="w-full sticky top-0 z-50 px-4 py-3">
        <nav class="mx-auto max-w-7xl bg-white/20 backdrop-blur-xl border border-white/30 rounded-2xl px-6 py-3 flex justify-between items-center shadow-lg">
            {{-- Kiri: Logo & Nama Madrasah --}}
            <a href="/" class="flex items-center gap-3">
                <div class="p-1.5 bg-white/40 backdrop-blur-md border border-white/40 rounded-xl">
                    <img src="{{ asset('img/logo0.png') }}" alt="Logo" class="w-9 h-9 object-contain">
                </div>
                <div>
                    <span class="font-heading font-extrabold text-sm md:text-base text-white block">MTs. NW Karang Juli</span>
                    <span class="text-[9px] text-emerald-100 font-semibold block tracking-widest uppercase">YPP NW KADINDI</span>
                </div>
            </a>
            
            {{-- Kanan: Menu Navigasi (Terkunci) & Tombol Login --}}
            <div class="flex items-center gap-6">
                {{-- Link Menu Utama dengan Lebar Tetap (w-20 / w-24) agar tidak geser --}}
                <div class="hidden md:flex items-center text-sm font-semibold text-white/90 text-center">
                    <div class="w-20">
                        <a href="/" class="inline-block hover:text-amber-200 transition pb-0.5 {{ Request::is('/') ? 'text-white border-b-2 border-white' : '' }}">Beranda</a>
                    </div>
                    <div class="w-24">
                        <a href="{{ route('visi-misi') }}" class="inline-block hover:text-amber-200 transition pb-0.5 {{ Request::is('visi-misi') ? 'text-white border-b-2 border-white' : '' }}">Visi Misi</a>
                    </div>
                    <div class="w-20">
                        <a href="{{ route('profil') }}" class="inline-block hover:text-amber-200 transition pb-0.5 {{ Request::is('profil') ? 'text-white border-b-2 border-white' : '' }}">Profil</a>
                    </div>
                    <div class="w-24">
                        <a href="{{ route('postingan') }}" class="inline-block hover:text-amber-200 transition pb-0.5 {{ Request::is('postingan') || Request::is('postingan/*') ? 'text-white border-b-2 border-white' : '' }}">Postingan</a>
                    </div>
                </div>

                {{-- Tombol Login --}}
                <a href="{{ route('login') }}" class="px-5 py-2 text-xs md:text-sm font-bold text-white bg-white/10 hover:bg-white/20 border border-white/20 hover:border-white/40 rounded-xl transition-all duration-300 shadow-sm hover:text-amber-100 backdrop-blur-md">
                    Login
                </a>
            </div>
        </nav>
    </header>

    {{-- 2. Konten Utama Visi Misi --}}
    <main class="mx-auto max-w-4xl px-4 md:px-6 py-12 w-full flex-1 space-y-10 relative z-10">
        
        {{-- Header Judul --}}
        <div class="text-center space-y-3">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[11px] font-bold bg-white/10 text-white border border-white/20 backdrop-blur-md">
                Madrasah Goals & Guidelines
            </span>
            <h1 class="font-heading text-3xl md:text-5xl font-black text-white tracking-tight drop-shadow-md">Visi & Misi</h1>
            <p class="text-emerald-100/80 text-xs md:text-sm max-w-md mx-auto">Arah pandang dan komitmen nyata MTs. NW Karang Juli dalam mencetak generasi penerus bangsa.</p>
            <div class="h-1 w-16 bg-gradient-to-r from-amber-400 to-yellow-300 mx-auto rounded-full shadow-sm"></div>
        </div>

        {{-- BAGIAN VISI (Besar & Center Fokus) --}}
        <section class="bg-white/10 backdrop-blur-2xl p-8 rounded-3xl border border-white/25 shadow-2xl text-center relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 text-white text-7xl font-serif pointer-events-none">“</div>
            <span class="text-xs font-bold text-amber-300 uppercase tracking-widest block mb-2 drop-shadow-sm">Visi Madrasah</span>
            
            <h2 class="font-heading text-xl md:text-3xl font-extrabold text-white leading-relaxed max-w-2xl mx-auto drop-shadow-md">
                "Terwujudnya Generasi yang Berakhlaqul Karimah, Unggul dalam Prestasi, Berwawasan IPTEK, dan Teguh pada Khittah Nahdlatul Wathan."
            </h2>
            
            <div class="mt-4 text-[11px] text-emerald-200/90 font-medium tracking-wide uppercase italic">
                — Iman, Ilmu, & Amal Sholeh —
            </div>
        </section>

        {{-- BAGIAN MISI (Grid List Interaktif) --}}
        <section class="space-y-4">
            <h3 class="font-heading text-lg font-bold text-white flex items-center gap-2 drop-shadow-sm mb-2">
                Misi Strategis Kami
            </h3>
            
            <div class="grid gap-4">
                {{-- Misi 1 --}}
                <div class="flex gap-4 items-start bg-white/10 backdrop-blur-2xl p-5 rounded-2xl border border-white/20 shadow-xl transition-all duration-300 hover:bg-white/15">
                    <div class="w-8 h-8 rounded-xl bg-amber-400 text-emerald-950 flex items-center justify-center font-bold text-sm shadow-md flex-shrink-0">
                        1
                    </div>
                    <div>
                        <h4 class="font-heading font-bold text-white text-base mb-1">Pendidikan Karakter & Nilai Islami</h4>
                        <p class="text-sm text-emerald-50/90 leading-relaxed font-medium">Menyelenggarakan proses pembelajaran yang mengintegrasikan nilai-nilai kepesantrenan Aswaja untuk membentuk pribadi santri yang jujur, santun, dan berakhlak mulia.</p>
                    </div>
                </div>

                {{-- Misi 2 --}}
                <div class="flex gap-4 items-start bg-white/10 backdrop-blur-2xl p-5 rounded-2xl border border-white/20 shadow-xl transition-all duration-300 hover:bg-white/15">
                    <div class="w-8 h-8 rounded-xl bg-amber-400 text-emerald-950 flex items-center justify-center font-bold text-sm shadow-md flex-shrink-0">
                        2
                    </div>
                    <div>
                        <h4 class="font-heading font-bold text-white text-base mb-1">Peningkatan Mutu Akademik & Non-Akademik</h4>
                        <p class="text-sm text-emerald-50/90 leading-relaxed font-medium">Mengembangkan potensi kecerdasan intelektual, bakat, dan minat siswa secara optimal melalui program kurikuler dan ekstrakurikuler yang kompetitif.</p>
                    </div>
                </div>

                {{-- Misi 3 --}}
                <div class="flex gap-4 items-start bg-white/10 backdrop-blur-2xl p-5 rounded-2xl border border-white/20 shadow-xl transition-all duration-300 hover:bg-white/15">
                    <div class="w-8 h-8 rounded-xl bg-amber-400 text-emerald-950 flex items-center justify-center font-bold text-sm shadow-md flex-shrink-0">
                        3
                    </div>
                    <div>
                        <h4 class="font-heading font-bold text-white text-base mb-1">Adaptasi Teknologi Modern (IPTEK)</h4>
                        <p class="text-sm text-emerald-50/90 leading-relaxed font-medium">Menerapkan pemanfaatan teknologi informasi dan komunikasi (TIK) dalam sistem administrasi serta kegiatan belajar-mengajar guna menghadapi tantangan era digital.</p>
                    </div>
                </div>

                {{-- Misi 4 --}}
                <div class="flex gap-4 items-start bg-white/10 backdrop-blur-2xl p-5 rounded-2xl border border-white/20 shadow-xl transition-all duration-300 hover:bg-white/15">
                    <div class="w-8 h-8 rounded-xl bg-amber-400 text-emerald-950 flex items-center justify-center font-bold text-sm shadow-md flex-shrink-0">
                        4
                    </div>
                    <div>
                        <h4 class="font-heading font-bold text-white text-base mb-1">Pelestarian Khittah Nahdlatul Wathan</h4>
                        <p class="text-sm text-emerald-50/90 leading-relaxed font-medium">Menanamkan jiwa militansi perjuangan organisasi ke-NW-an yang cinta tanah air, taat kepada ulama, serta aktif berkontribusi bagi masyarakat luas.</p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    {{-- 3. Footer Transparan --}}
    <footer class="w-full px-4 md:px-6 py-4 relative z-10">
        <div class="mx-auto max-w-7xl bg-black/10 backdrop-blur-md border border-white/10 rounded-xl py-3 text-center text-xs font-medium text-emerald-100/70 tracking-wide">
            &copy; {{ date('Y') }} MTs. NW Karang Juli. Seluruh Hak Cipta Dilindungi.
        </div>
    </footer>

</body>
</html>