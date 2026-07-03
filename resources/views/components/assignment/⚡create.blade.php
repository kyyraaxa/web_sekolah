<?php

use Livewire\Component;
use App\Livewire\Forms\AssignmentForm;

new class extends Component
{
    public AssignmentForm $form;
    
    public function save()
    {
        $this->form->store();
        Flux::modal('create-assignment')->close();

        session()->flash('success', 'Assignment created successfully');

        $this->redirectRoute('assignment.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }
};
?>

<div>
    <flux:modal name="create-assignment" class="md:w-120" x-on:close="$wire.resetForm()">
        <form class="space-y-6" wire:submit.prevent="save">
            <div class="space-y-2">
                <flux:heading size="lg">Create Assignment</flux:heading>
                <flux:text>Publish a new homework or project assignment</flux:text>
            </div>

            <div class="space-y-4">
                <flux:input
                    label="Assignment Title"
                    placeholder="e.g., Tugas Rumus Trigonometri"
                    wire:model="form.title"
                />

                <flux:input
                    label="Subject"
                    placeholder="e.g., Matematika"
                    wire:model="form.subject"
                />

                <flux:input
                    label="Due Date / Deadline"
                    type="datetime-local"
                    wire:model="form.due_date"
                />

                {{-- Textarea dari Flux UI untuk instruksi --}}
                <flux:textarea 
                    label="Description / Instructions" 
                    placeholder="Write details of the assignments here..." 
                    wire:model="form.description"
                    rows="4"
                />
            </div>
    
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Create</flux:button>
            </div>
        </form>
    </flux:modal>
</div>