<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\SurveyWizard;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Route khusus ke wizard survey Fine-Kinney
    Route::get('/survey', SurveyWizard::class)->name('survey');
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
