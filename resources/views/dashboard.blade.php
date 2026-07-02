<?php
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Payment;
use App\Models\Announcement;

// Mengambil data counter statistik sekolah
$totalStudents       = Student::count();
$totalTeachers       = Teacher::count();
$totalRevenue        = Payment::where('status', 'Paid')->sum('amount');
$recentAnnouncements = Announcement::latest()->take(4)->get();
?>

<x-layouts::app :title="__('Dashboard Utama')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        {{-- Row 1: Header Sambutan --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white dark:bg-zinc-900 p-6 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm">
            <div>
                <flux:heading size="xl" class="text-zinc-900 dark:text-white font-black">Selamat Datang di SSMS</flux:heading>
                <flux:subheading size="sm" class="text-zinc-500 dark:text-zinc-400 mt-1">Berikut adalah ringkasan perkembangan data operasional sekolah hari ini.</flux:subheading>
            </div>
            <div class="flex items-center gap-2 text-xs font-semibold bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 px-3 py-1.5 rounded-lg w-fit">
                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                Sistem Online (Hari Ini)
            </div>
        </div>

        {{-- Grid Card Statistik --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            
            {{-- Card Total Students --}}
            <div class="flex items-center justify-between p-4 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm">
                <div class="space-y-1 min-w-0">
                    <span class="text-xs font-medium text-zinc-400 block truncate">Total Students</span>
                    <h3 class="text-2xl font-bold text-zinc-900 dark:text-white leading-none tracking-tight">{{ number_format($totalStudents) }}</h3>
                    <span class="inline-block text-[11px] font-medium text-green-500 mt-1">Aktif Semester Ini</span>
                </div>
                <div class="p-2.5 bg-blue-500/10 text-blue-500 dark:text-blue-400 rounded-lg flex-shrink-0 ml-3">
                    <flux:icon name="users" variant="outline" class="w-5 h-5" />
                </div>
            </div>

            {{-- Card Total Teachers --}}
            <div class="flex items-center justify-between p-4 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm">
                <div class="space-y-1 min-w-0">
                    <span class="text-xs font-medium text-zinc-400 block truncate">Guru & Staf</span>
                    <h3 class="text-2xl font-bold text-zinc-900 dark:text-white leading-none tracking-tight">{{ number_format($totalTeachers) }}</h3>
                    <span class="inline-block text-[11px] font-medium text-zinc-500 mt-1">Total Pengajar Aktif</span>
                </div>
                <div class="p-2.5 bg-purple-500/10 text-purple-500 dark:text-purple-400 rounded-lg flex-shrink-0 ml-3">
                    <flux:icon name="academic-cap" variant="outline" class="w-5 h-5" />
                </div>
            </div>

            {{-- Card Total Paid Fees --}}
            <div class="flex items-center justify-between p-4 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm">
                <div class="space-y-1 min-w-0">
                    <span class="text-xs font-medium text-zinc-400 block truncate">Keuangan Terbayar</span>
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white leading-none tracking-tight whitespace-nowrap">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <span class="inline-block text-[11px] font-medium text-zinc-500 mt-1">Akumulasi Pembayaran SPP</span>
                </div>
                <div class="p-2.5 bg-emerald-500/10 text-emerald-500 dark:text-emerald-400 rounded-lg flex-shrink-0 ml-3">
                    <flux:icon name="banknotes" variant="outline" class="w-5 h-5" />
                </div>
            </div>

        </div>

        {{-- Row 3: Pengumuman Sekolah Terbaru --}}
        <div class="p-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm space-y-4 flex-1">
            <div class="flex justify-between items-center">
                <div>
                    <flux:heading size="lg" class="font-bold text-zinc-900 dark:text-white">Papan Pengumuman Sekolah</flux:heading>
                    <flux:text size="sm" class="text-zinc-500">Informasi dan agenda kegiatan akademik terbaru</flux:text>
                </div>
                {{-- Nama route di bawah ini sudah diperbaiki menjadi 'announcement.index' --}}
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
                    <div class="text-center py-12 text-zinc-400 italic text-sm flex flex-col items-center justify-center gap-2">
                        <flux:icon name="megaphone" class="w-8 h-8 text-zinc-300 dark:text-zinc-700" />
                        Belum ada pengumuman resmi yang diterbitkan.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts::app>