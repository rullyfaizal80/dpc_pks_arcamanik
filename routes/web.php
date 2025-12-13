<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController; // Tambahkan Import
use App\Http\Controllers\LaporanAmalanController; // Tambahkan Import
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // Jika sudah login, arahkan ke dashboard. Jika belum, arahkan ke login.
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return redirect()->route('login');
});

// --- ROUTE DASHBOARD LAMA DIBUANG ATAU DIKOMENTARI ---
/* Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
*/
// -----------------------------------------------------


// --- ROUTE GROUP UTAMA (MEMBUTUHKAN OTENTIKASI) ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    // 1. DASHBOARD BARU BERDASARKAN PERAN (Penting: tetap menggunakan nama 'dashboard')
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. ROUTE LAPORAN AMALAN (Hanya untuk Anggota)
    Route::middleware(['role:Anggota'])->prefix('laporan-amalan')->group(function () {
        Route::get('/create', [LaporanAmalanController::class, 'create'])->name('laporan.create');
        Route::post('/', [LaporanAmalanController::class, 'store'])->name('laporan.store');
        Route::get('/riwayat', [LaporanAmalanController::class, 'index'])->name('laporan.riwayat');
    });

    // 3. ROUTE MONITORING (Untuk Pembina, Sek DPC, Ketua DPC)
    // Catatan: Jika Anda belum membuat middleware 'role', Anda bisa menggunakan array biasa dulu
    Route::middleware(['role:Pembina|Sekretaris DPC|Ketua DPC'])->prefix('monitoring')->group(function () {
        Route::get('/laporan', [DashboardController::class, 'laporanMonitoring'])->name('monitoring.laporan');
    });

    // Route Profile Bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php'; 
