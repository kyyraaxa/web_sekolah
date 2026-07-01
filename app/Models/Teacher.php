<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    // Beritahu Laravel bahwa primary key tabel ini bukan 'id' tapi 'teacher_id'
    protected $primaryKey = 'teacher_id';
    
    protected $fillable = [
        'name',
        'subject',
        'email',
    ];
}
