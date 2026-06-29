<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Teacher;
use Illuminate\Validation\Rule;

class TeacherForm extends Form
{
    public string $name = '';
    public string $subject = '';
    public string $email = '';
    public ?Teacher $teacher = null;

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('teachers', 'name')->ignore($this->teacher?->id),
            ],
            'subject' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('teachers', 'email')->ignore($this->teacher?->id),
            ],
        ];
    }

    public function store()
    {
        // 1. Ubah email menjadi huruf kecil sebelum divalidasi dan disimpan
        $this->email = strtolower($this->email);

        $this->validate();
        Teacher::create($this->only(['name', 'subject', 'email']));
        $this->reset();
    }

    public function setTeacher(Teacher $teacher): void
    {
        $this->teacher = $teacher;
        $this->name = $teacher->name;
        $this->subject = $teacher->subject;
        $this->email = $teacher->email;
    }

    // update
    public function update()
    {
        // 2. Ubah juga di sini agar saat edit/update, email tetap tersimpan huruf kecil
        $this->email = strtolower($this->email);
        
        $this->validate();
        $this->teacher->update($this->only(['name', 'subject', 'email']));
    }
}