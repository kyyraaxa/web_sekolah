<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Attendance;
use Illuminate\Validation\Rule;

class AttendanceForm extends Form
{
    public ?int $attendance_id = null;
    public ?int $student_id = null;
    public string $status = '';
    public string $attendance_date = '';

    public function rules(): array
    {
        return [
            'student_id' => [
                'required',
                'integer',
                // Memastikan siswa ini tidak absen ganda di tanggal yang sama (opsional tapi disarankan)
                Rule::unique('attendances', 'student_id')
                    ->where('attendance_date', $this->attendance_date)
                    ->ignore($this->attendance_id, 'attendance_id'),
            ],
            'status' => [
                'required',
                'string',
                'in:Hadir,Sakit,Izin,Alpa', // Batasi pilihan sesuai status absensi
            ],
            'attendance_date' => [
                'required',
                'date',
            ],
        ];
    }

    public function store()
    {
        // Set tanggal hari ini secara otomatis jika user lupa mengisi di form
        if (empty($this->attendance_date)) {
            $this->attendance_date = date('Y-m-d');
        }

        $this->validate();

        Attendance::create($this->only(['student_id', 'status', 'attendance_date']));
        
        $this->reset();
        $this->attendance_date = date('Y-m-d', strtotime($this->attendance_date)); // Set ulang tanggal ke hari ini setelah reset
    }

    public function setAttendance(Attendance $attendance): void
    {
        $this->attendance_id   = $attendance->attendance_id;
        $this->student_id      = $attendance->student_id;
        $this->status          = $attendance->status;
        $this->attendance_date = $attendance->attendance_date; 
    }

    public function update()
    {
        $this->validate();

        $attendance = Attendance::findOrFail($this->attendance_id);
        $attendance->update($this->only(['student_id', 'status', 'attendance_date']));
    }

    public function destroy()
    {
        if ($this->attendance_id) {
            Attendance::findOrFail($this->attendance_id)->delete();
            $this->reset(); 
            $this->attendance_date = date('Y-m-d'); // Set ulang tanggal ke hari ini setelah reset
        }
    }
}
