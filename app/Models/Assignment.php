<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $primaryKey = 'assignment_id';

    protected $fillable = [
        'title',
        'subject',
        'description',
        'due_date',
    ];

    // Opsional: Cast due_date otomatis menjadi Carbon instance agar mudah diformat di Blade
    protected $casts = [
        'due_date' => 'datetime',
    ];
}