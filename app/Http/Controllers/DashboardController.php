<?php

namespace App\Http\Controllers;

use App\Models\LaporanAmalan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard Utama berdasarkan Peran.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Anggota')) {
            return redirect()->route('laporan-amalan.create'); // Arahkan Anggota langsung ke Form Laporan
        }

        // Jika Pembina, Sek DPC, atau Ketua DPC, tampilkan dashboard monitoring
        return $this->laporanMonitoring();
    }

    /**
     * Menampilkan Laporan Amalan yang telah difilter (Scoped).
     */
    public function laporanMonitoring()
    {
        $user = auth()->user();
        $query = LaporanAmalan::with('user'); // Load relasi user

        if ($user->hasRole('Pembina')) {
            // Menggunakan Local Scope yang sudah kita definisikan di Model
            $query->forPembina($user); 
            $title = 'Monitoring Laporan UPA Anda';
        } elseif ($user->hasRole('Sekretaris DPC') || $user->hasRole('Ketua DPC')) {
            // Sek DPC / Ketua DPC melihat SEMUA laporan
            $title = 'Monitoring Laporan DPC (Global)';
        } else {
            // Kasus Darurat, user tanpa peran
            abort(403, 'Akses tidak diizinkan untuk peran ini.');
        }
        
        // Ambil data yang sudah difilter/scoped
        $laporanAmalan = $query->latest()->paginate(20);

        return view('dashboard.monitoring', compact('laporanAmalan', 'title'));
    }
}