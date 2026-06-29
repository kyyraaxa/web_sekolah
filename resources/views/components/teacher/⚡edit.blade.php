<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Teacher;
use App\Livewire\Forms\TeacherForm;

new class extends Component
{
    public TeacherForm $form;

    #[On('edit-teacher')]
    public function editTeacher($id){
        $teacher = Teacher::find($id);
        $this->form->setTeacher($teacher);
        Flux::modal('edit-teacher')->show();
    }

    public function updateTeacher() {
        $this->form->update();
        Flux::modal('edit-teacher')->close();
        session()->flash('success', 'Teacher updated successfully');
        $this->redirectRoute('teacher.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }

    #[On('confirm-delete')]
    public function confirmDelete($id)
    {
        $teacher = Teacher::find($id);
        $this->form->setTeacher($teacher);
        Flux::modal('delete-teacher')->show();
    }

    public function deleteTeacher() {
        $this->form->teacher->delete();
        Flux::modal('delete-teacher')->close();
        session()->flash('success', 'Teacher deleted successfully');
        $this->redirectRoute('teacher.index', navigate: true);
    }
};
?>

<div>

    {{-- edit modal --}}

    <flux:modal 
        name="edit-teacher" 
        class="md:w-150" 
        x-on:close="$wire.resetForm()" 
    >
        <form class="space-y-8" wire:submit.prevent="updateTeacher">
            {{-- header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Edit Teacher
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Edit your teacher details below
                </flux:text>
            </div>

            {{-- form field --}}
            <div class="space-y-6">
                <flux:input
                    label="Name"
                    placeholder="Teacher full name"
                    wire:model="form.name"
                />

                <flux:input
                    label="Subject"
                    placeholder="Subject taught"
                    wire:model="form.subject"
                />

                <flux:input
                    label="Email"
                    type="email"
                    placeholder="Teacher email"
                    wire:model="form.email"
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
        name="delete-teacher" 
        class="md:w-150" 
        x-on:close="$wire.resetForm()" 
    >
        <form class="space-y-8" wire:submit.prevent="deleteTeacher">
            {{-- header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Delete Teacher
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