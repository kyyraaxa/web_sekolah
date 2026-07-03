<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use App\Models\Announcement;

new class extends Component
{
    use WithPagination;
    
    #[Computed]
    public function announcements()
    {
        return Announcement::latest()->paginate(10);
    }

    public function edit($id){
        $this->dispatch('edit-announcement', id: $id);
    }
};
?>

<div class="max-w-7xl mx-auto space-y-4">
    <flux:heading size="xl" class="text-zinc-800 dark:text-white">Announcements</flux:heading>
    <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">Manage school announcements</flux:subheading>
    <flux:separator variant="subtle" />
    
    <flux:modal.trigger name="create-announcement">
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'teacher')
        <flux:button variant="primary" icon="plus" color="primary">Add Announcement</flux:button>
        @endif
    </flux:modal.trigger>

    <livewire:announcement.create />
    <livewire:announcement.edit />
    <x-flash-message />

    {{-- table --}}
    <div class="overflow-x-auto">
       <flux:table :paginate="$this->announcements">
            <flux:table.columns>
                <flux:table.column>No</flux:table.column>
                <flux:table.column>Title</flux:table.column>
                <flux:table.column>Content</flux:table.column>
                <flux:table.column>Target Audience</flux:table.column>
                <flux:table.column>Created At</flux:table.column>
                <flux:table.column>Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->announcements as $announcement)
                    <flux:table.row :key="$announcement->announcement_id">

                        <flux:table.cell>
                            {{ $loop->iteration + ($this->announcements->firstItem() - 1) }}
                        </flux:table.cell>

                        <flux:table.cell class="font-medium text-zinc-800 dark:text-white">
                            {{ $announcement->title }}
                        </flux:table.cell>

                        <flux:table.cell class="text-zinc-500 dark:text-zinc-400 max-w-xs truncate">
                            {{ $announcement->content }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <span class="font-bold px-2 py-0.5 rounded text-xs
                                {{ $announcement->target === 'All' ? 'text-blue-600 bg-blue-50 dark:bg-blue-950/30' : '' }}
                                {{ $announcement->target === 'Teachers' ? 'text-purple-600 bg-purple-50 dark:bg-purple-950/30' : '' }}
                                {{ $announcement->target === 'Students' ? 'text-yellow-600 bg-yellow-50 dark:bg-yellow-950/30' : '' }}">
                                {{ $announcement->target }}
                            </span>
                        </flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap">
                            {{ $announcement->created_at->diffForHumans() }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                <flux:menu>
                                    <flux:menu.item icon="pencil" wire:click="edit({{ $announcement->announcement_id }})">Edit</flux:menu.item>
                                    <flux:menu.separator />
                                    
                                    {{-- <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete', id: $announcement->announcement_id)">Delete</flux:menu.item> --}}
                                    <flux:menu.item variant="danger" icon="trash" wire:click="$dispatch('confirm-delete-announcement', {id: {{ $announcement->announcement_id }}})">Delete</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>