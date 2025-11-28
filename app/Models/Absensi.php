<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Absensi extends Model
{
    protected $table = 'absensi';
    
    protected $fillable = [
        'siswa_pkl_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'foto_masuk',
        'foto_pulang',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_masuk' => 'datetime:H:i',
        'jam_pulang' => 'datetime:H:i',
    ];

    public function siswaPkl(): BelongsTo
    {
        return $this->belongsTo(SiswaPkl::class);
    }
}