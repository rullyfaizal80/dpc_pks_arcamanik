<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_amalans', function (Blueprint $table) {
            $table->id();
            // Relasi ke Anggota yang melapor
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Data Identitas & Periode
            $table->date('tanggal_upa');
            $table->date('periode_awal'); // Senin
            $table->date('periode_akhir'); // Ahad
            $table->string('jenjang'); // Muda / Pratama

            // 9 Poin Amalan (Menggunakan smallInteger untuk hitungan 0-35)
            $table->smallInteger('amal_1_sholat_berjamaah')->nullable(); // Maks 35
            $table->smallInteger('amal_2_sholat_malam')->nullable(); // Maks 7
            $table->decimal('amal_3_baca_quran', 4, 2)->nullable(); // Misal: 0.5 (kurang dari 1 juz), 1.00, 2.25
            $table->smallInteger('amal_4_shaum_sunnah')->nullable(); // Maks 7
            $table->smallInteger('amal_5_almatsurat')->nullable(); // Maks 14 (2x/hari)
            $table->smallInteger('amal_6_sholat_dhuha')->nullable(); // Maks 7
            $table->smallInteger('amal_7_olahraga')->nullable(); // Maks 7
            $table->smallInteger('amal_8_istighfar')->nullable(); // Maks 7
            $table->smallInteger('amal_9_shalawat')->nullable(); // Maks 7

            $table->string('status')->default('PENDING'); // PENDING, APPROVED
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_amalans');
    }
};