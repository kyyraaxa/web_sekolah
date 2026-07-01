<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $primaryKey = 'grade_id';
    protected $fillable = ['student_id', 'subject', 'score', 'grade_letter'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
}