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
    
    {{-- Trigger Modal Tambah Assignment --}}
    <flux:modal.trigger name="create-assignment">
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
            <flux:button variant="primary" icon="plus">Add Assignment</flux:button>
        @endif
    </flux:modal.trigger>

    {{-- Komponen Form Modals --}}
    <livewire:assignment.create />
    <livewire:assignment.edit />
    <x-flash-message />

    {{-- Table --}}
    <div class="overflow-x-auto">
       <flux:table :paginate="$this->assignments">
            <flux:table.columns>
                <flux:table.column>No</flux:table.column>
                <flux:table.column>Title</flux:table.column>
                <flux:table.column>Subject</flux:table.column>
                <flux:table.column>Due Date</flux:table.column>
                <flux:table.column>Created At</flux:table.column>
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

                        <flux:table.cell class="whitespace-nowrap">
                            {{ $assignment->created_at->diffForHumans() }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                <flux:menu>
                                    <flux:menu.item icon="pencil" wire:click="edit({{ $assignment->assignment_id }})">Edit</flux:menu.item>

                                    <flux:menu.separator />
                                    
                                    {{-- <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', id: $assignment->assignment_id)">Delete</flux:menu.item> --}}
                                    <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', {id: {{ $assignment->assignment_id }}})">Delete</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>