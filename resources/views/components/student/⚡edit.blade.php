<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Student;
use App\Livewire\Forms\StudentForm;

new class extends Component
{
    public StudentForm $form;

    #[On('edit-student')]
    public function editStudent($id)
    {
        $student = Student::find($id);
        $this->form->setStudent($student);
        Flux::modal('edit-student')->show();
    }

    public function updateStudent() {
        $this->form->update();
        Flux::modal('edit-student')->close();
        session()->flash('success', 'Student updated successfully');
        $this->redirectRoute('student.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }

    #[On('confirm-delete')]
    public function confirmDelete($id)
    {
        $student = Student::find($id);
        $this->form->setStudent($student);
        Flux::modal('delete-student')->show();
    }

    public function deleteStudent() {
        $this->form->student->delete();
        Flux::modal('delete-student')->close();
        session()->flash('success', 'Student deleted successfully');
        $this->redirectRoute('student.index', navigate: true);
    }
};
?>

<div>

    {{-- edit modal --}}

    <flux:modal 
        name="edit-student" 
        class="md:w-150" 
        x-on:close="$wire.resetForm()" 
    >
        <form class="space-y-8" wire:submit.prevent="updateStudent">
            {{-- header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Edit Student
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Edit your student details below
                </flux:text>
            </div>

            {{-- form field --}}
            <div class="space-y-6">
                <flux:input
                    label="Name"
                    placeholder="Enter student name"
                    wire:model="form.name"
                    wire:dirty.class.text-red-500
                />

                <flux:input
                    label="Class"
                    placeholder="Enter student class"
                    wire:model="form.class"
                    wire:dirty.class.text-red-500
                />

                <flux:input
                    label="Email"
                    placeholder="Enter student email"
                    wire:model="form.email"
                    wire:dirty.class.text-red-500
                />
            </div>

            <div 
                wire:show ="$dirty"
                class="text-red-500 dark:text-red-400"
            >
                you have unsaved changes
            </div>
    
            {{-- footer --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Update</flux:button>
            </div>
                

        </form>
    </flux:modal>

    {{-- delete modal --}}

    <flux:modal 
        name="delete-student" 
        class="md:w-150" 
        x-on:close="$wire.resetForm()" 
    >
        <form class="space-y-8" wire:submit.prevent="deleteStudent">
            {{-- header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Delete Student
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    this action cannot be undone
                </flux:text>
            </div>

            {{-- footer --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="danger" type="submit">Delete</flux:button>
            </div>
                

        </form>
    </flux:modal>
</div>