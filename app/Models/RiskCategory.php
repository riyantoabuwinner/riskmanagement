<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiskCategory extends Model
{
    protected static function booted()
    {
        static::creating(function ($category) {
            if (empty($category->kode)) {
                $count = RiskCategory::count() + 1;
                $category->kode = 'RC-' . sprintf("%02d", $count);

                while (RiskCategory::where('kode', $category->kode)->exists()) {
                    $category->kode = 'RC-' . sprintf("%02d", ++$count);
                }
            }
            $category->kode = strtoupper($category->kode);
        });
    }

    protected $fillable = [
        'nama_kategori',
        'kode',
        'deskripsi',
    ];

    public function risks()
    {
        return $this->hasMany(Risk::class, 'kategori_id');
    }
}
