<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - MTs. NW Karang Juli</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .font-heading { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Custom Background Animasi Cairan (Liquid Mesh) yang sama dengan Beranda */
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

    {{-- 2. Konten Utama Profil (Gaya Liquid Glass) --}}
    <main class="mx-auto max-w-5xl px-4 md:px-6 py-12 w-full flex-1 space-y-12 relative z-10">
        
        {{-- Judul Halaman --}}
        <div class="text-center space-y-3">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-[11px] font-bold bg-white/10 text-white border border-white/20 backdrop-blur-md">
                Madrasah Profile
            </span>
            <h1 class="font-heading text-3xl md:text-5xl font-black text-white tracking-tight drop-shadow-md">Profil Madrasah</h1>
            <p class="text-emerald-100/80 text-xs md:text-sm max-w-md mx-auto">Mengenal lebih dekat sejarah, identitas resmi, dan visi kepengurusan MTs. NW Karang Juli.</p>
            <div class="h-1 w-16 bg-gradient-to-r from-amber-400 to-yellow-300 mx-auto rounded-full shadow-sm"></div>
        </div>

        {{-- Sekilas Sejarah (Glass Card Grid) --}}
        <section class="grid md:grid-cols-2 gap-8 items-center bg-white/10 backdrop-blur-2xl p-6 md:p-8 rounded-3xl border border-white/20 shadow-2xl shadow-emerald-950/20">
            <div class="space-y-4">
                <span class="text-xs font-bold text-amber-300 tracking-wider uppercase drop-shadow-sm">Sejarah Singkat</span>
                <h2 class="font-heading text-2xl font-bold text-white leading-tight drop-shadow-sm">Membangun Akhlak & Prestasi Sejak Dini</h2>
                <p class="text-sm text-emerald-50/90 leading-relaxed font-medium">
                    MTs. NW Karang Juli didirikan di bawah naungan Yayasan Pondok Pesantren Nahdlatul Wathan (YPP NW) Kadindi. Madrasah ini lahir dari dedikasi mendalam untuk menyediakan pendidikan umum yang terintegrasi erat dengan nilai-nilai luhur kepesantrenan dan agama Islam.
                </p>
                <p class="text-sm text-emerald-50/90 leading-relaxed font-medium">
                    Seiring berjalannya waktu, madrasah kami terus beradaptasi dengan era digital, menghadirkan fasilitas modern namun tetap menjaga khittah perjuangan Aswaja dan kebangsaan demi mencetak santri yang berdaya saing global.
                </p>
            </div>
            
            <!-- Box Gambar / Lambang Samping Seni Kaca -->
            <div class="bg-gradient-to-tr from-white/10 to-white/5 backdrop-blur-md h-64 md:h-80 rounded-2xl flex flex-col items-center justify-center p-6 text-center border border-white/20 shadow-inner relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-emerald-950/20"></div>
                <img src="{{ asset('img/logo0.png') }}" alt="Logo" class="w-24 h-24 object-contain opacity-90 mb-4 transform transition duration-700 group-hover:scale-110">
                <p class="font-heading font-bold text-white tracking-wide">YPP NW KADINDI</p>
                <p class="text-[11px] text-emerald-200 mt-1 italic">"Iman, Ilmu, dan Amal Sholeh"</p>
            </div>
        </section>

        {{-- Tabel Identitas Sekolah (Glass Table) --}}
        <section class="space-y-4">
            <h3 class="font-heading text-lg font-bold text-white flex items-center gap-2 drop-shadow-sm">
                Informasi Identitas Resmi
            </h3>
            <div class="bg-white/10 backdrop-blur-2xl rounded-3xl border border-white/20 shadow-2xl shadow-emerald-950/20 overflow-hidden">
                <table class="w-full text-left border-collapse text-sm text-emerald-50">
                    <tbody>
                        <tr class="border-b border-white/10 bg-white/5"><td class="p-4 font-semibold w-1/3 text-white drop-shadow-sm">Nama Madrasah</td><td class="p-4 font-medium">MTs. NW Karang Juli</td></tr>
                        <tr class="border-b border-white/10"><td class="p-4 font-semibold text-white drop-shadow-sm">NPSN / NSM</td><td class="p-4 font-medium">12345678 / 1212520...</td></tr>
                        <tr class="border-b border-white/10 bg-white/5"><td class="p-4 font-semibold text-white drop-shadow-sm">Status Akreditasi</td><td class="p-4"><span class="px-2.5 py-0.5 bg-amber-400 text-emerald-950 text-xs font-bold rounded-full shadow-sm">Terakreditasi A</span></td></tr>
                        <tr class="border-b border-white/10"><td class="p-4 font-semibold text-white drop-shadow-sm">Alamat Lengkap</td><td class="p-4 font-medium">Jl. Raya Kadindi, No. 12, Karang Juli</td></tr>
                        <tr class="border-b border-white/10 bg-white/5"><td class="p-4 font-semibold text-white drop-shadow-sm">Naungan Yayasan</td><td class="p-4 font-medium">YPP NW KADINDI</td></tr>
                        <tr><td class="p-4 font-semibold text-white drop-shadow-sm">Kepala Madrasah</td><td class="p-4 font-medium">Nama Kepala Sekolah, S.Pd.I</td></tr>
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Sambutan Kepala Sekolah (Floating Glass Card Berfoto) --}}
        <section class="bg-white/15 backdrop-blur-2xl border border-white/25 p-6 md:p-8 rounded-3xl flex flex-col md:flex-row gap-6 items-center shadow-2xl relative overflow-hidden">
            
            {{-- SLOT FOTO KEPALA SEKOLAH --}}
            {{-- Simpan foto Bapak Kepala Sekolah di folder public/img/kepsek.jpg --}}
            <div class="w-24 h-24 md:w-28 md:h-28 rounded-full bg-white/10 border-2 border-white/40 shadow-xl overflow-hidden flex-shrink-0 relative group">
                <img src="{{ asset('img/kepsek.jpg') }}" 
                    alt="Foto Kepala MTs. NW Karang Juli" 
                    class="w-full h-full object-cover object-top transition duration-500 group-hover:scale-110"
                    onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=256&q=80';">
                {{-- Efek Kilauan Kaca di Atas Foto --}}
                <div class="absolute inset-0 bg-gradient-to-tr from-white/0 via-white/10 to-white/20 pointer-events-none"></div>
            </div>
            
            {{-- Teks Sambutan --}}
            <div class="space-y-2 text-center md:text-left flex-1">
                <h4 class="font-heading font-bold text-white text-lg drop-shadow-sm flex items-center justify-center md:justify-start gap-2">
                    <span></span> Sambutan Kepala Madrasah
                </h4>
                <p class="text-emerald-50 text-sm md:text-base leading-relaxed italic font-medium opacity-90">
                    "Selamat datang di platform informasi akademik digital kami. Melalui sistem terintegrasi ini, kami berkomitmen mewujudkan transparansi, kemudahan akses belajar bagi santri, serta sinergi yang kokoh antara asatidz/guru dengan para orang tua wali murid."
                </p>
                <div class="pt-1">
                    <p class="text-xs md:text-sm font-bold text-amber-300 tracking-wide uppercase">- Nama Kepala Sekolah, S.Pd.I</p>
                    <p class="text-[10px] text-emerald-200/70 font-semibold uppercase tracking-wider">Kepala MTs. NW Karang Juli</p>
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