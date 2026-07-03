<?php

use Illuminate\Support\Facades\Route;


Route::view('/', 'welcome')->name('home');

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
