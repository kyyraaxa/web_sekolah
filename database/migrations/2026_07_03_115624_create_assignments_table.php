<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id('assignment_id'); // Primary Key Kustom
            $table->string('title'); // Judul Tugas
            $table->string('subject'); // Mata Pelajaran
            $table->text('description')->nullable(); // Deskripsi / Instruksi Tugas
            $table->dateTime('due_date'); // Batas Waktu Pengumpulan (Deadline)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};