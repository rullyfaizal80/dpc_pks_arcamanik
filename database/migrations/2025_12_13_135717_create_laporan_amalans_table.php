<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // database/migrations/xxxx_create_laporan_amalans_table.php

public function up(): void
{
    Schema::create('laporan_amalans', function (Blueprint $table) {
        $table->id();
        
        // --- DATA IDENTITAS & RELASI ---
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

        // PENTING: ID Pembina/UPA (WAJIB untuk scoping data)
        $table->unsignedBigInteger('upa_id')->nullable(); 
        $table->foreign('upa_id')->references('id')->on('users')->onDelete('set null'); 

        // Data Pelaporan
        $table->date('tanggal_upa'); // Tanggal UPA (Wajib dari form)
        $table->date('periode_awal');
        $table->date('periode_akhir');
        $table->string('jenjang'); // Muda / Pratama [cite: 13, 14]

        // --- 9 POIN AMALAN HARIAN ---
        $table->smallInteger('amal_1_sholat_berjamaah')->nullable(); // Maks 35 [cite: 111]
        $table->smallInteger('amal_2_sholat_malam')->nullable(); // Maks 7 [cite: 128]
        $table->decimal('amal_3_baca_quran', 4, 2)->nullable(); // Misal: 0.5, 1.00 [cite: 129]
        $table->smallInteger('amal_4_shaum_sunnah')->nullable(); // Maks 7 [cite: 155]
        $table->smallInteger('amal_5_almatsurat')->nullable(); // Maks 14 [cite: 158]
        $table->smallInteger('amal_6_sholat_dhuha')->nullable(); // Maks 7 [cite: 175]
        $table->smallInteger('amal_7_olahraga')->nullable(); // Maks 7 [cite: 190]
        $table->smallInteger('amal_8_istighfar')->nullable(); // Maks 7 [cite: 191]
        $table->smallInteger('amal_9_shalawat')->nullable(); // Maks 7 [cite: 209]

        // --- STATUS & VERIFIKASI ---
        $table->string('status')->default('PENDING'); // PENDING, APPROVED
        
        // Kolom Verifikasi (WAJIB nullable)
        $table->date('tanggal_verifikasi')->nullable(); 
        $table->unsignedBigInteger('verifikasi_oleh')->nullable(); 
        $table->foreign('verifikasi_oleh')->references('id')->on('users')->onDelete('set null');

        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('laporan_amalans');
    }
};