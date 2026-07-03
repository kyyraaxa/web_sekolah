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
        // Menampilkan jadwal terbaru dan diurutkan berdasarkan hari/waktu masuk
        return Schedule::latest()->paginate(10);
    }

    public function edit($id){
        $this->dispatch('edit-schedule', id: $id);
    }
};
?>

<div class="max-w-7xl mx-auto space-y-4">
    <flux:heading size="xl" class="text-zinc-800 dark:text-white">Class Schedules</flux:heading>
    <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">Manage your school learning schedules</flux:subheading>
    <flux:separator variant="subtle" />
    
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

                                    {{-- <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', id: $schedule->schedule_id)">Delete</flux:menu.item> --}}
                                    <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', {id: {{ $schedule->schedule_id }}})">Delete</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>