<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use App\Models\Schedule;

new class extends Component
{
    use WithPagination;
    
    #[Computed]
    public function schedules()
    {
        // Jika siswa, Anda bisa menambahkan filter spesifik di sini jika ada (misal berdasarkan kelas siswa)
        // Contoh: return Schedule::where('classroom', auth()->user()->classroom)->orderBy('day')...
        
        if (auth()->user()->role === 'student') {
            return Schedule::latest()->paginate(9); // Menggunakan kelipatan 3 agar rapi di tampilan grid card
        }

        return Schedule::latest()->paginate(10);
    }

    public function edit($id){
        $this->dispatch('edit-schedule', id: $id);
    }
};
?>

<div class="max-w-7xl mx-auto space-y-4">
    <flux:heading size="xl" style="font-weight: bold;" class="text-zinc-800 dark:text-white">Class Schedules</flux:heading>
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
            <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">Manage school learning schedules</flux:subheading>
        @endif
        @if(auth()->user()->role === 'student')
            <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">View your learning schedules</flux:subheading>
        @endif
    <flux:separator variant="subtle" />
    
    {{-- TAMPILAN ADMIN / GURU --}}
    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
        {{-- Trigger Modal Tambah Jadwal --}}
        <flux:modal.trigger name="create-schedule">
            <flux:button variant="primary" icon="plus" color="primary">Add Schedule</flux:button>
        </flux:modal.trigger>

        {{-- Memanggil komponen form create & edit khusus schedule --}}
        <livewire:schedule.create />
        <livewire:schedule.edit />
        <x-flash-message />

        {{-- Tabel Jadwal Pelajaran --}}
        <div class="overflow-x-auto">
           <flux:table :paginate="$this->schedules">
                <flux:table.columns>
                    <flux:table.column>No</flux:table.column>
                    <flux:table.column>Day</flux:table.column>
                    <flux:table.column>Subject</flux:table.column>
                    <flux:table.column>Time</flux:table.column>
                    <flux:table.column>Classroom</flux:table.column>
                    <flux:table.column>Teacher</flux:table.column>
                    <flux:table.column>Action</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @foreach ($this->schedules as $schedule)
                        <flux:table.row :key="$schedule->schedule_id">

                            {{-- Nomor Urut Terpaginasi --}}
                            <flux:table.cell>
                                {{ $loop->iteration + ($this->schedules->firstItem() - 1) }}
                            </flux:table.cell>

                            {{-- Hari --}}
                            <flux:table.cell class="font-medium">
                                {{ $schedule->day }}
                            </flux:table.cell>

                            {{-- Mata Pelajaran --}}
                            <flux:table.cell>
                                {{ $schedule->subject }}
                            </flux:table.cell>

                            {{-- Jam Pelajaran --}}
                            <flux:table.cell class="text-zinc-500 dark:text-zinc-400">
                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                            </flux:table.cell>

                            {{-- Ruang Kelas --}}
                            <flux:table.cell class="text-zinc-500 dark:text-zinc-400">
                                {{ $schedule->classroom }}
                            </flux:table.cell>

                            {{-- Nama Guru --}}
                            <flux:table.cell class="text-zinc-500 dark:text-zinc-400">
                                {{ $schedule->teacher_name }}
                            </flux:table.cell>

                            {{-- Dropdown Aksi (Edit / Delete) --}}
                            <flux:table.cell>
                                <flux:dropdown>
                                    <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                    <flux:menu>
                                        <flux:menu.item icon="pencil" wire:click="edit({{ $schedule->schedule_id }})">Edit</flux:menu.item>
                                        <flux:menu.separator />
                                        <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', {id: {{ $schedule->schedule_id }}})">Delete</flux:menu.item>
                                    </flux:menu>
                                </flux:dropdown>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </div>

    {{-- TAMPILAN SISWA --}}
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse ($this->schedules as $schedule)
                <div class="p-5 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl shadow-sm flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        {{-- Tag Hari & Badge Kelas --}}
                        <div class="flex items-center justify-between">
                            <span class="font-bold px-2.5 py-1 rounded-md text-xs text-blue-600 bg-blue-50 dark:bg-blue-950/30 dark:text-blue-400">
                                {{ $schedule->day }}
                            </span>
                            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-2 py-0.5 rounded">
                                {{ $schedule->classroom }}
                            </span>
                        </div>
                        
                        {{-- Nama Mata Pelajaran --}}
                        <h3 class="font-semibold text-lg text-zinc-800 dark:text-white line-clamp-1">
                            {{ $schedule->subject }}
                        </h3>
                        
                        <flux:separator variant="subtle" />

                        {{-- Detail Jam & Guru --}}
                        <div class="space-y-1.5 pt-1">
                            <div class="flex items-center text-sm text-zinc-600 dark:text-zinc-400">
                                <flux:icon name="clock" variant="outline" class="w-4 h-4 mr-2 text-zinc-400" />
                                <span>{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</span>
                            </div>
                            <div class="flex items-center text-sm text-zinc-600 dark:text-zinc-400">
                                <flux:icon name="user" variant="outline" class="w-4 h-4 mr-2 text-zinc-400" />
                                <span class="truncate">{{ $schedule->teacher_name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-zinc-500 dark:text-zinc-400">
                    No learning schedules available at the moment.
                </div>
            @endforelse
        </div>

        {{-- Pagination untuk Grid Siswa --}}
        <div class="mt-4">
            {{ $this->schedules->links() }}
        </div>
    @endif
</div>