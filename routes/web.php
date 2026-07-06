<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\NilaiController;

// ─── Dashboard ───────────────────────────────────────────────
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// ─── Modul Kelas ─────────────────────────────────────────────
// Menghasilkan 7 route: kelas.index, kelas.create, kelas.store,
//                       kelas.show, kelas.edit, kelas.update, kelas.destroy
Route::resource('kelas', KelasController::class);

// ─── Modul Siswa ─────────────────────────────────────────────
Route::resource('siswa', SiswaController::class);

// ─── Modul Nilai ─────────────────────────────────────────────
Route::resource('nilai', NilaiController::class);
