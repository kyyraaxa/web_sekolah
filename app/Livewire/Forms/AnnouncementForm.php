<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Announcement;
use Illuminate\Validation\Rule;

class AnnouncementForm extends Form
{
    public ?int $announcement_id = null;

    public string $title = '';
    public string $content = '';
    public string $target = 'All';

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'content' => ['required', 'string'],
            'target' => ['required', 'string', 'in:All,Teachers,Students'],
        ];
    }

    public function store()
    {
        $this->validate();

        Announcement::create($this->only(['title', 'content', 'target']));
        $this->reset();
    }

    public function setAnnouncement(Announcement $announcement): void
    {
        $this->announcement_id = $announcement->announcement_id;
        $this->title           = $announcement->title;
        $this->content         = $announcement->content;
        $this->target          = $announcement->target;
    }

    public function update()
    {
        $this->validate();

        $announcement = Announcement::findOrFail($this->announcement_id);
        $announcement->update($this->only(['title', 'content', 'target']));
    }

    public function destroy()
    {
        if ($this->announcement_id) {
            Announcement::findOrFail($this->announcement_id)->delete();
            $this->reset();
        }
    }
}