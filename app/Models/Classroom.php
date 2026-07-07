<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classroom extends Model
{
    // Beritahu Laravel bahwa primary key-nya bukan 'id'
    protected $primaryKey = 'classroom_id';

    protected $fillable = ['name', 'description'];

    public function scheduleDetails(): HasMany
    {
        return $this->hasMany(ScheduleDetail::class, 'classroom_id', 'classroom_id');
    }
}