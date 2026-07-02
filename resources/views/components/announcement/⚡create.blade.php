<?php

use Livewire\Component;
use App\Livewire\Forms\AnnouncementForm;

new class extends Component
{
    public AnnouncementForm $form;
    
    public function save()
    {
        $this->form->store();
        Flux::modal('create-announcement')->close();

        session()->flash('success', 'Announcement created successfully');
        $this->redirectRoute('announcement.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }
};
?>

<div>
    <flux:modal name="create-announcement" class="md:w-120" x-on:close="$wire.resetForm()">
        <form class="space-y-8" wire:submit.prevent="save">
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">Create Announcement</flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">Publish a new announcement bulletin</flux:text>
            </div>

            <div class="space-y-6">
                <flux:input
                    label="Title"
                    placeholder="e.g., School Holiday Notice"
                    wire:model="form.title"
                />

                <flux:textarea
                    label="Content"
                    placeholder="Write the announcement details here..."
                    wire:model="form.content"
                    rows="5"
                />

                <flux:select label="Target Audience" wire:model="form.target">
                    <flux:select.option value="All">All (Semua)</flux:select.option>
                    <flux:select.option value="Teachers">Teachers (Guru)</flux:select.option>
                    <flux:select.option value="Students">Students (Siswa)</flux:select.option>
                </flux:select>
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