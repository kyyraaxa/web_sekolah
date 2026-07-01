<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    // Beritahu Laravel bahwa primary key tabel ini bukan 'id' tapi 'student_id'
    protected $primaryKey = 'student_id';
    
    protected $fillable=[
        'name',
        'class',
        'email',
    ];
}
