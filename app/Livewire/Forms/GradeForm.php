<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Grade;
use Illuminate\Validation\Rule;

class GradeForm extends Form
{
    public ?int $grade_id = null;

    #[Validate('required|integer|exists:students,student_id')]
    public ?int $student_id = null;
    public string $subject = '';
    public ?int $score = null;

    public function rules(): array
    {
        return [
            'student_id' => [
                'required',
                'integer',
                'exists:students,student_id', // Memastikan ID siswa terdaftar di tabel students
            ],
            'subject' => [
                'required',
                'string',
                'max:255',
            ],
            'score' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],
        ];
    }

    /**
     * Logika otomatis menentukan Grade Huruf berdasarkan Skor Nilai
     */
    public function calculateGradeLetter(int $score): string
    {
        if ($score >= 85) return 'A';
        if ($score >= 75) return 'B';
        if ($score >= 60) return 'C';
        if ($score >= 50) return 'D';
        return 'E';
    }

    public function store()
    {
        $this->validate();

        Grade::create([
            'student_id'   => $this->student_id,
            'subject'      => $this->subject,
            'score'        => $this->score,
            'grade_letter' => $this->calculateGradeLetter($this->score), // Otomatis terisi
        ]);

        $this->reset();
    }

    public function setGrade(Grade $grade): void
    {
        $this->grade_id   = $grade->grade_id;
        $this->student_id = $grade->student_id;
        $this->subject    = $grade->subject;
        $this->score      = $grade->score;
    }

    public function update()
    {
        $this->validate();

        $grade = Grade::findOrFail($this->grade_id);
        
        $grade->update([
            'student_id'   => $this->student_id,
            'subject'      => $this->subject,
            'score'        => $this->score,
            'grade_letter' => $this->calculateGradeLetter($this->score), // Ikut dihitung ulang jika nilai berubah
        ]);
    }

    public function destroy()
    {
        if ($this->grade_id) {
            Grade::findOrFail($this->grade_id)->delete();
            $this->reset(); // Bersihkan isi form setelah data dihapus
        }
    }
}