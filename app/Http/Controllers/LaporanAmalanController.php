<?php

namespace App\Http\Controllers;

use App\Models\LaporanAmalan; // WAJIB ADA
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanAmalanController extends Controller
{
    /**
     * Menampilkan formulir untuk membuat laporan amalan baru.
     */
    public function create()
    {
        // Pastikan hanya Anggota yang bisa melihat form
        if (!Auth::user()->hasRole('Anggota')) {
             return redirect('/dashboard')->with('error', 'Anda tidak diizinkan mengakses halaman ini.');
        }

        // Kembali ke view form input
        return view('laporan.create'); 
    }

    /**
     * Menyimpan laporan amalan yang baru dibuat ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Data
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'sholat_subuh_berjamaah' => 'required|boolean',
            'tilawah' => 'required|integer|min:0',
            // Tambahkan validasi untuk semua field amalan Anda di sini
        ]);
        
        // 2. Simpan ke Database
        $laporan = LaporanAmalan::create([
            'user_id' => Auth::id(), // ID Anggota yang sedang login
            'upa_id' => Auth::user()->upa_id, // Ambil UPA ID dari user yang login
            'tanggal' => $validatedData['tanggal'],
            'sholat_subuh_berjamaah' => $validatedData['sholat_subuh_berjamaah'],
            'tilawah' => $validatedData['tilawah'],
            'status' => 'PENDING', // Status awal laporan
        ]);

        // 3. Redirect ke Halaman Berikutnya (Misal: Riwayat Laporan atau Dashboard)
        // Kita akan redirect ke dashboard dulu, lalu nanti kita buat halaman riwayatnya
        return redirect()->route('dashboard')->with('success', 'Laporan amalan berhasil dikirim dan menunggu verifikasi.');
        
        // Catatan: Jika Anda ingin redirect ke riwayat (yang belum dibuat), gunakan:
        // return redirect()->route('laporan-amalan.riwayat')->with('success', 'Laporan amalan berhasil dikirim.');
    }

    // ... Anda bisa menambahkan metode 'riwayat' di sini nanti
}