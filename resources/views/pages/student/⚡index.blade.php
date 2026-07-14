<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use App\Models\Student;

new class extends Component
{
    use WithPagination;
    
    #[Computed]
    public function students()
    {
        return Student::latest()->paginate(10);
    }
    public function edit($id){
        $this->dispatch('edit-student', id: $id);
    }
};
?>

<div class="max-w-7xl mx-auto space-y-4">
    <flux:heading size="xl" style="font-weight: bold;" class="text-zinc-800 dark:text-white">Students</flux:heading>
    <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">Manage your students</flux:subheading>
    <flux:separator variant="subtle" />
    
    <flux:modal.trigger name="create-student">
        <flux:button variant="primary" icon="plus" color="primary">Add Student</flux:button>
    </flux:modal.trigger>
    <livewire:student.create />
    <livewire:student.edit />   
    <x-flash-message />
    {{-- table --}}
    <div class="overflow-x-auto">
        <flux:table :paginate="$this->students">
            <flux:table.columns>
                <flux:table.column>No</flux:table.column>
                <flux:table.column>Name</flux:table.column>
                <flux:table.column>Class</flux:table.column>
                <flux:table.column>Email</flux:table.column>
                <flux:table.column>Created At</flux:table.column>
                <flux:table.column>Action</flux:table.column>
            </flux:table.columns>
            <flux:table.rows>
                @foreach ($this->students as $student)
                    <flux:table.row :key="$student->student_id">
                        <flux:table.cell>
                            {{ $loop->iteration + ($this->students->firstItem() - 1) }}
                        </flux:table.cell>
                        <flux:table.cell class="flex items-center gap-3">
                            {{ $student->name }}
                        </flux:table.cell>
                        <flux:table.cell class="text-zinc-500 dark:text-zinc-400">
                            {{ $student->class }}
                        </flux:table.cell>
                        <flux:table.cell class="text-zinc-500 dark:text-zinc-400">
                            {{ $student->email }}
                        </flux:table.cell>
                        <flux:table.cell class="whitespace-nowrap">{{ $student->created_at->diffForHumans() }}</flux:table.cell>
                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>
                                <flux:menu>
                                    <flux:menu.item icon="pencil" wire:click="edit({{ $student->student_id }})">Edit</flux:menu.item>
                                    <flux:menu.separator />
                                    {{-- <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', id: $student->student_id)">Delete</flux:menu.item> --}}
                                    <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', { id: {{ $student->student_id }} })">Delete</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
</div>