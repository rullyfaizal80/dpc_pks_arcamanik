<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Upa extends Model
{
    use HasFactory;

    // Relasi: UPA memiliki satu Pembina
    public function pembina(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pembina_id');
    }

    // Relasi: UPA memiliki banyak Anggota
    public function members(): HasMany
    {
        return $this->hasMany(User::class);
    }
}