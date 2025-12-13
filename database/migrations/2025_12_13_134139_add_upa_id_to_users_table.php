// File: database/migrations/*_add_upa_id_to_users_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kolom 'upa_id' (Foreign Key)
            $table->foreignId('upa_id')->nullable()->constrained()->after('password');

            // Kolom 'role' (PENTING!)
            $table->string('role')->default('anggota')->after('upa_id'); 

            // Kolom 'no_hp'
            $table->string('no_hp')->nullable();
        });
    }
    // ... (metode down)
};