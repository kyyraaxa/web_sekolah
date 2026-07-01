<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    // Beritahu Laravel bahwa primary key tabel ini bukan 'id' tapi 'student_id'
    protected $primaryKey = 'student_id';
    
    protected $fillable=[
        'name',
        'class',
        'email',
    ];

    public function attendances(): HasMany
    {
        // Parameter ke-2: nama foreign key di tabel attendance
        // Parameter ke-3: nama primary key di tabel student
        return $this->hasMany(Attendance::class, 'student_id', 'student_id');
    }
}
