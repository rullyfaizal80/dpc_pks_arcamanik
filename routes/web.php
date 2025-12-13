<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LaporanAmalanController; // WAJIB ADA

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// --- ROUTE GUEST (PENGGUNA BELUM LOGIN) ---
Route::get('/', function () {
    // Redirect ke halaman login jika belum login
    return redirect()->route('login');
});

// --- ROUTE KHUSUS PENGGUNA TEROTENTIKASI (SETELAH LOGIN) ---
Route::middleware('auth')->group(function () {
    
    // DASHBOARD UTAMA (Role based logic ada di DashboardController)
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['verified'])->name('dashboard');

    // ROUTE Laporan Amalan KHUSUS UNTUK ANGGOTA
    Route::middleware('role:Anggota')->group(function () {
        // Tampilkan Form Input
        Route::get('/laporan-amalan/create', [LaporanAmalanController::class, 'create'])
            ->name('laporan-amalan.create');

        // Proses Penyimpanan Data Form
        Route::post('/laporan-amalan', [LaporanAmalanController::class, 'store'])
            ->name('laporan-amalan.store');
        
        // Route untuk Riwayat Laporan (Opsional, akan kita buat nanti)
        // Route::get('/laporan-amalan/riwayat', [LaporanAmalanController::class, 'riwayat'])
        //     ->name('laporan-amalan.riwayat');
    });


    // ROUTE KHUSUS PEMBINA (atau peran lain yang melihat laporan)
    Route::middleware('role:Pembina|Ketua DPC')->group(function () {
        // Tampilkan Dashboard Monitoring (MonitoringController@index)
        // Sudah dicakup oleh DashboardController
    });


    // ROUTE PROFILE BAWAAN BREEZE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// INI WAJIB ADA (route Login, Logout, Register)
require __DIR__.'/auth.php';