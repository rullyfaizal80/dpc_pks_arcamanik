<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('upas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelompok');
            $table->enum('jenjang', ['Muda', 'Pratama']);
            // Kolom untuk menghubungkan Pembina (User) ke UPA
            // diasumsikan Pembina adalah User, jadi kita pakai user_id
            $table->foreignId('pembina_id')->nullable()->constrained('users'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upas');
    }
};