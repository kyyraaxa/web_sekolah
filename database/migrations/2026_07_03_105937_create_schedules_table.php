<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id('schedule_id'); // ID Jadwal
            $table->string('day'); // Senin, Selasa, dll
            $table->string('subject'); // Mata Pelajaran
            $table->time('start_time'); // Jam Mulai
            $table->time('end_time'); // Jam Selesai
            $table->string('classroom'); // Ruang Kelas
            $table->string('teacher_name'); // Nama Guru
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};