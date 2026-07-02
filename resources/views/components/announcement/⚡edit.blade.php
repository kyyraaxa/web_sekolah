<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Announcement;
use App\Livewire\Forms\AnnouncementForm;

new class extends Component
{
    public AnnouncementForm $form;

    #[On('edit-announcement')]
    public function editAnnouncement($id){
        $announcement = Announcement::find($id);
        $this->form->setAnnouncement($announcement);
        Flux::modal('edit-announcement')->show();
    }

    public function updateAnnouncement() {
        $this->form->update();
        Flux::modal('edit-announcement')->close();
        session()->flash('success', 'Announcement updated successfully');
        $this->redirectRoute('announcement.index', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }

    #[On('confirm-delete-announcement')]
    public function confirmDelete($id)
    {
        $announcement = Announcement::find($id);
        $this->form->setAnnouncement($announcement);
        Flux::modal('delete-announcement')->show();
    }

    public function deleteAnnouncement() {
        $this->form->destroy();
        Flux::modal('delete-announcement')->close();
        session()->flash('success', 'Announcement deleted successfully');
        $this->redirectRoute('announcement.index', navigate: true);
    }
};
?>

<div>
    {{-- edit modal --}}
    <flux:modal name="edit-announcement" class="md:w-120" x-on:close="$wire.resetForm()">
        <form class="space-y-8" wire:submit.prevent="updateAnnouncement">
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">Edit Announcement</flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">Modify announcement details below</flux:text>
            </div>

            <div class="space-y-6">
                <flux:input label="Title" wire:model="form.title" />
                
                <flux:textarea label="Content" wire:model="form.content" rows="5" />

                <flux:select label="Target Audience" wire:model="form.target">
                    <flux:select.option value="All">All</flux:select.option>
                    <flux:select.option value="Teachers">Teachers</flux:select.option>
                    <flux:select.option value="Students">Students</flux:select.option>
                </flux:select>
            </div>

            <div wire:show="$dirty" class="text-red-500 dark:text-red-400">you have unsaved changes</div>
    
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Cancel</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Update</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- delete modal --}}
    <flux:modal name="delete-announcement" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-8" wire:submit.prevent="deleteAnnouncement">
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">Delete Announcement</flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">this action cannot be undone</flux:text>
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