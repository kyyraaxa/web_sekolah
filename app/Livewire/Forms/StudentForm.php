<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Student;
use Illuminate\Validation\Rule;

class StudentForm extends Form
{
    public ?int $student_id = null;

    public string $name = '';
    public string $class = '';
    public string $email = '';

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('students', 'name')->ignore($this->student_id, 'student_id'),
            ],
            'class' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('students', 'email')->ignore($this->student_id, 'student_id'),
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
        $this->student_id = $student->student_id; // Menyimpan ID siswa ke properti form
        $this->name = $student->name;
        $this->class = $student->class;
        $this->email = $student->email;
    }

    public function update()
    {
        // 2. Ubah juga di sini agar saat edit/update, email tetap tersimpan huruf kecil
        $this->email = strtolower($this->email);

        $this->validate();

        $student = Student::findOrFail($this->student_id);
        $student->update($this->only(['name', 'class', 'email']));
    }

    public function destroy()
    {
        if ($this->student_id) {
            Student::findOrFail($this->student_id)->delete();
            $this->reset(); // Bersihkan isi form setelah dihapus
        }
    }
}