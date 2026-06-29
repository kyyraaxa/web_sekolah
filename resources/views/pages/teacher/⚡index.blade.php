<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use App\Models\Teacher;

new class extends Component
{
    use WithPagination;
    
    #[Computed]
    public function teachers()
    {
        return Teacher::latest()->paginate(10);
    }

    public function edit($id){
        $this->dispatch('edit-teacher', id: $id);
    }
};
?>

<div class="max-w-7xl mx-auto space-y-4">
    <flux:heading size="xl" class="text-zinc-800 dark:text-white">Teachers</flux:heading>
    <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">Manage your teachers</flux:subheading>
    <flux:separator variant="subtle" />
    
    <flux:modal.trigger name="create-teacher">
        <flux:button variant="primary" icon="plus" color="primary">Add Teacher</flux:button>
    </flux:modal.trigger>

    <livewire:teacher.create />
    <livewire:teacher.edit />
    <x-flash-message />

    {{-- table --}}
    <div class="overflow-x-auto">
       <flux:table :paginate="$this->teachers">
            <flux:table.columns>
                <flux:table.column>No</flux:table.column>
                <flux:table.column>Name</flux:table.column>
                <flux:table.column>Subject</flux:table.column>
                <flux:table.column>Email</flux:table.column>
                <flux:table.column>Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->teachers as $teacher)
                    <flux:table.row :key="$teacher->id">

                        <flux:table.cell>
                            {{ $loop->iteration + ($this->teachers->firstItem() - 1) }}
                        </flux:table.cell>

                        <flux:table.cell class="flex items-center gap-3">
                            {{ $teacher->name }}
                        </flux:table.cell>

                        <flux:table.cell class="text-zinc-500 dark:text-zinc-400">
                            {{ $teacher->subject }}
                        </flux:table.cell>

                        <flux:table.cell class="text-zinc-500 dark:text-zinc-400">
                            {{ $teacher->email }}
                        </flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap">{{ $teacher->created_at->diffForHumans() }}</flux:table.cell>

                        <flux:table.cell>


                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                <flux:menu>
                                    <flux:menu.item icon="pencil" wire:click="edit({{ $teacher->id }})">Edit</flux:menu.item>

                                    <flux:menu.separator />

                                    {{-- <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', id: $teacher->id)">Delete</flux:menu.item> --}}
                                    <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', {id: {{ $teacher->id }}})">Delete</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
</div>