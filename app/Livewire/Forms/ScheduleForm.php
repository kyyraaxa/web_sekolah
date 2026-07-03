<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Schedule;
use Illuminate\Validation\Rule;

class ScheduleForm extends Form
{
    // Primary key menggunakan schedule_id sesuai database kamu
    public ?int $schedule_id = null;

    public string $day = '';
    public string $subject = '';
    public string $start_time = '';
    public string $end_time = '';
    public string $classroom = '';
    public string $teacher_name = ''; // Menggunakan string nama guru sesuai migration kamu

    public function rules(): array
    {
        return [
            'day' => [
                'required',
                'string',
                Rule::in(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']), // Memastikan hari valid
            ],
            'subject' => [
                'required',
                'string',
                'max:255',
            ],
            'start_time' => [
                'required',
                'date_format:H:i', // Memastikan format jam valid (Contoh: 07:30)
            ],
            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time', // Jam selesai harus setelah jam mulai
            ],
            'classroom' => [
                'required',
                'string',
                'max:50',
            ],
            'teacher_name' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }

    // Fungsi untuk Simpan Data Baru (Create)
    public function store()
    {
        $this->validate();

        Schedule::create($this->only([
            'day', 
            'subject', 
            'start_time', 
            'end_time', 
            'classroom', 
            'teacher_name'
        ]));

        $this->reset(); // Bersihkan form setelah sukses simpan
    }

    // Fungsi untuk Mengisi Form saat Mau Edit (Data Binding)
    public function setSchedule(Schedule $schedule): void
    {
        $this->schedule_id = $schedule->schedule_id;
        $this->day = $schedule->day;
        $this->subject = $schedule->subject;
        
        // Memformat output waktu agar pas saat dibaca komponen input type="time" HTML
        $this->start_time = \Carbon\Carbon::parse($schedule->start_time)->format('H:i');
        $this->end_time = \Carbon\Carbon::parse($schedule->end_time)->format('H:i');
        
        $this->classroom = $schedule->classroom;
        $this->teacher_name = $schedule->teacher_name;
    }

    // Fungsi untuk Mengupdate Data (Edit)
    public function update()
    {
        $this->validate();

        $schedule = Schedule::findOrFail($this->schedule_id);
        $schedule->update($this->only([
            'day', 
            'subject', 
            'start_time', 
            'end_time', 
            'classroom', 
            'teacher_name'
        ]));
    }

    // Fungsi untuk Menghapus Jadwal (Delete)
    public function destroy()
    {
        if ($this->schedule_id) {
            Schedule::findOrFail($this->schedule_id)->delete();
            $this->reset(); // Bersihkan form setelah sukses hapus
        }
    }
}