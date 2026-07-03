<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Schedule;
use App\Livewire\Forms\ScheduleForm;

new class extends Component
{
    public ScheduleForm $form;

    // Menangkap event edit-schedule dari halaman index
    #[On('edit-schedule')]
    public function editSchedule($id){
        $schedule = Schedule::find($id);
        $this->form->setSchedule($schedule);
        Flux::modal('edit-schedule')->show();
    }

    public function updateSchedule() {
        $this->form->update();
        Flux::modal('edit-schedule')->close();
        session()->flash('success', 'Schedule updated successfully');
        $this->redirectRoute('schedule.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }

    // Menangkap event confirm-delete dari tombol hapus di tabel
    #[On('confirm-delete')]
    public function confirmDelete($id)
    {
        $schedule = Schedule::find($id);
        // Pastikan record jadwal ditemukan sebelum set form
        if ($schedule) {
            $this->form->setSchedule($schedule);
            Flux::modal('delete-schedule')->show();
        }
    }

    public function deleteSchedule() {
        $this->form->destroy();
        Flux::modal('delete-schedule')->close();
        session()->flash('success', 'Schedule deleted successfully');
        $this->redirectRoute('schedule.index', navigate: true);
    }
};
?>

<div>
    {{-- EDIT MODAL --}}
    <flux:modal 
        name="edit-schedule" 
        class="md:w-150" 
        x-on:close="$wire.resetForm()" 
    >
        <form class="space-y-6" wire:submit.prevent="updateSchedule">
            {{-- Header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Edit Schedule
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Edit your class schedule details below
                </flux:text>
            </div>

            {{-- Form Fields khusus Schedule --}}
            <div class="space-y-4">
                
                {{-- Input Hari --}}
                <flux:select label="Day" placeholder="Select day" wire:model="form.day">
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jumat</option>
                </flux:select>

                <flux:input
                    label="Subject"
                    placeholder="Contoh: Matematika Wajib"
                    wire:model="form.subject"
                />

                {{-- Jam Pelajaran menyamping --}}
                <div class="grid grid-cols-2 gap-3">
                    <flux:input
                        label="Start Time"
                        type="time"
                        wire:model="form.start_time"
                    />

                    <flux:input
                        label="End Time"
                        type="time"
                        wire:model="form.end_time"
                    />
                </div>

                <flux:input
                    label="Classroom"
                    placeholder="Contoh: Ruang 102"
                    wire:model="form.classroom"
                />

                <flux:input
                    label="Teacher Name"
                    placeholder="Contoh: Ahmad Subarjo, S.Pd"
                    wire:model="form.teacher_name"
                />
            </div>

            <div 
                wire:show="$dirty"
                class="text-red-500 dark:text-red-400 text-xs font-medium"
            >
                You have unsaved changes
            </div>
    
            {{-- Footer --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Update</flux:button>
            </div>
        </form>
    </flux:modal>

    
    {{-- DELETE MODAL --}}
    <flux:modal 
        name="delete-schedule" 
        class="md:w-150" 
        x-on:close="$wire.resetForm()" 
    >
        <form class="space-y-6" wire:submit.prevent="deleteSchedule">
            {{-- Header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Delete Schedule
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    This action cannot be undone. Are you sure you want to delete this class schedule?
                </flux:text>
            </div>

            {{-- Footer --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="danger" type="submit">Delete</flux:button>
            </div>
        </form>
    </flux:modal>
</div>