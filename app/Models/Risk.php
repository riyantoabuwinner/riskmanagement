<?php

namespace App\Models;

use App\Models\Mitigation;
use App\Models\RiskCategory;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Risk extends Model
{
    protected $fillable = [
        'unit_id',
        'kategori_id',
        'performance_indicator_id',
        'kode_risiko',
        'nomor_urut',
        'misi_universitas',
        'nama_risiko',
        'sasaran_strategis',
        'deskripsi',
        'penyebab',
        'dampak',
        'probabilitas',
        'level_dampak',
        'skor_risiko',
        'level_risiko',
        'pemilik_risiko',
        'status',
        'rejection_reason',
        'catatan_evaluasi',
        'tanggal_identifikasi',
        'created_by'
    ];

    protected $casts = [
        'tanggal_identifikasi' => 'date',
        'misi_universitas' => 'array',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function kategori()
    {
        return $this->belongsTo(RiskCategory::class, 'kategori_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function mitigations()
    {
        return $this->hasMany(Mitigation::class);
    }

    public function monitorings()
    {
        return $this->hasMany(RiskMonitoring::class);
    }

    public function performanceIndicator()
    {
        return $this->belongsTo(PerformanceIndicator::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function getLevelLabelAttribute()
    {
        return $this->level_risiko ?? 'Low';
    }

    public function getLevelColorAttribute()
    {
        $score = $this->skor_risiko;
        if ($score >= 16)
            return 'danger'; // Extreme - Red
        if ($score >= 11)
            return 'warning'; // High - Orange (will handle in view)
        if ($score >= 6)
            return 'info'; // Medium - Yellow
        return 'success'; // Low - Green
    }
}
