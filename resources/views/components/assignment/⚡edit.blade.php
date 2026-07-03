<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Assignment;
use App\Livewire\Forms\AssignmentForm;

new class extends Component
{
    public AssignmentForm $form;

    #[On('edit-assignment')]
    public function editAssignment($id){
        $assignment = Assignment::find($id);
        $this->form->setAssignment($assignment);
        Flux::modal('edit-assignment')->show();
    }

    public function updateAssignment() {
        $this->form->update();
        Flux::modal('edit-assignment')->close();
        session()->flash('success', 'Assignment updated successfully');
        $this->redirectRoute('assignment.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }

    #[On('confirm-delete')]
    public function confirmDelete($id)
    {
        $assignment = Assignment::find($id);
        if ($assignment) {
            $this->form->setAssignment($assignment);
            Flux::modal('delete-assignment')->show();
        }
    }

    public function deleteAssignment() {
        $this->form->destroy();
        Flux::modal('delete-assignment')->close();
        session()->flash('success', 'Assignment deleted successfully');
        $this->redirectRoute('assignment.index', navigate: true);
    }
};
?>

<div>
    {{-- EDIT MODAL --}}
    <flux:modal name="edit-assignment" class="md:w-120" x-on:close="$wire.resetForm()">
        <form class="space-y-6" wire:submit.prevent="updateAssignment">
            <div class="space-y-2">
                <flux:heading size="lg">Edit Assignment</flux:heading>
                <flux:text>Modify your assignment information</flux:text>
            </div>

            <div class="space-y-4">
                <flux:input
                    label="Assignment Title"
                    wire:model="form.title"
                />

                <flux:input
                    label="Subject"
                    wire:model="form.subject"
                />

                <flux:input
                    label="Due Date / Deadline"
                    type="datetime-local"
                    wire:model="form.due_date"
                />

                <flux:textarea 
                    label="Description / Instructions" 
                    wire:model="form.description"
                    rows="4"
                />
            </div>

            <div wire:show="$dirty" class="text-red-500 text-xs font-medium">
                You have unsaved changes
            </div>
    
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Update</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- DELETE MODAL --}}
    <flux:modal name="delete-assignment" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-6" wire:submit.prevent="deleteAssignment">
            <div class="space-y-2">
                <flux:heading size="lg">Delete Assignment</flux:heading>
                <flux:text>Are you sure you want to delete this assignment? Students will no longer see it.</flux:text>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="danger" type="submit">Delete</flux:button>
            </div>
        </form>
    </flux:modal>
</div>