<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use App\Models\Assignment;

new class extends Component
{
    use WithPagination;
    
    #[Computed]
    public function assignments()
    {
        return Assignment::latest()->paginate(10);
    }

    public function edit($id){
        $this->dispatch('edit-assignment', id: $id);
    }
};
?>

<div class="max-w-7xl mx-auto space-y-4">
    <flux:heading size="xl" class="text-zinc-800 dark:text-white">Assignments</flux:heading>
    
    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
        <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">Manage classroom tasks and deadlines</flux:subheading>
    @endif
    @if(auth()->user()->role === 'student')
        <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">View your classroom tasks and deadlines</flux:subheading>
    @endif
    
    <flux:separator variant="subtle" />
    
    {{-- Trigger Modal Tambah Assignment (Hanya Admin/Teacher) --}}
    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
        <flux:modal.trigger name="create-assignment">
            <flux:button variant="primary" icon="plus" color="primary">Add Assignment</flux:button>
        </flux:modal.trigger>
    @endif

    {{-- Komponen Form Modals --}}
    <livewire:assignment.create />
    <livewire:assignment.edit />
    <x-flash-message />

    {{-- ========================================================================= --}}
    {{-- TAMPILAN ADMIN / TEACHER (MENGGUNAKAN TABEL KELOLA)                       --}}
    {{-- ========================================================================= --}}
    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
        <div class="overflow-x-auto">
           <flux:table :paginate="$this->assignments">
                <flux:table.columns>
                    <flux:table.column>No</flux:table.column>
                    <flux:table.column>Title</flux:table.column>
                    <flux:table.column>Subject</flux:table.column>
                    <flux:table.column>Due Date</flux:table.column>
                    <flux:table.column>Action</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @foreach ($this->assignments as $assignment)
                        <flux:table.row :key="$assignment->assignment_id">
                            <flux:table.cell>
                                {{ $loop->iteration + ($this->assignments->firstItem() - 1) }}
                            </flux:table.cell>

                            <flux:table.cell class="font-medium">
                                {{ $assignment->title }}
                            </flux:table.cell>

                            <flux:table.cell class="text-zinc-500 dark:text-zinc-400">
                                {{ $assignment->subject }}
                            </flux:table.cell>

                            <flux:table.cell class="text-red-600 dark:text-red-400 font-semibold text-xs">
                                {{ $assignment->due_date->format('d M Y, H:i') }}
                            </flux:table.cell>

                            <flux:table.cell>
                                <div class="flex items-center gap-2">
                                    {{-- Tombol Utama untuk Membuka & Menilai Tugas --}}
                                    <flux:button size="sm" href="{{ route('assignment.show', $assignment->assignment_id) }}" wire:navigate>
                                        Lihat Pengumpulan
                                    </flux:button>

                                    <flux:dropdown>
                                        <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>
                                        <flux:menu>
                                            <flux:menu.item icon="pencil" wire:click="edit({{ $assignment->assignment_id }})">Edit</flux:menu.item>
                                            <flux:menu.separator />
                                            <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', {id: {{ $assignment->assignment_id }}})">Delete</flux:menu.item>
                                        </flux:menu>
                                    </flux:dropdown>
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </div>

    {{-- ========================================================================= --}}
    {{-- TAMPILAN SISWA (MENGGUNAKAN GRID CARDS INTERAKTIF)                        --}}
    {{-- ========================================================================= --}}
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($this->assignments as $assignment)
                @php 
                    // Ambil status submission siswa login saat ini
                    $mySub = $assignment->userSubmission; 
                @endphp
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-5 flex flex-col justify-between space-y-4 shadow-sm">
                    <div class="space-y-2">
                        <div class="flex justify-between items-start">
                            <span class="text-xs font-semibold px-2.5 py-0.5 bg-zinc-100 dark:bg-zinc-800 text-zinc-800 dark:text-zinc-200 rounded-md">
                                {{ $assignment->subject }}
                            </span>
                            
                            {{-- Badge Status --}}
                            @if($mySub && $mySub->grade !== null)
                                <span class="text-[10px] font-bold px-2 py-0.5 bg-green-100 text-green-700 dark:bg-green-950/40 dark:text-green-400 rounded-md">
                                    Nilai: {{ $mySub->grade }}
                                </span>
                            @elseif($mySub)
                                <span class="text-[10px] font-bold px-2 py-0.5 bg-blue-100 text-blue-700 dark:bg-blue-950/40 dark:text-blue-400 rounded-md">
                                    Sudah Dikumpul
                                </span>
                            @else
                                <span class="text-[10px] font-bold px-2 py-0.5 bg-amber-100 text-amber-700 dark:bg-amber-950/40 dark:text-amber-400 rounded-md">
                                    Belum Dikumpul
                                </span>
                            @endif
                        </div>
                        
                        <flux:heading size="lg" class="pt-1">{{ $assignment->title }}</flux:heading>
                        <p class="text-xs text-red-500 dark:text-red-400 font-medium">
                            Deadline: {{ $assignment->due_date->format('d M Y, H:i') }}
                        </p>
                    </div>

                    <div class="flex justify-end pt-2">
                        <flux:button href="{{ route('assignment.show', $assignment->assignment_id) }}" variant="primary" size="sm" wire:navigate>
                            {{ $mySub ? 'Lihat Jawaban' : 'Kerjakan Tugas' }}
                        </flux:button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination untuk tampilan card siswa --}}
        <div class="pt-4">
            {{ $this->assignments->links() }}
        </div>
    @endif
</div>