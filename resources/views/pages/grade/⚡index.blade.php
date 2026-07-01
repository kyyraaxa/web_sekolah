<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use App\Models\Grade;

new class extends Component
{
    use WithPagination;
    
    #[Computed]
    public function grades()
    {
        // Menggunakan with('student') agar database tidak berat (Eager Loading)
        return Grade::with('student')->latest()->paginate(10);
    }

    public function edit($id){
        // Mengirimkan sinyal ke modal edit khusus grade
        $this->dispatch('edit-grade', id: $id);
    }
};
?>

<div class="max-w-7xl mx-auto space-y-4">
    <flux:heading size="xl" class="text-zinc-800 dark:text-white">Grades</flux:heading>
    <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">Manage student academic grades</flux:subheading>
    <flux:separator variant="subtle" />
    
    <flux:modal.trigger name="create-grade">
        <flux:button variant="primary" icon="plus" color="primary">Add Grade</flux:button>
    </flux:modal.trigger>

    {{-- Memanggil komponen sub-modal khusus grade --}}
    <livewire:grade.create />
    <livewire:grade.edit />
    <x-flash-message />

    {{-- table --}}
    <div class="overflow-x-auto">
       <flux:table :paginate="$this->grades">
            <flux:table.columns>
                <flux:table.column>No</flux:table.column>
                <flux:table.column>Student Name</flux:table.column>
                <flux:table.column>Subject</flux:table.column>
                <flux:table.column>Score</flux:table.column>
                <flux:table.column>Grade</flux:table.column>
                <flux:table.column>Created At</flux:table.column>
                <flux:table.column>Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->grades as $grade)
                    <flux:table.row :key="$grade->grade_id">

                        {{-- Nomor Urut --}}
                        <flux:table.cell>
                            {{ $loop->iteration + ($this->grades->firstItem() - 1) }}
                        </flux:table.cell>

                        {{-- Kolom Hubungan Nama Siswa & ID --}}
                        <flux:table.cell class="font-medium text-zinc-800 dark:text-white">
                            @if($grade->student)
                                {{ $grade->student->name }} 
                                <span class="text-xs text-zinc-400 font-normal">(#{{ $grade->student_id }})</span>
                            @else
                                <span class="text-red-500 italic text-xs">Siswa Tidak Ditemukan (#{{ $grade->student_id }})</span>
                            @endif
                        </flux:table.cell>

                        {{-- Nama Mata Pelajaran --}}
                        <flux:table.cell class="text-zinc-500 dark:text-zinc-400">
                            {{ $grade->subject }}
                        </flux:table.cell>

                        {{-- Nilai Angka --}}
                        <flux:table.cell class="text-zinc-500 dark:text-zinc-400 font-semibold">
                            {{ $grade->score }}
                        </flux:table.cell>

                        {{-- Huruf Grade dengan Pewarnaan Dinamis --}}
                        <flux:table.cell>
                            <span class="font-bold px-2 py-0.5 rounded text-xs
                                {{ in_array($grade->grade_letter, ['A', 'B']) ? 'text-green-600 bg-green-50 dark:bg-green-950/30' : '' }}
                                {{ $grade->grade_letter === 'C' ? 'text-yellow-600 bg-yellow-50 dark:bg-yellow-950/30' : '' }}
                                {{ in_array($grade->grade_letter, ['D', 'E']) ? 'text-red-600 bg-red-50 dark:bg-red-950/30' : '' }}">
                                {{ $grade->grade_letter }}
                            </span>
                        </flux:table.cell>

                        {{-- Waktu Dibuat --}}
                        <flux:table.cell class="whitespace-nowrap">
                            {{ $grade->created_at->diffForHumans() }}
                        </flux:table.cell>

                        {{-- Dropdown Aksi --}}
                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                <flux:menu>
                                    <flux:menu.item icon="pencil" wire:click="edit({{ $grade->grade_id }})">Edit</flux:menu.item>

                                    <flux:menu.separator />

                                    {{-- <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', id: $grade->grade_id)">Delete</flux:menu.item> --}}
                                    <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete-grade', {id: {{ $grade->grade_id }}})">Delete</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>