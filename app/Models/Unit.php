<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected static function booted()
    {
        static::creating(function ($unit) {
            if (empty($unit->kode)) {
                // Generate simple code from initials
                $words = explode(' ', $unit->nama_unit);
                $initials = '';
                foreach ($words as $w) {
                    if (!empty($w)) {
                        $initials .= strtoupper($w[0]);
                    }
                }

                $unit->kode = $initials ?: 'UNIT';

                // Ensure uniqueness if needed, but initials might clash
                $count = 1;
                $originalKode = $unit->kode;
                while (Unit::where('kode', $unit->kode)->exists()) {
                    $unit->kode = $originalKode . $count++;
                }
            }
        });
    }

    protected $fillable = [
        'nama_unit',
        'kode',
        'unit_type_id',
        'pimpinan',
    ];

    public function unitType()
    {
        return $this->belongsTo(UnitType::class, 'unit_type_id');
    }

    public function risks()
    {
        return $this->hasMany(Risk::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
