<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use App\Models\Attendance;

new class extends Component
{
    use WithPagination;

    #[Computed]
    public function stats()
    {
        return [
            'hadir' => Attendance::where('status', 'Hadir')->count(),
            'sakit' => Attendance::where('status', 'Sakit')->count(),
            'izin'  => Attendance::where('status', 'Izin')->count(),
            'alpa'  => Attendance::where('status', 'Alpa')->count(),
        ];
    }
    
    #[Computed]
    public function attendances()
    {
        // Menggunakan with('student') agar data nama siswa langsung ditarik sekaligus
        return Attendance::with('student')->latest('attendance_date')->paginate(10);
    }

    public function edit($id){
        // Mengirimkan sinyal ke modal edit khusus attendance
        $this->dispatch('edit-attendance', id: $id);
    }
};
?>

<div class="max-w-7xl mx-auto space-y-4">
    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
        
        {{-- Sisi Kiri: Judul Halaman --}}
        <div>
            <flux:heading size="xl" class="text-zinc-800 dark:text-white">Attendance</flux:heading>
            <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">Manage student attendance records</flux:subheading>
        </div>

        {{-- Sisi Kanan Atas: Kotak Riwayat Absensi (Sesuai Bundaran di edited-image_2.png) --}}
        <div class="w-fit flex items-center gap-2 bg-zinc-50 dark:bg-zinc-900 p-2 rounded-lg border border-zinc-200 dark:border-zinc-800 text-sm">
            <div class="px-3 py-1 bg-white dark:bg-zinc-800 rounded border border-zinc-200 dark:border-zinc-700 text-center">
                <span class="text-xs text-zinc-400 block font-medium">Hadir</span>
                <span class="font-bold text-green-600 dark:text-green-400">{{ $this->stats['hadir'] }}</span>
            </div>
            
            <div class="px-3 py-1 bg-white dark:bg-zinc-800 rounded border border-zinc-200 dark:border-zinc-700 text-center">
                <span class="text-xs text-zinc-400 block font-medium">Sakit</span>
                <span class="font-bold text-yellow-600 dark:text-yellow-400">{{ $this->stats['sakit'] }}</span>
            </div>

            <div class="px-3 py-1 bg-white dark:bg-zinc-800 rounded border border-zinc-200 dark:border-zinc-700 text-center">
                <span class="text-xs text-zinc-400 block font-medium">Izin</span>
                <span class="font-bold text-blue-600 dark:text-blue-400">{{ $this->stats['izin'] }}</span>
            </div>

            <div class="px-3 py-1 bg-white dark:bg-zinc-800 rounded border border-zinc-200 dark:border-zinc-700 text-center">
                <span class="text-xs text-zinc-400 block font-medium">Alpa</span>
                <span class="font-bold text-red-600 dark:text-red-400">{{ $this->stats['alpa'] }}</span>
            </div>
        </div>

    </div>
    <flux:separator variant="subtle" />
    
    <flux:modal.trigger name="create-attendance">
        <flux:button variant="primary" icon="plus" color="primary">Add Attendance</flux:button>
    </flux:modal.trigger>

    {{-- Memanggil komponen modal untuk create dan edit khusus attendance --}}
    <livewire:attendance.create />
    <livewire:attendance.edit />
    <x-flash-message />

    {{-- table --}}
    <div class="overflow-x-auto">
       <flux:table :paginate="$this->attendances">
            <flux:table.columns>
                <flux:table.column>No</flux:table.column>
                <flux:table.column>Student Name</flux:table.column>
                <flux:table.column>Status</flux:table.column>
                <flux:table.column>Attendance Date</flux:table.column>
                <flux:table.column>Created At</flux:table.column>
                <flux:table.column>Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->attendances as $attendance)
                    <flux:table.row :key="$attendance->attendance_id">

                        {{-- Nomor Urut --}}
                        <flux:table.cell>
                            {{ $loop->iteration + ($this->attendances->firstItem() - 1) }}
                        </flux:table.cell>

                        {{-- Menampilkan Nama Siswa dan ID-nya di dalam kurung --}}
                        <flux:table.cell class="font-medium text-zinc-800 dark:text-white">
                            @if($attendance->student)
                                {{ $attendance->student->name }} 
                                <span class="text-xs text-zinc-400 font-normal">(#{{ $attendance->student_id }})</span>
                            @else
                                <span class="text-red-500 italic">Siswa Tidak Ditemukan (#{{ $attendance->student_id }})</span>
                            @endif
                        </flux:table.cell>

                        {{-- Status dengan Badge atau warna teks bawaan --}}
                        <flux:table.cell>
                            <span class="font-semibold
                                {{ $attendance->status === 'Hadir' ? 'text-green-600 dark:text-green-400' : '' }}
                                {{ $attendance->status === 'Sakit' ? 'text-yellow-600 dark:text-yellow-400' : '' }}
                                {{ $attendance->status === 'Izin' ? 'text-blue-600 dark:text-blue-400' : '' }}
                                {{ $attendance->status === 'Alpa' ? 'text-red-600 dark:text-red-400' : '' }}">
                                {{ $attendance->status }}
                            </span>
                        </flux:table.cell>

                        {{-- Tanggal Absensi --}}
                        <flux:table.cell class="text-zinc-500 dark:text-zinc-400">
                            {{ $attendance->attendance_date }}
                        </flux:table.cell>

                        {{-- Waktu Input Sistem --}}
                        <flux:table.cell class="whitespace-nowrap">
                            {{ $attendance->created_at->diffForHumans() }}
                        </flux:table.cell>

                        {{-- Tombol Aksi --}}
                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                <flux:menu>
                                    <flux:menu.item icon="pencil" wire:click="edit({{ $attendance->attendance_id }})">Edit</flux:menu.item>

                                    <flux:menu.separator />

                                    {{-- <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', id: $attendance->attendance_id)">Delete</flux:menu.item> --}}
                                    <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete-attendance', {id: {{ $attendance->attendance_id }}})">Delete</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>