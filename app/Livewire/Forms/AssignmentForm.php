<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Assignment;
use Illuminate\Validation\Rule;

class AssignmentForm extends Form
{
    public ?int $assignment_id = null;

    public string $title = '';
    public string $subject = '';
    public string $description = '';
    public string $due_date = '';

    public function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date|after:now', // Deadline harus waktu yang akan datang
        ];
    }

    public function store()
    {
        $this->validate();

        Assignment::create($this->only(['title', 'subject', 'description', 'due_date']));

        $this->reset();
    }

    public function setAssignment(Assignment $assignment): void
    {
        $this->assignment_id = $assignment->assignment_id;
        $this->title = $assignment->title;
        $this->subject = $assignment->subject;
        $this->description = $assignment->description ?? '';
        // Format datetime agar cocok dibaca input HTML type="datetime-local"
        $this->due_date = $assignment->due_date ? $assignment->due_date->format('Y-m-d\TH:i') : '';
    }

    public function update()
    {
        $this->validate();

        $assignment = Assignment::findOrFail($this->assignment_id);
        $assignment->update($this->only(['title', 'subject', 'description', 'due_date']));
    }

    public function destroy()
    {
        if ($this->assignment_id) {
            Assignment::findOrFail($this->assignment_id)->delete();
            $this->reset();
        }
    }
}