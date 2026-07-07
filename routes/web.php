<?php

use Illuminate\Support\Facades\Route;


Route::view('/', 'welcome')->name('home');

Route::get('/visi-misi', function () {
    return view('visi-misi');
})->name('visi-misi');

Route::get('/profil', function () {
    return view('profil');
})->name('profil');

Route::get('/postingan', function () {
    return view('postingan');
})->name('postingan');

Route::get('/postingan/{id}', function ($id) {
    // Sementara kita arahkan ke satu view detail, nanti data sesungguhnya bisa diambil dari database.
    return view('baca', ['id' => $id]);
})->name('postingan.baca');



Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::livewire('/categories', 'pages::category.index')
        ->name('category.index');
    Route::livewire('/students', 'pages::student.index')
        ->name('student.index');
    Route::livewire('/schedules', 'pages::schedule.index')
        ->name('schedule.index');
    Route::livewire('/assignments', 'pages::assignment.index')
        ->name('assignment.index');
    Route::livewire('/assignments/{id}', 'pages::assignment.show')
        ->name('assignment.show');
    Route::livewire('/teachers', 'pages::teacher.index')
        ->name('teacher.index');
    Route::livewire('/attendances', 'pages::attendance.index')
        ->name('attendance.index');
    Route::livewire('/grades', 'pages::grade.index')
        ->name('grade.index');
    Route::livewire('/payments', 'pages::payment.index')
        ->name('payment.index');
    Route::livewire('/announcements', 'pages::announcement.index')
        ->name('announcement.index');
});

require __DIR__.'/settings.php';
