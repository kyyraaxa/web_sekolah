<?php

use Livewire\Component;
use App\Livewire\Forms\ScheduleForm;

new class extends Component
{
    // Gunakan instance class ScheduleForm yang baru dibuat
    public ScheduleForm $form;
    
    public function save()
    {
        $this->form->store();
        Flux::modal('create-schedule')->close();

        // Notifikasi session sukses
        session()->flash('success', 'Schedule created successfully');

        // Redirect kembali ke index jadwal pelajaran milik guru
        $this->redirectRoute('schedule.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }
};
?>

<div>
    {{-- Nama modal disesuaikan menjadi create-schedule --}}
    <flux:modal name="create-schedule" class="md:w-96" x-on:close="$wire.resetForm()">
        <form class="space-y-6" wire:submit.prevent="save">
            
            {{-- Header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Create Schedule
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Add a new class learning schedule harian
                </flux:text>
            </div>

            {{-- Form Fields khusus Schedule --}}
            <div class="space-y-4">
                
                {{-- Input Hari menggunakan Flux Select --}}
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

                {{-- Jam Input (Mulai & Selesai menyamping) --}}
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
                    placeholder="Contoh: Ruang 102 / Lab Fisika"
                    wire:model="form.classroom"
                />

                <flux:input
                    label="Teacher Name"
                    placeholder="Contoh: Ahmad Subarjo, S.Pd"
                    wire:model="form.teacher_name"
                />
            </div>
    
            {{-- Footer --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Create</flux:button>
            </div>

        </form>
    </flux:modal>
</div>