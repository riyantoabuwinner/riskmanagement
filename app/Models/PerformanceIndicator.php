<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerformanceIndicator extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'code',
        'name',
        'type',
        'period',
    ];

    public function parent()
    {
        return $this->belongsTo(PerformanceIndicator::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(PerformanceIndicator::class, 'parent_id');
    }

    public function risks()
    {
        return $this->belongsToMany(Risk::class, 'risk_performance_indicator');
    }
}
