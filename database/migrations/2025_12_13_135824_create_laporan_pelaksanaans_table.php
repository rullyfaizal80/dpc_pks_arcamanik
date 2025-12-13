<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_pelaksanaans', function (Blueprint $table) {
            $table->id();
            // Relasi ke User yang mengisi (Sekretaris UPA/Pembina)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Data Pelaksanaan
            $table->foreignId('upa_id')->constrained('upas')->onDelete('cascade'); // UPA mana yang dilaporkan
            $table->date('tanggal_pelaksanaan');
            $table->string('nama_sekretaris');
            $table->string('nama_pembimbing');
            $table->enum('teknis_pelaksanaan', ['OFFLINE', 'ONLINE', 'HYBRID']);
            $table->boolean('kehadiran_pembina')->default(false); // 0 atau 1
            $table->integer('total_anggota');
            $table->integer('jumlah_hadir');
            $table->text('anggota_tidak_hadir')->nullable();
            $table->text('materi_disampaikan');

            $table->string('status')->default('PENDING');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_pelaksanaans');
    }
};