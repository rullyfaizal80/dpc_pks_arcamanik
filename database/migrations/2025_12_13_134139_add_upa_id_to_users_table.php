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
        Schema::table('users', function (Blueprint $table) {
            // Foreign Key ke tabel 'upas'. Bisa NULL jika user adalah Ketua DPC/Admin
            $table->foreignId('upa_id')->nullable()->constrained()->after('password');
            
            // Kolom Role/Peran (opsional jika menggunakan Spatie Permission)
            // Jika tidak menggunakan Spatie, kolom ini wajib ada:
            $table->string('role')->default('anggota')->after('upa_id'); 
            
            // Kolom identitas tambahan
            $table->string('no_hp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus foreign key dan kolom ketika rollback
            $table->dropForeign(['upa_id']);
            $table->dropColumn(['upa_id', 'role', 'no_hp']);
        });
    }
};