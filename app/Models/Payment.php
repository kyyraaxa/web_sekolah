<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $primaryKey = 'payment_id';
    protected $fillable = ['student_id', 'type', 'amount', 'status', 'date'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
}