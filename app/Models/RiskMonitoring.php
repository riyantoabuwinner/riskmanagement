<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiskMonitoring extends Model
{
    protected $table = 'risk_monitoring';

    protected $fillable = [
        'risk_id',
        'progress',
        'catatan',
        'tanggal_update',
        'residual_probabilitas',
        'residual_impact',
        'residual_score',
        'residual_level',
    ];

    protected $casts = [
        'tanggal_update' => 'date',
    ];

    public function risk()
    {
        return $this->belongsTo(Risk::class);
    }
}
