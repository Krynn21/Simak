<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\JadwalPelajaranController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\ProfileController;
use App\Exports\AbsenExport;
use Maatwebsite\Excel\Facades\Excel;

// ==========================
// Public Routes
// ==========================
Route::get('/', function () {
    return view('login');
});

Route::view('/about', 'about');
Route::view('/kelas', 'kelas', ['title' => 'Kelas']);

// ==========================
// Auth Routes
// ==========================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==========================
// Dashboard (Authenticated)
// ==========================
Route::get('/dashboard', [AuthController::class, 'index'])->middleware('auth');

// ==========================
// Role: Admin Only
// ==========================
Route::middleware(['auth',RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/admin/dashboard', [AuthController::class, 'index']);
    Route::post('/admin/absen/buka', [AuthController::class, 'bukaAbsen']);
    Route::post('/admin/absen-sesi', [AbsenController::class, 'store']);
    Route::post('/admin/absen-sesi/{id}/tutup', [AbsenController::class, 'tutup']);
});

// ==========================
// Role: Semua Authenticated User
// ==========================
Route::middleware(['auth'])->group(function () {
    // Pengguna mengisi absen
    Route::post('/pengguna/absen/isi', [PenggunaController::class, 'isiAbsen'])->name('pengguna.absen.isi');

    // Halaman absen untuk semua user
    Route::get('/absen', [AbsenController::class, 'index']);

    // Admin mengisi absen (?)
    Route::post('/admin/isi-absen', [AbsenController::class, 'submit']);

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

});

Route::get('/export-absen', function () {
    return Excel::download(new AbsenExport, 'rekap_absen.xlsx');
});

// ==========================
// Role: Guru Only (jika middleware guru tersedia)
// ==========================
Route::get('/absen/form', [AbsenController::class, 'form'])->middleware(['auth', 'guru'])->name('absen.form');

// ==========================
// Resource Controllers
// ==========================
Route::resource('pengguna', PenggunaController::class)->middleware('auth');
Route::resource('auth', AuthController::class)->middleware('auth');
Route::resource('kelas', KelasController::class)->middleware('auth');
Route::resource('mapel', MapelController::class)->middleware('auth');
Route::resource('absen', AbsenController::class)->middleware('auth');
Route::resource('jadwal', JadwalPelajaranController::class)->middleware('auth');
