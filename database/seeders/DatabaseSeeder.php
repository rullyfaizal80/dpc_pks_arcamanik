<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // Menggunakan trait ini adalah cara yang baik untuk memastikan model events tidak terpicu saat seeding
    use WithoutModelEvents; 

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Pilihan: Anda bisa menghapus atau mengomentari User::factory() bawaan ini 
        // agar data tidak tercampur dengan user kustom yang kita buat di RolesAndUsersSeeder.
        
        // Contoh: Dihapus/Dikomenter:
        // User::factory(10)->create();
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Panggil seeder kustom kita
        $this->call(RolesAndUsersSeeder::class);
    }
}