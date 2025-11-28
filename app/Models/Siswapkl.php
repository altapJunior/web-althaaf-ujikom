<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiswaPkl extends Model
{
    protected $table = 'siswa_pkl';
    
    protected $fillable = [
        'user_id',
        'nama',
        'nim_nis',
        'jurusan',
        'sekolah',
        'foto'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class);
    }

    public function absensiHariIni()
    {
        return $this->hasOne(Absensi::class)
            ->whereDate('tanggal', now('Asia/Jakarta')->toDateString());
    }
}