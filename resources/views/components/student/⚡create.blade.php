<?php

use Livewire\Component;
use App\Livewire\Forms\StudentForm;

new class extends Component
{
    // Instance class studentform
    public StudentForm $form;
    
    public function save()
    {
        $this->form->store();
        Flux::modal('create-student')->close();

        // session
        session()->flash('success', 'Student created successfully');

        $this->redirectRoute('student.index',navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }
};
?>

<div>
    <flux:modal name="create-student" class="md:w-96" x-on:close="$wire.resetForm()">
        <form class="space-y-8" wire:submit.prevent="save">
            {{-- header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Create Student
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Add a new student to your account
                </flux:text>
            </div>

            {{-- form field --}}
            <div class="space-y-6">
                <flux:input
                    label="Name"
                    placeholder="Enter student name"
                    wire:model="form.name"
                />

                <flux:input
                    label="Class"
                    placeholder="Enter student class"
                    wire:model="form.class"
                />

                <flux:input
                    label="Email"
                    placeholder="Enter student email"
                    wire:model="form.email"
                />
            </div>
    
            {{-- footer --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Create</flux:button>
            </div>
                

        </form>
    </flux:modal>
</div>