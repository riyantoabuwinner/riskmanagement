<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BackupSetting extends Model
{
    protected $fillable = ['frequency', 'is_active', 'last_run_at'];
}
