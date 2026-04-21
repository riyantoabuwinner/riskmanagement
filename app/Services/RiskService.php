<?php

namespace App\Services;

class RiskService
{
    public function calculateScore(int $prob, int $impact): int
    {
        return $prob * $impact;
    }

    public function getLevel(int $score): string
    {
        if ($score >= 16)
            return 'Extreme';
        if ($score >= 11)
            return 'High';
        if ($score >= 6)
            return 'Medium';
        return 'Low';
    }

    public function getNextStatus(string $currentRole, string $action): string
    {
        if ($action === 'reject')
            return 'Draft';

        if ($currentRole === 'Unit Kerja' && $action === 'submit') {
            return 'Submitted';
        }
        if (in_array($currentRole, ['Risk Manager Fakultas', 'SPI']) && $action === 'review') {
            return 'Reviewed';
        }
        if ($currentRole === 'Pimpinan Universitas' && $action === 'approve') {
            return 'Approved';
        }

        return 'Draft';
    }
}
