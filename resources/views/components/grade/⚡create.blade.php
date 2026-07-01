<?php

use Livewire\Component;
use App\Livewire\Forms\GradeForm;

new class extends Component
{
    // Instance class gradeform
    public GradeForm $form;
    
    public function save()
    {
        $this->form->store();
        Flux::modal('create-grade')->close();

        // session
        session()->flash('success', 'Grade recorded successfully');

        $this->redirectRoute('grade.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }
};
?>

<div>
    <flux:modal name="create-grade" class="md:w-96" x-on:close="$wire.resetForm()">
        <form class="space-y-8" wire:submit.prevent="save">
            {{-- header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Create Grade
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Add a new student grade record
                </flux:text>
            </div>

            {{-- form field --}}
            <div class="space-y-6">
                {{-- Input Student ID --}}
                <flux:input
                    label="Student ID"
                    type="number"
                    placeholder="e.g., 1"
                    wire:model="form.student_id"
                />

                {{-- Input Subject (Mata Pelajaran) --}}
                <flux:input
                    label="Subject"
                    placeholder="e.g., Mathematics"
                    wire:model="form.subject"
                />

                {{-- Input Score (Nilai Angka) --}}
                <flux:input
                    label="Score"
                    type="number"
                    placeholder="e.g., 85"
                    wire:model="form.score"
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