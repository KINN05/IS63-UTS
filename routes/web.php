<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Dashboard (sementara, tanpa middleware auth — akan ditambah di Bab 7)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Route untuk modul lain akan ditambahkan di Bab 5
// Route::resource('kelas', KelasController::class);
// Route::resource('siswa', SiswaController::class);
// Route::resource('nilai', NilaiController::class);
