<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'risk_id',
        'aktivitas',
        'ip_address',
        'waktu',
    ];

    protected $casts = [
        'waktu' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function risk()
    {
        return $this->belongsTo(Risk::class);
    }
}
