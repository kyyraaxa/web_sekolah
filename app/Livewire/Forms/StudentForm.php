<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Student;
use Illuminate\Validation\Rule;

class StudentForm extends Form
{
    public string $name = '';
    public string $class = '';
    public string $email = '';
    public ?Student $student = null;

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('students', 'name')->ignore($this->student?->id),
            ],
            'class' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('students', 'email')->ignore($this->student?->id),
            ],
        ];
    }

    public function store()
    {
        // 1. Ubah email menjadi huruf kecil sebelum divalidasi dan disimpan
        $this->email = strtolower($this->email);
        
        $this->validate();
        Student::create($this->only(['name', 'class', 'email']));
        $this->reset();
    }

    public function setStudent(Student $student): void
    {
        $this->student = $student;
        $this->name = $student->name;
        $this->class = $student->class;
        $this->email = $student->email;
    }

    // update
    public function update()
    {
        // 2. Ubah juga di sini agar saat edit/update, email tetap tersimpan huruf kecil
        $this->email = strtolower($this->email);

        $this->validate();
        $this->student->update($this->only(['name', 'class', 'email']));
    }
}