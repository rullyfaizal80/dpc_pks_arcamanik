<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder; // Import Builder

class LaporanAmalan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'tanggal_upa', 'periode_awal', 'periode_akhir', 'jenjang',
        'amal_1_sholat_berjamaah', 'amal_2_sholat_malam', 'amal_3_baca_quran',
        'amal_4_shaum_sunnah', 'amal_5_almatsurat', 'amal_6_sholat_dhuha',
        'amal_7_olahraga', 'amal_8_istighfar', 'amal_9_shalawat',
        'status',
    ];

    // Relasi: Laporan Amalan dimiliki oleh satu User (Anggota)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Local Query Scope untuk Pembina (FIX ERROR forPembina())
    public function scopeForPembina(Builder $query, User $pembina): void
    {
        if ($pembina->hasRole('Pembina')) {
            // Ambil ID UPA yang dibina oleh Pembina ini (menggunakan relasi upaAsPembina dari Model User)
            $upaIds = $pembina->upaAsPembina->pluck('id')->toArray();

            // Filter laporan hanya dari user yang upa_id-nya ada di daftar UPA yang dibina
            $query->whereHas('user', function ($q) use ($upaIds) {
                $q->whereIn('upa_id', $upaIds);
            });
        }
    }
}