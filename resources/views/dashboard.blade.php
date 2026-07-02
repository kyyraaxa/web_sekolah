<?php
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Payment;
use App\Models\Announcement;

// Mengambil data ringkasan di paling atas file agar bersih dari struktur Blade
$totalStudents       = Student::count();
$totalTeachers       = Teacher::count();
$totalRevenue        = Payment::where('status', 'Paid')->sum('amount');
$recentAnnouncements = Announcement::latest()->take(5)->get();
?>

<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl">
        {{-- Header Dashboard --}}
        <div>
            <flux:heading size="xl" class="text-zinc-800 dark:text-white">Dashboard</flux:heading>
            <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">Welcome back! Here's an overview of your school data.</flux:subheading>
        </div>

        <flux:separator variant="subtle" />

        {{-- 3 Kotak Kecil di Atas (Ringkas & Proposional) --}}
        <div class="grid gap-4 md:grid-cols-3">
            {{-- Kotak 1: Total Students --}}
            <div class="p-4 bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm flex items-center gap-4">
                <div class="p-3 bg-blue-50 dark:bg-blue-950/50 text-blue-600 rounded-lg shrink-0">
                    <flux:icon name="users" variant="outline" class="w-6 h-6" />
                </div>
                <div>
                    <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400 block">Total Students</span>
                    <h3 class="text-xl font-bold text-zinc-800 dark:text-white mt-0.5">
                        {{ $totalStudents }}
                    </h3>
                </div>
            </div>

            {{-- Kotak 2: Total Teachers --}}
            <div class="p-4 bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm flex items-center gap-4">
                <div class="p-3 bg-purple-50 dark:bg-purple-950/50 text-purple-600 rounded-lg shrink-0">
                    <flux:icon name="academic-cap" variant="outline" class="w-6 h-6" />
                </div>
                <div>
                    <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400 block">Total Teachers</span>
                    <h3 class="text-xl font-bold text-zinc-800 dark:text-white mt-0.5">
                        {{ $totalTeachers }}
                    </h3>
                </div>
            </div>

            {{-- Kotak 3: Total Income --}}
            <div class="p-4 bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm flex items-center gap-4">
                <div class="p-3 bg-green-50 dark:bg-green-950/50 text-green-600 rounded-lg shrink-0">
                    <flux:icon name="banknotes" variant="outline" class="w-6 h-6" />
                </div>
                <div>
                    <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400 block">Total Paid Fees</span>
                    <h3 class="text-xl font-bold text-zinc-800 dark:text-white mt-0.5">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>

        {{-- Kotak Besar Bawah: Pengumuman Terbaru --}}
        <div class="p-6 bg-white dark:bg-zinc-900 border border-neutral-200 dark:border-neutral-700 rounded-xl shadow-sm space-y-4 flex-1">
            <div class="flex justify-between items-center">
                <div>
                    <flux:heading size="lg">Recent Announcements</flux:heading>
                    <flux:text size="sm">Latest bulletins and updates posted recently</flux:text>
                </div>
                <flux:button variant="ghost" href="{{ route('announcement.index') }}" icon-right="chevron-right" inset="top bottom" wire:navigate>
                    View All
                </flux:button>
            </div>

            <flux:separator variant="subtle" />

            <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                @forelse($recentAnnouncements as $announcement)
                    <div class="py-4 first:pt-0 last:pb-0 flex justify-between items-start gap-4">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="font-semibold text-zinc-800 dark:text-white">{{ $announcement->title }}</span>
                                <span class="font-bold px-1.5 py-0.5 rounded text-[10px]
                                    {{ $announcement->target === 'All' ? 'text-blue-600 bg-blue-50 dark:bg-blue-950/30' : '' }}
                                    {{ $announcement->target === 'Teachers' ? 'text-purple-600 bg-purple-50 dark:bg-purple-950/30' : '' }}
                                    {{ $announcement->target === 'Students' ? 'text-yellow-600 bg-yellow-50 dark:bg-yellow-950/30' : '' }}">
                                    {{ $announcement->target }}
                                </span>
                            </div>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400 line-clamp-2">
                                {{ $announcement->content }}
                            </p>
                        </div>
                        <span class="text-xs text-zinc-400 whitespace-nowrap">
                            {{ $announcement->created_at->diffForHumans() }}
                        </span>
                    </div>
                @empty
                    <div class="text-center py-8 text-zinc-400 italic text-sm">
                        No announcements posted yet.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts::app>