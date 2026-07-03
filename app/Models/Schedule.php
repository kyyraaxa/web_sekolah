<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    // Beritahu Laravel bahwa primary key tabel ini bukan 'id' tapi 'schedule_id'
    protected $primaryKey = 'schedule_id';

    protected $fillable = [
        'day',
        'subject',
        'start_time',
        'end_time',
        'classroom',
        'teacher_name',
    ];
}