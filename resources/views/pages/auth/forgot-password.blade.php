<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi - MTs. NW Karang Juli</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Plus+Jakarta+Sans:wght=700;800&display=swap" rel="stylesheet">
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
<body class="liquid-bg text-zinc-100 antialiased min-h-screen flex flex-col justify-between relative overflow-x-hidden">

    <div class="absolute top-[-20%] left-[-20%] w-[60vw] h-[60vw] bg-emerald-400/20 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute bottom-[-20%] right-[-20%] w-[50vw] h-[50vw] bg-amber-400/10 rounded-full blur-[120px] pointer-events-none"></div>

    {{-- Header Mini / Tombol Kembali --}}
    <header class="w-full p-4 md:p-6 z-10">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="flex items-center gap-3">
                <div class="p-1.5 bg-white/30 backdrop-blur-md border border-white/30 rounded-xl shadow-sm">
                    <img src="{{ asset('img/logo0.png') }}" alt="Logo MTs. NW" class="w-8 h-8 object-contain">
                </div>
                <span class="font-heading font-extrabold text-sm text-white hidden sm:block tracking-tight">MTs. NW Karang Juli</span>
            </a>
            <a href="{{ route('login') }}" class="text-xs font-bold text-amber-200 bg-white/10 border border-white/20 hover:bg-white/20 px-4 py-2 rounded-xl transition duration-300 backdrop-blur-md">
                ← Kembali ke Login
            </a>
        </div>
    </header>

    {{-- KOTAK UTAMA (Liquid Glass Card) --}}
    <main class="w-full flex-1 flex items-center justify-center p-4 z-10">
        <div class="w-full max-w-md bg-white/10 backdrop-blur-2xl border border-white/25 rounded-3xl p-8 shadow-2xl space-y-6 relative overflow-hidden">
            
            {{-- Header Kotak + Logo Sekolah --}}
            <div class="text-center space-y-2">
                <div class="w-20 h-20 bg-white/30 backdrop-blur-md border border-white/40 rounded-2xl flex items-center justify-center mx-auto shadow-lg p-2.5 group">
                    <img src="{{ asset('img/logo0.png') }}" 
                         alt="Logo MTs. NW Karang Juli" 
                         class="w-full h-full object-contain transition duration-500 group-hover:rotate-6">
                </div>
                <h2 class="font-heading text-2xl font-black text-white tracking-tight drop-shadow-sm">Lupa Kata Sandi?</h2>
                <p class="text-emerald-100/70 text-xs font-medium px-4">Masukkan email Anda untuk menerima tautan pemulihan kata sandi</p>
            </div>

            @if (session('status'))
                <div class="p-3 bg-emerald-500/20 border border-emerald-500/30 rounded-xl text-center text-xs font-semibold text-emerald-200 backdrop-blur-md">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Form Input Lupa Sandi --}}
            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf
                
                {{-- Input Email --}}
                <div class="space-y-1.5">
                    <label for="email" class="text-xs font-bold text-white tracking-wide uppercase opacity-90">Alamat Email</label>
                    <div class="relative">
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full bg-white/5 border border-white/20 focus:border-white/50 rounded-xl py-2.5 px-4 text-sm text-white placeholder-emerald-200/40 focus:outline-none focus:ring-2 focus:ring-white/10 transition font-medium"
                            placeholder="nama@madrasah.com">
                    </div>
                    @if($errors->has('email'))
                        <span class="text-xs text-amber-300 font-semibold block mt-1">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                {{-- Tombol Kirim Link Proses --}}
                <button type="submit" 
                    class="w-full mt-2 bg-gradient-to-r from-amber-400 to-yellow-400 hover:from-amber-300 hover:to-yellow-300 text-emerald-950 font-bold py-3 rounded-xl transition-all duration-300 shadow-lg shadow-amber-950/20 text-sm tracking-wide active:scale-[0.98]">
                    Kirim Tautan Pemulihan →
                </button>
            </form>

            {{-- Footer Kotak --}}
            <div class="text-center pt-2 border-t border-white/10 text-xs font-medium text-emerald-100/60">
                Butuh bantuan akses akun? <a href="#" class="text-amber-300 font-bold hover:underline">Hubungi Operator</a>
            </div>

        </div>
    </main>

    {{-- Footer Bawah Halaman --}}
    <footer class="w-full px-4 py-4 z-10">
        <div class="mx-auto max-w-7xl bg-black/10 backdrop-blur-md border border-white/10 rounded-xl py-3 text-center text-xs font-medium text-emerald-100/50">
            &copy; 2026 MTs. NW Karang Juli. Portal Akademik Resmi.
        </div>
    </footer>

</body>
</html>