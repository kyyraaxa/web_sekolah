<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Postingan - MTs. NW Karang Juli</title>
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

    {{-- Header / Navbar Detail --}}
    <header class="w-full sticky top-0 z-50 px-4 py-3">
        <nav class="mx-auto max-w-7xl bg-white/20 backdrop-blur-xl border border-white/30 rounded-2xl px-6 py-3 flex justify-between items-center shadow-lg">
            <a href="/" class="flex items-center gap-3">
                <div class="p-1.5 bg-white/40 backdrop-blur-md border border-white/40 rounded-xl">
                    <img src="{{ asset('img/logo0.png') }}" alt="Logo" class="w-9 h-9 object-contain">
                </div>
                <span class="font-heading font-extrabold text-sm text-white">MTs. NW Karang Juli</span>
            </a>
            <a href="{{ route('postingan') }}" class="text-xs md:text-sm font-bold text-amber-300 hover:underline flex items-center gap-1">
                ← Kembali ke Berita
            </a>
        </nav>
    </header>

    {{-- Konten Utama Baca Artikel --}}
    <main class="mx-auto max-w-3xl px-4 py-10 w-full flex-1 relative z-10">
        <article class="bg-white/10 backdrop-blur-2xl p-6 md:p-10 rounded-3xl border border-white/20 shadow-2xl space-y-6">
            
            {{-- Kondisi Deteksi ID untuk Menampilkan Berita Sesuai Yang Diklik --}}
            @if($id == 1)
                <div class="flex items-center gap-3 text-xs">
                    <span class="px-2.5 py-1 font-bold bg-amber-400 text-emerald-950 rounded-lg uppercase">Pengumuman</span>
                    <span class="text-emerald-100/70">01 Juni 2026</span>
                </div>
                <h1 class="font-heading text-2xl md:text-4xl font-extrabold text-white leading-tight">PPDB Tahun Ajaran 2026/2027 Telah Resmi Dibuka</h1>
                
                {{--  SLOT FOTO BERITA 1 --}}
                <div class="w-full bg-white/5 rounded-2xl border border-white/10 p-2 overflow-hidden shadow-inner">
                    <img src="{{ asset('img/SPMBmts.jpg') }}" alt="Detail PPDB" class="w-full h-64 md:h-96 object-cover rounded-xl" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1546410531-bb4caa6b424d?auto=format&fit=crop&w=1200&q=80';">
                </div>

                <div class="text-emerald-50 text-sm md:text-base leading-relaxed space-y-4 font-medium">
                    <p>Pendaftaran resmi santri baru di MTs. NW Karang Juli telah resmi dibuka mulai hari ini. Pihak madrasah memfasilitasi jalur pendaftaran berbasis online guna mempermudah akses bagi calon pendaftar dari luar wilayah.</p>
                    <p>Seluruh berkas persyaratan seperti SKL, Kartu Keluarga, serta Akta kelahiran dapat langsung divalidasi ke bagian sekretariat pendaftaran pada jam kerja operasional madrasah.</p>
                </div>
                {{-- Berita 1.1 --}}
                <div class="flex items-center gap-3 text-xs">
                    <span class="px-2.5 py-1 font-bold bg-amber-400 text-emerald-950 rounded-lg uppercase">Pengumuman</span>
                    <span class="text-emerald-100/70">01 Juni 2026</span>
                </div>
                <h1 class="font-heading text-2xl md:text-4xl font-extrabold text-white leading-tight">PPDB Tahun Ajaran 2026/2027 Telah Resmi Dibuka</h1>
                
                <div class="w-full bg-white/5 rounded-2xl border border-white/10 p-2 overflow-hidden shadow-inner">
                    <img src="{{ asset('img/berita1.jpg') }}" alt="Detail PPDB" class="w-full h-64 md:h-96 object-cover rounded-xl" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1546410531-bb4caa6b424d?auto=format&fit=crop&w=1200&q=80';">
                </div>

                <div class="text-emerald-50 text-sm md:text-base leading-relaxed space-y-4 font-medium">
                    <p>Pendaftaran resmi santri baru di MTs. NW Karang Juli telah resmi dibuka mulai hari ini. Pihak madrasah memfasilitasi jalur pendaftaran berbasis online guna mempermudah akses bagi calon pendaftar dari luar wilayah.</p>
                    <p>Seluruh berkas persyaratan seperti SKL, Kartu Keluarga, serta Akta kelahiran dapat langsung divalidasi ke bagian sekretariat pendaftaran pada jam kerja operasional madrasah.</p>
                </div>
            @endif

            @if($id == 2)
                <div class="flex items-center gap-3 text-xs">
                    <span class="px-2.5 py-1 font-bold bg-blue-400 text-zinc-950 rounded-lg uppercase">Kegiatan</span>
                    <span class="text-emerald-100/70">13 Juli 2026</span>
                </div>
                <h1 class="font-heading text-2xl md:text-4xl font-extrabold text-white leading-tight">Upacara Bendera & Pembukaan MATAMUDA/MPLS</h1>
                
                {{-- SLOT FOTO BERITA 2 --}}
                <div class="w-full bg-white/5 rounded-2xl border border-white/10 p-2 overflow-hidden shadow-inner">
                    <img src="{{ asset('img/MATAMUDA0.jpg') }}" alt="Detail Workshop" class="w-full h-64 md:h-96 object-cover rounded-xl" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=1200&q=80';">
                </div>

                <div class="text-emerald-50 text-sm md:text-base leading-relaxed space-y-4 font-medium">
                    <p>Dokumentasi upacara bendera & pembukaan MATAMUDA/MPLS yg diselenggarakan oleh seluruh lembaga YPP NW KADINDI.</p>
                </div>
                {{-- Berita 2.1 --}}
                <div class="flex items-center gap-3 text-xs">
                    <span class="px-2.5 py-1 font-bold bg-blue-400 text-zinc-950 rounded-lg uppercase">Kegiatan</span>
                    <span class="text-emerald-100/70">13 Juli 2026</span>
                </div>
                <h1 class="font-heading text-2xl md:text-4xl font-extrabold text-white leading-tight"></h1>
                
                <div class="w-full bg-white/5 rounded-2xl border border-white/10 p-2 overflow-hidden shadow-inner">
                    <img src="{{ asset('img/MATAMUDA1.jpg') }}" alt="Detail Workshop" class="w-full h-64 md:h-96 object-cover rounded-xl" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=1200&q=80';">
                </div>

                <div class="text-emerald-50 text-sm md:text-base leading-relaxed space-y-4 font-medium">
                    <p>.</p>
                </div>
                {{-- Berita 2.2 --}}
                <div class="flex items-center gap-3 text-xs">
                    <span class="px-2.5 py-1 font-bold bg-blue-400 text-zinc-950 rounded-lg uppercase">Kegiatan</span>
                    <span class="text-emerald-100/70">13 Juli 2026</span>
                </div>
                <h1 class="font-heading text-2xl md:text-4xl font-extrabold text-white leading-tight"></h1>
                
                <div class="w-full bg-white/5 rounded-2xl border border-white/10 p-2 overflow-hidden shadow-inner">
                    <img src="{{ asset('img/MATAMUDA2.jpg') }}" alt="Detail Workshop" class="w-full h-64 md:h-96 object-cover rounded-xl" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=1200&q=80';">
                </div>

                <div class="text-emerald-50 text-sm md:text-base leading-relaxed space-y-4 font-medium">
                    <p>.</p>
                </div>
                {{-- Berita 2.3 --}}
                <div class="flex items-center gap-3 text-xs">
                    <span class="px-2.5 py-1 font-bold bg-blue-400 text-zinc-950 rounded-lg uppercase">Kegiatan</span>
                    <span class="text-emerald-100/70">13 Juli 2026</span>
                </div>
                <h1 class="font-heading text-2xl md:text-4xl font-extrabold text-white leading-tight"></h1>
                
                <div class="w-full bg-white/5 rounded-2xl border border-white/10 p-2 overflow-hidden shadow-inner">
                    <img src="{{ asset('img/MATAMUDA3.jpg') }}" alt="Detail Workshop" class="w-full h-64 md:h-96 object-cover rounded-xl" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=1200&q=80';">
                </div>

                <div class="text-emerald-50 text-sm md:text-base leading-relaxed space-y-4 font-medium">
                    <p>.</p>
                </div>
                {{-- Berita 2.4 --}}
                <div class="flex items-center gap-3 text-xs">
                    <span class="px-2.5 py-1 font-bold bg-blue-400 text-zinc-950 rounded-lg uppercase">Kegiatan</span>
                    <span class="text-emerald-100/70">13 Juli 2026</span>
                </div>
                <h1 class="font-heading text-2xl md:text-4xl font-extrabold text-white leading-tight"></h1>
                
                <div class="w-full bg-white/5 rounded-2xl border border-white/10 p-2 overflow-hidden shadow-inner">
                    <img src="{{ asset('img/MATAMUDA4.jpg') }}" alt="Detail Workshop" class="w-full h-64 md:h-96 object-cover rounded-xl" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=1200&q=80';">
                </div>

                <div class="text-emerald-50 text-sm md:text-base leading-relaxed space-y-4 font-medium">
                    <p>.</p>
                </div>
            @endif

            @if($id == 3)
                <div class="flex items-center gap-3 text-xs">
                    <span class="px-2.5 py-1 font-bold bg-rose-400 text-zinc-950 rounded-lg uppercase">Prestasi</span>
                    <span class="text-emerald-100/70">28 Juni 2026</span>
                </div>
                <h1 class="font-heading text-2xl md:text-4xl font-extrabold text-white leading-tight">Santri MTs. NW Karang Juli Juara 2 Tingkat Kecamatan</h1>
                
                {{-- SLOT FOTO BERITA 3 --}}
                <div class="w-full bg-white/5 rounded-2xl border border-white/10 p-2 overflow-hidden shadow-inner">
                    <img src="{{ asset('img/JUARA2_1.jpg') }}" alt="Detail Prestasi" class="w-full h-64 md:h-96 object-cover rounded-xl" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?auto=format&fit=crop&w=1200&q=80';">
                </div>

                <div class="text-emerald-50 text-sm md:text-base leading-relaxed space-y-4 font-medium">
                    <p>Kabar membanggakan datang dari santri berprestasi kita yang sukses merebut gelar juara dua perlombaan tari nasional. Semoga pencapaian ini memicu semangat juang bagi seluruh santri lainnya.</p>
                </div>
                {{-- Berita 3.1 --}}
                <div class="flex items-center gap-3 text-xs">
                    <span class="px-2.5 py-1 font-bold bg-rose-400 text-zinc-950 rounded-lg uppercase">Prestasi</span>
                    <span class="text-emerald-100/70">28 Juni 2026</span>
                </div>
                <h1 class="font-heading text-2xl md:text-4xl font-extrabold text-white leading-tight"></h1>
                
                <div class="w-full bg-white/5 rounded-2xl border border-white/10 p-2 overflow-hidden shadow-inner">
                    <img src="{{ asset('img/JUARA2_2.jpg') }}" alt="Detail Prestasi" class="w-full h-64 md:h-96 object-cover rounded-xl" onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?auto=format&fit=crop&w=1200&q=80';">
                </div>

                <div class="text-emerald-50 text-sm md:text-base leading-relaxed space-y-4 font-medium">
                    <p>.</p>
                </div>
            @endif

        </article>
    </main>

    <footer class="w-full px-4 py-4 relative z-10">
        <div class="mx-auto max-w-7xl bg-black/10 backdrop-blur-md border border-white/10 rounded-xl py-3 text-center text-xs text-emerald-100/70">
            &copy; 2026 MTs. NW Karang Juli.
        </div>
    </footer>
</body>
</html>