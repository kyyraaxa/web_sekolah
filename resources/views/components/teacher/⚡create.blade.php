<?php

use Livewire\Component;
use App\Livewire\Forms\TeacherForm;

new class extends Component
{
    // Instance class teacherform
    public TeacherForm $form;
    
    public function save()
    {
        $this->form->store();
        Flux::modal('create-teacher')->close();

        // session
        session()->flash('success', 'Teacher created successfully');

        $this->redirectRoute('teacher.index',navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }
};
?>

<div>
    <flux:modal name="create-teacher" class="md:w-96" x-on:close="$wire.resetForm()">
        <form class="space-y-8" wire:submit.prevent="save">
            {{-- header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Create Teacher
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Add a new teacher to your account
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