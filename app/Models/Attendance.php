<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $table = 'attendances';
    protected $primaryKey = 'attendance_id';
    protected $fillable = [
        'student_id',
        'status',
        'attendance_date',
    ];

    public function student(): BelongsTo
    {
        // Parameter ke-2: nama kolom foreign key di tabel attendance
        // Parameter ke-3: nama kolom primary key di tabel student (berdasarkan ERD)
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
}
