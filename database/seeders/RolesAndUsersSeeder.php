<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Upa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RolesAndUsersSeeder extends Seeder
{
    public function run(): void
    {
        // 1. BUAT ROLES (Peran)
        $adminRole = Role::firstOrCreate(['name' => 'Ketua DPC']);
        $pembinaRole = Role::firstOrCreate(['name' => 'Pembina']);
        $sekretarisRole = Role::firstOrCreate(['name' => 'Sekretaris DPC']);
        $anggotaRole = Role::firstOrCreate(['name' => 'Anggota']);

        // 2. BUAT USER ADMIN (Super User)
        $admin = User::firstOrCreate(
            ['email' => 'admin@dpc.test'],
            [
                'name' => 'Ketua DPC (Admin)',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'admin' // role untuk kolom 'role' di tabel users
            ]
        );
        $admin->assignRole($adminRole); // Tetapkan peran Spatie

        // 3. BUAT DATA UPA dan PEMBINA

        // Pembina 1 (Contoh: Budi)
        $pembina1 = User::firstOrCreate(
            ['email' => 'budi@pks.test'],
            [
                'name' => 'Budi Pembina UPA A',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'pembina'
            ]
        );
        $pembina1->assignRole($pembinaRole);

        // Buat UPA A, dengan Pembina Budi
        $upaA = Upa::firstOrCreate(
            ['nama_kelompok' => 'UPA A - Pratama'],
            [
                'jenjang' => 'Pratama',
                'pembina_id' => $pembina1->id,
            ]
        );

        // Anggota 1 (Terhubung ke UPA A)
        $anggota1 = User::firstOrCreate(
            ['email' => 'a1@pks.test'],
            [
                'name' => 'Anggota 1 UPA A',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'anggota',
                'upa_id' => $upaA->id, // RELASI PENTING
            ]
        );
        $anggota1->assignRole($anggotaRole);

        // Anggota 2 (Terhubung ke UPA A)
        $anggota2 = User::firstOrCreate(
            ['email' => 'a2@pks.test'],
            [
                'name' => 'Anggota 2 UPA A',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'role' => 'anggota',
                'upa_id' => $upaA->id,
            ]
        );
        $anggota2->assignRole($anggotaRole);

        // ... (Anda bisa tambahkan data user dan UPA lain)
    }
}