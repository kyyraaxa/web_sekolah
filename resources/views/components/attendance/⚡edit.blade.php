<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Attendance;
use App\Livewire\Forms\AttendanceForm;
use App\Models\Student;

new class extends Component
{
    public AttendanceForm $form;

    #[On('edit-attendance')]
    public function editAttendance($id){
        $attendance = Attendance::find($id);
        $this->form->setAttendance($attendance);
        Flux::modal('edit-attendance')->show();
    }

    public function updateAttendance() {
        $this->form->update();
        Flux::modal('edit-attendance')->close();
        session()->flash('success', 'Attendance updated successfully');
        $this->redirectRoute('attendance.index', navigate: true);
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
        $this->form->attendance_date = date('Y-m-d'); // Mengembalikan default tanggal setelah form di-reset
    }

    #[On('confirm-delete-attendance')]
    public function confirmDelete($id)
    {
        $attendance = Attendance::find($id);
        $this->form->setAttendance($attendance);
        Flux::modal('delete-attendance')->show();
    }

    public function deleteAttendance() {
        $this->form->destroy();
        Flux::modal('delete-attendance')->close();
        session()->flash('success', 'Attendance deleted successfully');
        $this->redirectRoute('attendance.index', navigate: true);
    }
};
?>

<div>

    {{-- edit modal --}}

    <flux:modal 
        name="edit-attendance" 
        class="md:w-150" 
        x-on:close="$wire.resetForm()" 
    >
        <form class="space-y-8" wire:submit.prevent="updateAttendance">
            {{-- header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Edit Attendance
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Edit student attendance details below
                </flux:text>
            </div>

            {{-- form field --}}
            <div class="space-y-6">
                {{-- Student ID --}}
                <flux:select label="Student" wire:model="form.student_id" placeholder="Choose student...">
                    @foreach ($this->getStudents() as $student)
                        <flux:select.option value="{{ $student->student_id }}">{{ $student->name }}</flux:select.option>
                    @endforeach
                </flux:select>

                {{-- Status Kehadiran --}}
                <flux:select label="Status" placeholder="Select status..." wire:model="form.status">
                    <flux:select.option value="Hadir">Hadir</flux:select.option>
                    <flux:select.option value="Sakit">Sakit</flux:select.option>
                    <flux:select.option value="Izin">Izin</flux:select.option>
                    <flux:select.option value="Alpa">Alpa</flux:select.option>
                </flux:select>

                {{-- Tanggal Absensi --}}
                <flux:input
                    label="Attendance Date"
                    type="date"
                    wire:model="form.attendance_date"
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
        name="delete-attendance" 
        class="md:w-150" 
        x-on:close="$wire.resetForm()" 
    >
        <form class="space-y-8" wire:submit.prevent="deleteAttendance">
            {{-- header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Delete Attendance
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