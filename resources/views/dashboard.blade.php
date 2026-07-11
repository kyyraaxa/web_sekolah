<?php
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Payment;
use App\Models\Announcement;
use App\Models\Schedule; 
use App\Models\Assignment; 

$user = auth()->user();
$userRole = strtolower($user->role);

$totalStudents = 0;
$totalTeachers = 0;
$totalRevenue = 0;
$recentAnnouncements = collect();

// 1. Sinkronisasi Data Admin
if ($userRole === 'admin') {
    $totalStudents       = \App\Models\Student::count();
    $totalTeachers       = \App\Models\Teacher::count();
    $totalRevenue        = \App\Models\Payment::where('status', 'Paid')->sum('amount');
    $recentAnnouncements = \App\Models\Announcement::latest()->take(4)->get();
}

$teacherSchedules = [];
$pendingCorrectionsCount = 0; 

// 2. Sinkronisasi Data Guru (Jadwal Mengajar & Pengumuman Khusus Guru)
if ($userRole === 'teacher' || $userRole === 'guru') {
    // Ambil Jadwal Mengajar Hari Ini berdasarkan nama Guru
    $teacherSchedules = Schedule::where('teacher_name', $user->name)
                                ->where('day', now()->translatedFormat('l')) 
                                ->orderBy('start_time')
                                ->get();
                                
    // Ambil Pengumuman yang targetnya khusus untuk Guru/Teacher atau Semua (Public)
    $recentAnnouncements = Announcement::whereIn(DB::raw('LOWER(target)'), ['Teachers', 'All'])
                                        ->latest()
                                        ->take(4)
                                        ->get();

    try { $pendingCorrectionsCount = Assignment::count(); } catch (\Exception $e) { $pendingCorrectionsCount = 3; }
}

$studentSchedules = [];
$upcomingAssignments = [];

// 3. Sinkronisasi Data Siswa (Jadwal Sekolah & Pengumuman Khusus Siswa)
if ($userRole === 'student' || $userRole === 'siswa') {
    $studentSchedules = Schedule::where('day', now()->translatedFormat('l'))
                                ->orderBy('start_time')
                                ->get();
                                
    // Ambil Pengumuman yang targetnya khusus untuk Siswa/Student atau Semua (Public)
    $recentAnnouncements = Announcement::whereIn(DB::raw('LOWER(target)'), ['Students', 'All'])
                                        ->latest()
                                        ->take(4)
                                        ->get();

    try { $upcomingAssignments = Assignment::orderBy('due_date', 'asc')->take(4)->get(); } catch (\Exception $e) {
        $upcomingAssignments = [
            (object)['title' => 'Tugas Mandiri Semester Ganjil', 'subject' => 'Umum', 'due_date' => now()->addDays(2)],
            (object)['title' => 'Tugas Resume Materi Sekolah', 'subject' => 'Umum', 'due_date' => now()->addDays(5)]
        ];
    }
}
?>

<x-layouts::app :title="__('Dashboard Utama')">
    {{-- Google Font Link --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    {{-- CSS Master: Efek Kaca Transparan Tipis Sesuai Gambar & Animasi Hover Melayang --}}
    <style>
        .liquid-bg-wrapper {
            background: linear-gradient(135deg, #4ade80 0%, #2ea771 40%, #85b853 100%) !important;
            padding: 1.5rem;
            border-radius: 1.5rem;
            font-family: 'Inter', sans-serif;
            color: #ffffff !important;
        }

        .dark .liquid-bg-wrapper {
            background: linear-gradient(135deg, #166534 0%, #064e3b 50%, #3f6212 100%) !important;
        }

        .glass-panel-match {
            background: rgba(255, 255, 255, 0.15) !important;
            backdrop-filter: blur(16px) saturate(120%) !important;
            -webkit-backdrop-filter: blur(16px) saturate(120%) !important;
            border: 1px solid rgba(255, 255, 255, 0.25) !important;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.04) !important;
            color: #ffffff !important;
        }

        /* Item/Baris Tabel dengan Efek Hover Melayang & Bersinar Penuh */
        .glass-item-match {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            color: #ffffff !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            cursor: pointer;
            text-decoration: none !important;
        }
        
        .glass-item-match:hover {
            background: rgba(255, 255, 255, 0.22) !important;
            border-color: rgba(255, 255, 255, 0.45) !important;
            transform: translateY(-3px) scale(1.002);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .text-soft-white {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        .pulse-active-badge {
            background: rgba(245, 158, 11, 0.25) !important;
            border: 1px solid rgba(251, 191, 36, 0.5) !important;
            color: #fbbf24 !important;
            text-shadow: 0 0 8px rgba(245, 158, 11, 0.5);
            box-shadow: 0 0 12px rgba(245, 158, 11, 0.2);
        }
    </style>

    <div class="liquid-bg-wrapper flex h-full w-full flex-1 flex-col gap-6 antialiased">
        
        {{-- ========================================================================== --}}
        {{-- 1. PANEL CONTROL ADMIN                                                     --}}
        {{-- ========================================================================== --}}
        @if($userRole === 'admin')
            <div class="glass-panel-match flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-6 rounded-2xl">
                <div>
                    <h2 class="text-2xl font-black tracking-tight text-white" style="font-family: 'Plus Jakarta Sans', sans-serif;">Panel Kontrol Admin</h2>
                    <p class="text-sm mt-1 text-soft-white">Selamat datang kembali, {{ $user->name }}. Berikut adalah perkembangan operasional hari ini.</p>
                </div>
                <div class="pulse-active-badge flex items-center gap-2 text-xs font-extrabold px-3 py-1.5 rounded-xl w-fit animate-pulse">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-400 relative flex">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                    </span>
                    Sistem Aktif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="glass-panel-match flex items-center justify-between p-5 rounded-2xl transition-all duration-300 hover:translate-y-[-4px] hover:bg-white/20">
                    <div class="space-y-1">
                        <span class="text-xs font-bold text-soft-white uppercase tracking-wider block">Total Siswa/i</span>
                        <h3 class="text-3xl font-black text-white tracking-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ number_format($totalStudents) }}</h3>
                    </div>
                    <div class="p-3 bg-white/10 text-white rounded-xl border border-white/20">
                        <flux:icon name="users" variant="outline" class="w-6 h-6" />
                    </div>
                </div>

                <div class="glass-panel-match flex items-center justify-between p-5 rounded-2xl transition-all duration-300 hover:translate-y-[-4px] hover:bg-white/20">
                    <div class="space-y-1">
                        <span class="text-xs font-bold text-soft-white uppercase tracking-wider block">Guru & Staf</span>
                        <h3 class="text-3xl font-black text-white tracking-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ number_format($totalTeachers) }}</h3>
                    </div>
                    <div class="p-3 bg-white/10 text-white rounded-xl border border-white/20">
                        <flux:icon name="academic-cap" variant="outline" class="w-6 h-6" />
                    </div>
                </div>

                <div class="glass-panel-match flex items-center justify-between p-5 rounded-2xl transition-all duration-300 hover:translate-y-[-4px] hover:bg-white/20">
                    <div class="space-y-1">
                        <span class="text-xs font-bold text-soft-white uppercase tracking-wider block">Keuangan Terbayar</span>
                        <h3 class="text-2xl font-black text-white tracking-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    </div>
                    <div class="p-3 bg-white/10 text-white rounded-xl border border-white/20">
                        <flux:icon name="banknotes" variant="outline" class="w-6 h-6" />
                    </div>
                </div>
            </div>

            {{-- Akses Cepat Beranimasi Tabel Melayang Penuh --}}
            <div class="glass-panel-match p-6 rounded-2xl space-y-4">
                <h3 class="font-bold text-base text-white" style="font-family: 'Plus Jakarta Sans', sans-serif;">Manajemen Akses Cepat</h3>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <a href="{{ route('student.index') }}" class="glass-item-match p-3 rounded-xl flex items-center justify-between shadow-sm group active:scale-95">
                        <div class="flex items-center gap-2 text-sm font-semibold text-white">
                            <flux:icon name="users" variant="outline" class="w-4 h-4 text-white opacity-80" />
                            <span>Kelola Siswa</span>
                        </div>
                        <flux:icon name="chevron-right" class="w-3.5 h-3.5 text-white/55 group-hover:text-white transition-colors" />
                    </a>
                    <a href="{{ route('teacher.index') }}" class="glass-item-match p-3 rounded-xl flex items-center justify-between shadow-sm group active:scale-95">
                        <div class="flex items-center gap-2 text-sm font-semibold text-white">
                            <flux:icon name="academic-cap" variant="outline" class="w-4 h-4 text-white opacity-80" />
                            <span>Kelola Guru</span>
                        </div>
                        <flux:icon name="chevron-right" class="w-3.5 h-3.5 text-white/55 group-hover:text-white transition-colors" />
                    </a>
                    <a href="{{ route('schedule.index') }}" class="glass-item-match p-3 rounded-xl flex items-center justify-between shadow-sm group active:scale-95">
                        <div class="flex items-center gap-2 text-sm font-semibold text-white">
                            <flux:icon name="calendar" variant="outline" class="w-4 h-4 text-white opacity-80" />
                            <span>Atur Jadwal</span>
                        </div>
                        <flux:icon name="chevron-right" class="w-3.5 h-3.5 text-white/55 group-hover:text-white transition-colors" />
                    </a>
                    <a href="{{ route('announcement.index') }}" class="glass-item-match p-3 rounded-xl flex items-center justify-between shadow-sm group active:scale-95">
                        <div class="flex items-center gap-2 text-sm font-semibold text-white">
                            <flux:icon name="megaphone" variant="outline" class="w-4 h-4 text-white opacity-80" />
                            <span>Buat Pengumuman</span>
                        </div>
                        <flux:icon name="chevron-right" class="w-3.5 h-3.5 text-white/55 group-hover:text-white transition-colors" />
                    </a>
                </div>
            </div>
        @endif

        {{-- ========================================================================== --}}
        {{-- 2. PANEL WORKSPACE GURU                                                    --}}
        {{-- ========================================================================== --}}
        @if($userRole === 'teacher' || $userRole === 'guru')
            <div class="glass-panel-match flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-6 rounded-2xl">
                <div>
                    <h2 class="text-2xl font-black tracking-tight text-white" style="font-family: 'Plus Jakarta Sans', sans-serif;">Ruang Kerja Guru</h2>
                    <p class="text-sm mt-1 text-soft-white">Halo Guru {{ $user->name }}, berikut adalah agenda mengajar Anda hari ini.</p>
                </div>
                <div class="pulse-active-badge flex items-center gap-2 text-xs font-extrabold px-3 py-1.5 rounded-xl w-fit animate-pulse">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-400 relative flex">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                    </span>
                    Sistem Aktif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Jadwal Mengajar Hari Ini --}}
                <div class="glass-panel-match lg:col-span-2 p-6 rounded-2xl space-y-4">
                    <h3 class="font-bold text-base text-white" style="font-family: 'Plus Jakarta Sans', sans-serif;">Jadwal Mengajar Hari Ini ({{ now()->translatedFormat('l') }})</h3>
                    <flux:separator variant="subtle" class="opacity-20" />
                    <div class="space-y-3">
                        @forelse($teacherSchedules as $schedule)
                            <div class="glass-item-match flex items-center justify-between p-4 rounded-xl">
                                <div class="flex items-center gap-4">
                                    <div class="px-2.5 py-1.5 font-mono text-xs font-bold rounded-xl bg-white/15 border border-white/25">
                                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-white" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $schedule->subject }}</h4>
                                        <p class="text-xs text-soft-white mt-0.5">Ruangan: <span class="font-bold text-white">{{ $schedule->classroom }}</span></p>
                                    </div>
                                </div>
                                <span class="text-xs font-bold px-2.5 py-1 rounded-lg bg-white/20 border border-white/20">Aktif</span>
                            </div>
                        @empty
                            <div class="text-center py-8 text-soft-white/70 text-xs italic">Tidak ada jadwal mengajar terdaftar atas nama Anda hari ini.</div>
                        @endforelse
                    </div>
                </div>

                {{-- Total Tugas Aktif Guru dengan Tombol Beranimasi --}}
                <div class="glass-panel-match p-6 rounded-2xl space-y-4 flex flex-col justify-between transition-all duration-300 hover:bg-white/20">
                    <div class="space-y-4">
                        <h3 class="font-bold text-base text-white" style="font-family: 'Plus Jakarta Sans', sans-serif;">Total Tugas Aktif</h3>
                        <flux:separator variant="subtle" class="opacity-20" />
                        <div class="p-4 bg-white/10 border border-white/20 rounded-xl flex items-center gap-4">
                            <div class="p-3 bg-white text-emerald-900 rounded-xl shadow-md">
                                <flux:icon name="document-check" class="w-6 h-6" />
                            </div>
                            <div>
                                <h3 class="text-3xl font-black text-white tracking-tight" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $pendingCorrectionsCount }}</h3>
                                <p class="text-xs text-soft-white">Total tugas diterbitkan</p>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('assignment.index') }}" class="glass-item-match w-full flex justify-center items-center gap-2 font-black text-xs py-3 rounded-xl shadow-md group active:scale-95">
                        <span>Lihat Menu Tugas</span>
                        <flux:icon name="chevron-right" class="w-3.5 h-3.5 text-white/70 group-hover:text-white group-hover:translate-x-0.5 transition-all duration-200" />
                    </a>
                </div>
            </div>
        @endif

        {{-- ========================================================================== --}}
        {{-- 3. PANEL RUANG BELAJAR SISWA                                               --}}
        {{-- ========================================================================== --}}
        @if($userRole === 'student' || $userRole === 'siswa')
            <div class="glass-panel-match flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-6 rounded-2xl">
                <div>
                    <h2 class="text-2xl font-black tracking-tight text-white" style="font-family: 'Plus Jakarta Sans', sans-serif;">Ruang Belajar Siswa</h2>
                    <p class="text-sm mt-1 text-soft-white">Selamat datang {{ $user->name }}, pantau agenda belajar sekolahmu hari ini.</p>
                </div>
                <div class="pulse-active-badge flex items-center gap-2 text-xs font-extrabold px-3 py-1.5 rounded-xl w-fit animate-pulse">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-400 relative flex">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                    </span>
                    Sistem Aktif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Jadwal Sekolah Siswa --}}
                <div class="glass-panel-match p-6 rounded-2xl space-y-4">
                    <div>
                        <h3 class="font-bold text-base text-white" style="font-family: 'Plus Jakarta Sans', sans-serif;">Jadwal Sekolah Hari Ini</h3>
                        <p class="text-xs text-soft-white">Agenda pelajaran terdaftar ({{ now()->translatedFormat('l') }})</p>
                    </div>
                    <flux:separator variant="subtle" class="opacity-20" />
                    <div class="space-y-3">
                        @forelse($studentSchedules as $schedule)
                            <div class="glass-item-match flex items-center gap-3 p-3 rounded-xl">
                                <div class="text-[11px] font-mono font-bold p-2 rounded-lg bg-white/15 border border-white/20">
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-xs font-bold text-white truncate" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $schedule->subject }}</h4>
                                    <p class="text-[11px] text-soft-white truncate mt-0.5">Guru: {{ $schedule->teacher_name }} | Ruang: <span class="text-white font-bold">{{ $schedule->classroom }}</span></p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-soft-white/70 text-xs italic">Hari ini tidak ada kegiatan belajar terdaftar.</div>
                        @endforelse
                    </div>
                </div>

                {{-- Daftar Penugasan Siswa Berlink Aktif --}}
                <div class="glass-panel-match lg:col-span-2 p-6 rounded-2xl space-y-4">
                    <div>
                        <h3 class="font-bold text-base text-white" style="font-family: 'Plus Jakarta Sans', sans-serif;">Daftar Penugasan</h3>
                        <p class="text-xs text-soft-white">Daftar seluruh tugas yang diterbitkan sekolah</p>
                    </div>
                    <flux:separator variant="subtle" class="opacity-20" />
                    <div class="space-y-1">
                        @forelse($upcomingAssignments as $assignment)
                            <a href="{{ route('assignment.index') }}" class="glass-item-match p-3.5 rounded-xl flex justify-between items-center gap-4 mb-2 last:mb-0 block group active:scale-[0.99]">
                                <div>
                                    <span class="font-bold text-white text-sm block group-hover:text-yellow-200" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $assignment->title }}</span>
                                    <span class="text-xs text-soft-white mt-0.5 block">Kategori: {{ $assignment->subject ?? 'Umum' }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] font-bold px-2.5 py-1 rounded-xl block shadow-sm bg-white/20 border border-white/25">
                                        Batas Waktu: {{ \Carbon\Carbon::parse($assignment->due_date)->diffForHumans() }}
                                    </span>
                                </div>
                            </a>
                        @empty
                            <div class="text-center py-8 text-soft-white/70 text-xs italic">Belum ada tugas yang diunggah.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif

        {{-- ========================================================================== --}}
        {{-- 4. PAPAN PENGUMUMAN (Tersinkronisasi Target Sesuai Role)                    --}}
        {{-- ========================================================================== --}}
        <div class="glass-panel-match p-6 rounded-2xl space-y-4">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-base text-white" style="font-family: 'Plus Jakarta Sans', sans-serif;">Papan Pengumuman</h3>
                    <p class="text-sm text-soft-white">Informasi resmi seputar aktivitas akademik terbaru</p>
                </div>
                {{-- Tombol Lihat Semua Bergaya Mini-Card Kristal Melayang --}}
                <a href="{{ route('announcement.index') }}" wire:navigate class="glass-item-match flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-bold text-white shadow-sm group">
                    <span>Lihat Semua</span>
                    <flux:icon name="chevron-right" class="w-3.5 h-3.5 text-white/70 group-hover:text-white group-hover:translate-x-0.5 transition-all duration-200" />
                </a>
            </div>

            <flux:separator variant="subtle" class="opacity-20" />

            <div class="space-y-2">
                @forelse($recentAnnouncements as $announcement)
                    <div class="glass-item-match p-4 rounded-xl flex justify-between items-start gap-4">
                        <div class="space-y-1.5">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-bold text-white text-sm leading-none" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ $announcement->title }}</span>
                                <span class="font-extrabold px-2 py-0.5 rounded-lg text-[9px] uppercase tracking-wider border border-white/30 bg-white/15 text-white">
                                    Target: {{ $announcement->target }}
                                </span>
                            </div>
                            <p class="text-xs text-soft-white line-clamp-2 max-w-4xl leading-relaxed">
                                {{ $announcement->content }}
                            </p>
                        </div>
                        <span class="text-[11px] whitespace-nowrap font-semibold px-2 py-1 rounded-lg bg-white/10 border border-white/10">
                            {{ $announcement->created_at->diffForHumans() }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-8 text-soft-white/70 italic text-sm flex flex-col items-center justify-center gap-2">
                        <flux:icon name="megaphone" class="w-7 h-7 text-white/40" />
                        Belum ada pengumuman resmi terbaru saat ini.
                    </div>
                @endif
            </div>
        </div>

    </div>
</x-layouts::app>