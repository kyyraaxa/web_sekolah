<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Postingan & Berita - MTs. NW Karang Juli</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-heading { font-family: 'Plus Jakarta Sans', sans-serif; }
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

    <div class="absolute top-[-10%] left-[-10%] w-[50vw] h-[50vw] bg-emerald-400/20 rounded-full blur-[120px] pointer-events-none"></div>

    {{-- Navbar --}}
    <header class="w-full sticky top-0 z-50 px-4 py-3">
        <nav class="mx-auto max-w-7xl bg-white/20 backdrop-blur-xl border border-white/30 rounded-2xl px-6 py-3 flex justify-between items-center shadow-lg">
            {{-- Kiri: Logo & Nama Madrasah --}}
            <a href="/" class="flex items-center gap-3">
                <div class="p-1.5 bg-white/40 backdrop-blur-md border border-white/40 rounded-xl">
                    <img src="{{ asset('img/logo0.png') }}" alt="Logo" class="w-9 h-9 object-contain">
                </div>
                <div>
                    <span class="font-heading font-extrabold text-sm md:text-base text-white block">MTs. NW Karang Juli</span>
                    <span class="text-[9px] text-emerald-100 font-semibold block tracking-widest uppercase">YPPNW KADINDI</span>
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

    {{-- Konten Grid Postingan --}}
    <main class="mx-auto max-w-7xl px-4 md:px-6 py-12 w-full flex-1 space-y-10 relative z-10">
        
        <div class="text-center space-y-2">
            <span class="inline-flex px-3 py-1 rounded-full text-[11px] font-bold bg-white/10 border border-white/20">Madrasah Updates</span>
            <h1 class="font-heading text-3xl md:text-5xl font-black text-white tracking-tight drop-shadow-md">Postingan Terbaru</h1>
            <div class="h-1 w-16 bg-gradient-to-r from-amber-400 to-yellow-300 mx-auto rounded-full"></div>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            {{-- CARD 1: PPDB --}}
            <article class="bg-white/10 backdrop-blur-2xl rounded-3xl border border-white/20 shadow-xl overflow-hidden flex flex-col justify-between group transition-all duration-300 hover:scale-[1.02]">
                <div>
                    <div class="w-full h-48 overflow-hidden bg-emerald-950/20 relative">
                        <img src="{{ asset('img/SPMBmts.jpg') }}" alt="PPDB" class="w-full h-full object-cover transition duration-500 group-hover:scale-110" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1546410531-bb4caa6b424d?auto=format&fit=crop&w=600&q=80';">
                        <span class="absolute top-3 left-3 px-2.5 py-1 text-[10px] font-bold bg-amber-400 text-emerald-950 rounded-lg uppercase">Pengumuman</span>
                    </div>
                    <div class="p-6 space-y-3">
                        <span class="text-xs text-emerald-200/80 font-medium">01 Juni 2026</span>
                        <h3 class="font-heading text-base md:text-lg font-bold text-white leading-snug line-clamp-2">PPDB Tahun Ajaran 2026/2027 Telah Resmi Dibuka</h3>
                        <p class="text-xs md:text-sm text-emerald-50/70 line-clamp-3">MTs. NW Karang Juli membuka pendaftaran santri baru secara online dan offline. Mari bergabung menjadi generasi islami berwawasan IPTEK...</p>
                    </div>
                </div>
                <div class="p-6 pt-0 mt-auto flex justify-end">
                    <a href="{{ route('postingan.baca', 1) }}" class="inline-flex items-center gap-1 text-xs font-bold text-amber-300 hover:underline">Baca Selengkapnya <span>→</span></a>
                </div>
            </article>

            {{-- CARD 2: Workshop --}}
            <article class="bg-white/10 backdrop-blur-2xl rounded-3xl border border-white/20 shadow-xl overflow-hidden flex flex-col justify-between group transition-all duration-300 hover:scale-[1.02]">
                <div>
                    <div class="w-full h-48 overflow-hidden bg-emerald-950/20 relative">
                        <img src="{{ asset('img/MATAMUDA0.jpg') }}" alt="Workshop" class="w-full h-full object-cover transition duration-500 group-hover:scale-110" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=600&q=80';">
                        <span class="absolute top-3 left-3 px-2.5 py-1 text-[10px] font-bold bg-blue-400 text-zinc-950 rounded-lg uppercase">Kegiatan</span>
                    </div>
                    <div class="p-6 space-y-3">
                        <span class="text-xs text-emerald-200/80 font-medium">13 Juli 2026</span>
                        <h3 class="font-heading text-base md:text-lg font-bold text-white leading-snug line-clamp-2">Upacara Bendera & Pembukaan MATAMUDA/MPLS</h3>
                        <p class="text-xs md:text-sm text-emerald-50/70 line-clamp-3">Dokumentasi upacara bendera & pembukaan MATAMUDA/MPLS yg diselenggarakan oleh seluruh lembaga YPP NW KADINDI...</p>
                    </div>
                </div>
                <div class="p-6 pt-0 mt-auto flex justify-end">
                    <a href="{{ route('postingan.baca', 2) }}" class="inline-flex items-center gap-1 text-xs font-bold text-amber-300 hover:underline">Baca Selengkapnya <span>→</span></a>
                </div>
            </article>

            {{-- CARD 3: MTQ --}}
            <article class="bg-white/10 backdrop-blur-2xl rounded-3xl border border-white/20 shadow-xl overflow-hidden flex flex-col justify-between group transition-all duration-300 hover:scale-[1.02]">
                <div>
                    <div class="w-full h-48 overflow-hidden bg-emerald-950/20 relative">
                        <img src="{{ asset('img/JUARA2_0.jpg') }}" alt="Prestasi" class="w-full h-full object-cover transition duration-500 group-hover:scale-110" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?auto=format&fit=crop&w=600&q=80';">
                        <span class="absolute top-3 left-3 px-2.5 py-1 text-[10px] font-bold bg-rose-400 text-zinc-950 rounded-lg uppercase">Prestasi</span>
                    </div>
                    <div class="p-6 space-y-3">
                        <span class="text-xs text-emerald-200/80 font-medium">18 Agustus 2026</span>
                        <h3 class="font-heading text-base md:text-lg font-bold text-white leading-snug line-clamp-2">Santri MTs. NW Karang Juli Juara 2 Tingkat Kecamatan</h3>
                        <p class="text-xs md:text-sm text-emerald-50/70 line-clamp-3">Prestasi gemilang diraih dalam ajang perlombaan tari nasional dalam rangka memeriahkan HUT RI ke-80, membawa harum nama pondok pesantren...</p>
                    </div>
                </div>
                <div class="p-6 pt-0 mt-auto flex justify-end">
                    <a href="{{ route('postingan.baca', 3) }}" class="inline-flex items-center gap-1 text-xs font-bold text-amber-300 hover:underline">Baca Selengkapnya <span>→</span></a>
                </div>
            </article>

        </div>
    </main>

    <footer class="w-full px-4 py-4 relative z-10">
        <div class="mx-auto max-w-7xl bg-black/10 backdrop-blur-md border border-white/10 rounded-xl py-3 text-center text-xs text-emerald-100/70">
            &copy; 2026 MTs. NW Karang Juli.
        </div>
    </footer>
</body>
</html>