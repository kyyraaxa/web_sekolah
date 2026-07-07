<?php

use Livewire\Component;
use App\Livewire\Forms\AttendanceForm;
use Livewire\Attributes\Computed;
use App\Models\Student;

new class extends Component
{
    // Instance class attendanceform
    public AttendanceForm $form;
    
    public function save()
    {
        $this->form->store();
        Flux::modal('create-attendance')->close();

        // session
        session()->flash('success', 'Attendance recorded successfully');

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
        $this->form->attendance_date = date('Y-m-d'); // Memastikan default tanggal kembali ke hari ini
    }
};
?>

<div>
    <flux:modal name="create-attendance" class="md:w-96" x-on:close="$wire.resetForm()">
        <form class="space-y-8" wire:submit.prevent="save">
            {{-- header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Create Attendance
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Add a new student attendance record
                </flux:text>
            </div>

            {{-- form field --}}
            <div class="space-y-6">
                <flux:select label="Student" wire:model="form.student_id" placeholder="Choose student...">
                    @foreach ($this->getStudents as $student)
                        <flux:select.option value="{{ $student->student_id }}">{{ $student->name }}</flux:select.option>
                    @endforeach
                </flux:select>

                {{-- Status Kehadiran (Dropdown/Select) --}}
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