<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Teacher;
use Illuminate\Validation\Rule;

class TeacherForm extends Form
{
    public ?int $teacher_id = null;

    public string $name = '';
    public string $subject = '';
    public string $email = '';

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('teachers', 'name')->ignore($this->teacher_id, 'teacher_id'),
            ],
            'subject' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('teachers', 'email')->ignore($this->teacher_id, 'teacher_id'),
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
        $this->teacher_id = $teacher->teacher_id;
        $this->name = $teacher->name;
        $this->subject = $teacher->subject;
        $this->email = $teacher->email;
    }

    public function update()
    {
        // 2. Ubah juga di sini agar saat edit/update, email tetap tersimpan huruf kecil
        $this->email = strtolower($this->email);

        $this->validate();

        $teacher = Teacher::findOrFail($this->teacher_id);
        $teacher->update($this->only(['name', 'subject', 'email']));
    }

    public function destroy()
    {
        if ($this->teacher_id) {
            Teacher::findOrFail($this->teacher_id)->delete();
            $this->reset(); // Bersihkan isi form setelah dihapus
        }
    }
}