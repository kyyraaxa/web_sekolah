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

    // Relasi ke banyak pengumpulan (untuk Admin melihat siapa saja yang kumpul)
    public function submissions()
    {
        return $this->hasMany(Submission::class, 'assignment_id');
    }

    // Mendapatkan submission milik siswa yang sedang login saat ini
    public function userSubmission()
    {
        return $this->hasOne(Submission::class, 'assignment_id')->where('user_id', auth()->id());
    }
}