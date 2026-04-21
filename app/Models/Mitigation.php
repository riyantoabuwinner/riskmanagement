<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mitigation extends Model
{
    use HasFactory;

    protected $fillable = [
        'risk_id',
        'strategi',
        'rencana_aksi',
        'penanggung_jawab',
        'tanggal_mulai',
        'target_waktu',
        'anggaran',
        'status',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'target_waktu' => 'date',
        'anggaran' => 'decimal:2',
    ];

    public function risk()
    {
        return $this->belongsTo(Risk::class);
    }
//
}
