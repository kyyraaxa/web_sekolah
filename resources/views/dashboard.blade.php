<?php
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Payment;
use App\Models\Announcement;
use App\Models\Schedule; 
use App\Models\Assignment; 

$user = auth()->user();
$userRole = strtolower($user->role); 

// --- DATA UNTUK ADMIN ---
$totalStudents       = Student::count();
$totalTeachers       = Teacher::count();
$totalRevenue        = Payment::where('status', 'Paid')->sum('amount');
$recentAnnouncements = Announcement::latest()->take(4)->get();

// --- DATA UNTUK GURU ---
$teacherSchedules = [];
$pendingCorrectionsCount = 0; 

if ($userRole === 'teacher' || $userRole === 'guru') {
    // Mengambil jadwal hari ini berdasarkan NAMA GURU yang sedang login
    $teacherSchedules = Schedule::where('teacher_name', $user->name)
                                ->where('day', now()->translatedFormat('l')) 
                                ->orderBy('start_time')
                                ->get();
                                
    // Mengambil jumlah tugas (fallback angka jika tabel belum ada)
    try {
        $pendingCorrectionsCount = Assignment::count();
    } catch (\Exception $e) {
        $pendingCorrectionsCount = 3; 
    }
}

// --- DATA UNTUK SISWA ---
$studentSchedules = [];
$upcomingAssignments = [];

if ($userRole === 'student' || $userRole === 'siswa') {
    // Karena tidak ada kelas, siswa melihat SEMUA jadwal yang aktif hari ini
    $studentSchedules = Schedule::where('day', now()->translatedFormat('l'))
                                ->orderBy('start_time')
                                ->get();

    // Mengambil semua tugas sekolah yang ada
    try {
        $upcomingAssignments = Assignment::orderBy('due_date', 'asc')->take(4)->get();
    } catch (\Exception $e) {
        $upcomingAssignments = [
            (object)['title' => 'Tugas Mandiri Semester Ganjil', 'subject' => 'Umum', 'due_date' => now()->addDays(2)],
            (object)['title' => 'Tugas Resume Materi Kuliah/Sekolah', 'subject' => 'Umum', 'due_date' => now()->addDays(5)]
        ];
    }
}
?>

<x-layouts::app :title="__('Dashboard Utama')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        
        {{-- ========================================================================== --}}
        {{-- 1. TAMPILAN KHUSUS ADMIN                                                   --}}
        {{-- ========================================================================== --}}
        @if($userRole === 'admin')
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white dark:bg-zinc-900 p-6 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm">
                <div>
                    <flux:heading size="xl" class="text-zinc-900 dark:text-white font-black">Panel Kontrol Admin</flux:heading>
                    <flux:subheading size="sm" class="text-zinc-500 dark:text-zinc-400 mt-1">Selamat datang kembali, {{ $user->name }}. Berikut adalah perkembangan operasional hari ini.</flux:subheading>
                </div>
                <div class="flex items-center gap-2 text-xs font-semibold bg-blue-500/10 text-blue-600 dark:text-blue-400 px-3 py-1.5 rounded-lg w-fit">
                    <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                    Sistem Aktif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex items-center justify-between p-5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm">
                    <div class="space-y-1">
                        <span class="text-xs font-medium text-zinc-400 block">Total Students</span>
                        <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ number_format($totalStudents) }}</h3>
                    </div>
                    <div class="p-3 bg-blue-500/10 text-blue-500 rounded-xl">
                        <flux:icon name="users" variant="outline" class="w-6 h-6" />
                    </div>
                </div>

                <div class="flex items-center justify-between p-5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm">
                    <div class="space-y-1">
                        <span class="text-xs font-medium text-zinc-400 block">Guru & Staf</span>
                        <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">{{ number_format($totalTeachers) }}</h3>
                    </div>
                    <div class="p-3 bg-purple-500/10 text-purple-500 rounded-xl">
                        <flux:icon name="academic-cap" variant="outline" class="w-6 h-6" />
                    </div>
                </div>

                <div class="flex items-center justify-between p-5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm">
                    <div class="space-y-1">
                        <span class="text-xs font-medium text-zinc-400 block">Keuangan Terbayar</span>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    </div>
                    <div class="p-3 bg-emerald-500/10 text-emerald-500 rounded-xl">
                        <flux:icon name="banknotes" variant="outline" class="w-6 h-6" />
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm space-y-4">
                <flux:heading size="lg" class="font-bold">Manajemen Data</flux:heading>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <flux:button href="{{ route('student.index') }}" variant="subtle" class="justify-start" icon="users">Kelola Siswa</flux:button>
                    <flux:button href="{{ route('teacher.index') }}" variant="subtle" class="justify-start" icon="academic-cap">Kelola Guru</flux:button>
                    <flux:button href="{{ route('schedule.index') }}" variant="subtle" class="justify-start" icon="calendar">Atur Jadwal</flux:button>
                    <flux:button href="{{ route('announcement.index') }}" variant="subtle" class="justify-start" icon="megaphone">Buat Pengumuman</flux:button>
                </div>
            </div>
        @endif


        {{-- ========================================================================== --}}
        {{-- 2. TAMPILAN KHUSUS GURU                                                    --}}
        {{-- ========================================================================== --}}
        @if($userRole === 'teacher' || $userRole === 'guru')
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white dark:bg-zinc-900 p-6 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm">
                <div>
                    <flux:heading size="xl" class="text-zinc-900 dark:text-white font-black">Ruang Kerja Guru</flux:heading>
                    <flux:subheading size="sm" class="text-zinc-500 dark:text-zinc-400 mt-1">Halo Guru {{ $user->name }}, berikut adalah agenda mengajar Anda hari ini.</flux:subheading>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Jadwal Mengajar Guru --}}
                <div class="lg:col-span-2 p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm space-y-4">
                    <div>
                        <flux:heading size="lg" class="font-bold">Jadwal Mengajar Hari Ini ({{ now()->translatedFormat('l') }})</flux:heading>
                    </div>
                    <flux:separator variant="subtle" />
                    <div class="space-y-3">
                        @forelse($teacherSchedules as $schedule)
                            <div class="flex items-center justify-between p-4 bg-zinc-50 dark:bg-zinc-800/40 rounded-xl border border-zinc-200/50 dark:border-zinc-800">
                                <div class="flex items-center gap-4">
                                    <div class="p-2.5 bg-purple-500/10 text-purple-600 dark:text-purple-400 font-mono text-xs font-bold rounded-lg">
                                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-zinc-800 dark:text-zinc-200">{{ $schedule->subject }}</h4>
                                        <p class="text-xs text-zinc-400">Ruangan Fisik: <span class="font-semibold text-zinc-600 dark:text-zinc-300">{{ $schedule->classroom }}</span></p>
                                    </div>
                                </div>
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-md bg-green-500/10 text-green-600 dark:text-green-400">Aktif</span>
                            </div>
                        @empty
                            <div class="text-center py-8 text-zinc-400 text-xs italic">Tidak ada jadwal mengajar terdaftar atas nama Anda hari ini.</div>
                        @endforelse
                    </div>
                </div>

                {{-- Status Koreksi Tugas --}}
                <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm space-y-4 flex flex-col justify-between">
                    <div class="space-y-4">
                        <flux:heading size="lg" class="font-bold">Total Tugas Aktif</flux:heading>
                        <flux:separator variant="subtle" />
                        <div class="p-4 bg-amber-500/10 border border-amber-500/20 rounded-xl flex items-center gap-4">
                            <div class="p-3 bg-amber-500 text-white rounded-xl">
                                <flux:icon name="document-check" class="w-6 h-6" />
                            </div>
                            <div>
                                <h3 class="text-2xl font-black text-zinc-900 dark:text-white">{{ $pendingCorrectionsCount }}</h3>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">Total tugas diterbitkan</p>
                            </div>
                        </div>
                    </div>
                    <flux:button href="{{ route('assignment.index') }}" variant="filled" class="w-full justify-center bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-semibold text-xs py-2.5 mt-4">
                        Lihat Menu Tugas
                    </flux:button>
                </div>
            </div>
        @endif


        {{-- ========================================================================== --}}
        {{-- 3. TAMPILAN KHUSUS SISWA                                                   --}}
        {{-- ========================================================================== --}}
        @if($userRole === 'student' || $userRole === 'siswa')
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white dark:bg-zinc-900 p-6 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm">
                <div>
                    <flux:heading size="xl" class="text-zinc-900 dark:text-white font-black">Ruang Belajar Siswa</flux:heading>
                    <flux:subheading size="sm" class="text-zinc-500 dark:text-zinc-400 mt-1">Selamat datang {{ $user->name }}, pantau agenda belajar sekolahmu hari ini.</flux:subheading>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Jadwal Pelajaran Hari Ini --}}
                <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm space-y-4">
                    <div>
                        <flux:heading size="lg" class="font-bold">Jadwal Sekolah Hari Ini</flux:heading>
                        <flux:text size="sm" class="text-zinc-500">Agenda pelajaran terdaftar ({{ now()->translatedFormat('l') }})</flux:text>
                    </div>
                    <flux:separator variant="subtle" />
                    <div class="space-y-3">
                        @forelse($studentSchedules as $schedule)
                            <div class="flex items-center gap-3 p-3 bg-zinc-50 dark:bg-zinc-800/40 rounded-xl border border-zinc-100 dark:border-zinc-800">
                                <div class="text-[11px] font-mono font-bold text-blue-600 dark:text-blue-400 bg-blue-500/10 p-2 rounded-lg">
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-xs font-bold text-zinc-800 dark:text-zinc-200 truncate">{{ $schedule->subject }}</h4>
                                    <p class="text-[11px] text-zinc-400 truncate">Guru: {{ $schedule->teacher_name }} | Ruang: {{ $schedule->classroom }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-6 text-zinc-400 text-xs italic">Hari ini tidak ada kegiatan belajar terdaftar.</div>
                        @endforelse
                    </div>
                </div>

                {{-- Daftar Tugas --}}
                <div class="lg:col-span-2 p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm space-y-4">
                    <div>
                        <flux:heading size="lg" class="font-bold">Daftar Penugasan</flux:heading>
                        <flux:text size="sm" class="text-zinc-500">Daftar seluruh tugas yang diterbitkan sekolah</flux:text>
                    </div>
                    <flux:separator variant="subtle" />
                    <div class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                        @forelse($upcomingAssignments as $assignment)
                            <div class="py-3.5 first:pt-0 last:pb-0 flex justify-between items-center gap-4">
                                <div>
                                    <span class="font-bold text-zinc-800 dark:text-zinc-200 text-sm block">{{ $assignment->title }}</span>
                                    <span class="text-xs text-zinc-400">Kategori: {{ $assignment->subject ?? 'Umum' }}</span>
                                </div>
                                <div class="text-right">
                                    <span class="text-[10px] font-bold text-amber-600 dark:text-amber-400 bg-amber-500/10 px-2.5 py-1 rounded-md block">
                                        Batas Waktu: {{ \Carbon\Carbon::parse($assignment->due_date)->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-zinc-400 text-xs italic">Belum ada tugas yang diunggah.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif


        {{-- ========================================================================== --}}
        {{-- 4. PAPAN PENGUMUMAN (UNTUK SEMUA ROLE DI BAGIAN BAWAH)                       --}}
        {{-- ========================================================================== --}}
        <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm space-y-4">
            <div class="flex justify-between items-center">
                <div>
                    <flux:heading size="lg" class="font-bold">Papan Pengumuman</flux:heading>
                    <flux:text size="sm" class="text-zinc-500">Informasi resmi seputar aktivitas akademik terbaru</flux:text>
                </div>
                <flux:button variant="ghost" href="{{ route('announcement.index') }}" icon-right="chevron-right" size="sm" wire:navigate>
                    Lihat Semua
                </flux:button>
            </div>

            <flux:separator variant="subtle" />

            <div class="divide-y divide-zinc-100 dark:divide-zinc-800/60">
                @forelse($recentAnnouncements as $announcement)
                    <div class="py-4 first:pt-0 last:pb-0 flex justify-between items-start gap-4 hover:bg-zinc-50/50 dark:hover:bg-zinc-800/20 transition-colors rounded-xl px-2 -mx-2">
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-zinc-800 dark:text-zinc-200 text-sm leading-none">{{ $announcement->title }}</span>
                                <span class="font-extrabold px-2 py-0.5 rounded-md text-[9px] uppercase tracking-wider
                                    {{ $announcement->target === 'All' ? 'text-blue-600 bg-blue-50 dark:bg-blue-950/40 dark:text-blue-400' : '' }}
                                    {{ $announcement->target === 'Teachers' ? 'text-purple-600 bg-purple-50 dark:bg-purple-950/40 dark:text-purple-400' : '' }}
                                    {{ $announcement->target === 'Students' ? 'text-amber-600 bg-amber-50 dark:bg-amber-950/40 dark:text-amber-400' : '' }}">
                                    Target: {{ $announcement->target }}
                                </span>
                            </div>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 line-clamp-2 max-w-4xl leading-relaxed">
                                {{ $announcement->content }}
                            </p>
                        </div>
                        <span class="text-[11px] text-zinc-400 whitespace-nowrap font-medium bg-zinc-100 dark:bg-zinc-800 px-2 py-1 rounded-md">
                            {{ $announcement->created_at->diffForHumans() }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-8 text-zinc-400 italic text-sm flex flex-col items-center justify-center gap-2">
                        <flux:icon name="megaphone" class="w-7 h-7 text-zinc-300 dark:text-zinc-700" />
                        Belum ada pengumuman resmi terbaru saat ini.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</x-layouts::app>