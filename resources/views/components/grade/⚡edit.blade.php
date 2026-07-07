<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Grade;
use App\Livewire\Forms\GradeForm;
use App\Models\Student;

new class extends Component
{
    public GradeForm $form;

    #[On('edit-grade')]
    public function editGrade($id){
        $grade = Grade::find($id);
        $this->form->setGrade($grade);
        Flux::modal('edit-grade')->show();
    }

    public function updateGrade() {
        $this->form->update();
        Flux::modal('edit-grade')->close();
        session()->flash('success', 'Grade updated successfully');
        $this->redirectRoute('grade.index', navigate: true);
    }

    // ambil semua data student
    #[computed]
    public function getStudents(){
        return Student::all();
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }

    #[On('confirm-delete-grade')]
    public function confirmDelete($id)
    {
        $grade = Grade::find($id);
        $this->form->setGrade($grade);
        Flux::modal('delete-grade')->show();
    }

    public function deleteGrade() {
        $this->form->destroy();
        Flux::modal('delete-grade')->close();
        session()->flash('success', 'Grade deleted successfully');
        $this->redirectRoute('grade.index', navigate: true);
    }
};
?>

<div>
    {{-- edit modal --}}
    <flux:modal 
        name="edit-grade" 
        class="md:w-150" 
        x-on:close="$wire.resetForm()" 
    >
        <form class="space-y-8" wire:submit.prevent="updateGrade">
            {{-- header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Edit Grade
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Edit student grade details below
                </flux:text>
            </div>

            {{-- form field --}}
            <div class="space-y-6">
                {{-- Input Student ID --}}
                <flux:select label="Student" wire:model="form.student_id" placeholder="Choose student...">
                    @foreach ($this->getStudents() as $student)
                        <flux:select.option value="{{ $student->student_id }}">{{ $student->name }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:input
                    label="Subject"
                    placeholder="e.g., Mathematics"
                    wire:model="form.subject"
                />

                <flux:input
                    label="Score"
                    type="number"
                    placeholder="e.g., 85"
                    wire:model="form.score"
                />
            </div>

            <div 
                wire:show="$dirty"
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
        name="delete-grade" 
        class="md:w-150" 
        x-on:close="$wire.resetForm()" 
    >
        <form class="space-y-8" wire:submit.prevent="deleteGrade">
            {{-- header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Delete Grade
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