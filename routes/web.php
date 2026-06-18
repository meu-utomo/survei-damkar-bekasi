<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\SurveyWizard;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Halaman Depan Publik (Sebelum Login/Registrasi)
Route::get('/', function () {
    return view('welcome');
});

// 2. Grup Rute yang Dilindungi Autentikasi (Breeze Auth)
Route::middleware(['auth', 'verified'])->group(function () {

    // Halaman Dashboard Utama (Menampilkan Pengantar Kuesioner)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Portal Kuesioner Dinamis (Fine-Kinney Wizard)
    Route::get('/survey', SurveyWizard::class)->name('survey');
});
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
