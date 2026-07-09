<?php
// routes/web.php — VERSI FINAL

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\NilaiController;

// ============================================================
// ROUTE TAMU (Guest)
// Hanya bisa diakses jika BELUM login.
// Jika user yang sudah login mencoba akses /login,
// Laravel otomatis redirect ke dashboard.
// ============================================================
Route::middleware('guest')->group(function () {
    Route::get('/login',  [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});

// ============================================================
// ROUTE TERLINDUNGI (Auth)
// Hanya bisa diakses jika SUDAH login.
// Jika belum login, otomatis redirect ke /login.
// ============================================================
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Modul Kelas — 7 route: kelas.index s/d kelas.destroy
    Route::resource('kelas', KelasController::class);

    // Modul Siswa — 7 route: siswa.index s/d siswa.destroy
    Route::resource('siswa', SiswaController::class);

    // Modul Nilai — 7 route: nilai.index s/d nilai.destroy
    Route::resource('nilai', NilaiController::class);
});
