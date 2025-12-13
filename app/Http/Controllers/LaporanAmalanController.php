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
    // 1. Validasi Data: Sesuaikan nama field di sini
    $validatedData = $request->validate([
        'tanggal_upa' => 'required|date',
        'periode_awal' => 'required|date',
        'periode_akhir' => 'required|date|after_or_equal:periode_awal',
        'jenjang' => 'required|string|max:20', 

        'amal_1_sholat_berjamaah' => 'required|integer|min:0|max:35', 
        'amal_2_sholat_malam' => 'required|integer|min:0|max:7',
        'amal_3_baca_quran' => 'required|numeric|min:0', // Menggunakan numeric karena tipe decimal
        'amal_4_shaum_sunnah' => 'required|integer|min:0|max:7', 
        'amal_5_almatsurat' => 'required|integer|min:0|max:14', 
        'amal_6_sholat_dhuha' => 'required|integer|min:0|max:7',
        'amal_7_olahraga' => 'required|integer|min:0|max:7',
        'amal_8_istighfar' => 'required|integer|min:0|max:7',
        'amal_9_shalawat' => 'required|integer|min:0|max:7',
    ]);

    // 2. Simpan ke Database: Sesuaikan nama field di sini
    LaporanAmalan::create([
        'user_id' => Auth::id(), 
        'upa_id' => Auth::user()->upa_id, // Wajib ada di model User

        // Data dari Form (menggunakan nama kolom Migrasi)
        'tanggal_upa' => $validatedData['tanggal_upa'],
        'periode_awal' => $validatedData['periode_awal'],
        'periode_akhir' => $validatedData['periode_akhir'],
        'jenjang' => $validatedData['jenjang'],

        'amal_1_sholat_berjamaah' => $validatedData['amal_1_sholat_berjamaah'],
        'amal_2_sholat_malam' => $validatedData['amal_2_sholat_malam'],
        'amal_3_baca_quran' => $validatedData['amal_3_baca_quran'],
        'amal_4_shaum_sunnah' => $validatedData['amal_4_shaum_sunnah'],
        'amal_5_almatsurat' => $validatedData['amal_5_almatsurat'],
        'amal_6_sholat_dhuha' => $validatedData['amal_6_sholat_dhuha'],
        'amal_7_olahraga' => $validatedData['amal_7_olahraga'],
        'amal_8_istighfar' => $validatedData['amal_8_istighfar'],
        'amal_9_shalawat' => $validatedData['amal_9_shalawat'],

        'status' => 'PENDING', 
    ]);

    return redirect()->route('dashboard')->with('success', 'Laporan amalan berhasil dikirim dan menunggu verifikasi.');
}

        // ... Anda bisa menambahkan metode 'riwayat' di sini nanti
}