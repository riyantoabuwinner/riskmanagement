<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait HasAuditLog
{
    /**
     * Record an activity to the audit_logs table.
     *
     * @param int|null $riskId
     * @param string $aktivitas
     * @return void
     */
    protected function log($riskId, $aktivitas)
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'risk_id' => $riskId,
            'aktivitas' => $aktivitas,
            'ip_address' => request()->ip(),
            'waktu' => now(),
        ]);
    }
}
