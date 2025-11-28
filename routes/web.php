<?php
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\SiswaPklController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes (Semua user yang sudah login)
Route::middleware('auth')->group(function () {
    Route::get('/', [AbsensiController::class, 'index'])->name('home');

    // Routes untuk Admin dan User (dashboard bisa diakses keduanya)
    Route::prefix('absensi')->name('absensi.')->group(function () {
        Route::get('/riwayat', [AbsensiController::class, 'riwayat'])->name('riwayat');
        Route::get('/laporan', [AbsensiController::class, 'laporan'])->name('laporan');
        
        // Routes untuk Absen (Admin & Siswa bisa akses, tapi dengan logika berbeda)
        Route::post('/masuk', [AbsensiController::class, 'absenMasuk'])->name('masuk');
        Route::post('/pulang', [AbsensiController::class, 'absenPulang'])->name('pulang');
        Route::post('/izin', [AbsensiController::class, 'absenIzin'])->name('izin');
        Route::post('/sakit', [AbsensiController::class, 'absenSakit'])->name('sakit');
        Route::post('/alpa', [AbsensiController::class, 'absenAlpa'])->name('alpa');
    });

    // Routes khusus Admin - Kelola Siswa
    Route::middleware('role:admin')->group(function () {
        Route::resource('siswa', SiswaPklController::class);
    });
});

