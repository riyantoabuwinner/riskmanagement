<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\RoleRequest;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Check if user has any role
        if ($user->roles->isEmpty()) {
            return redirect()->route('role-request.create');
        }

        // Stats and Filtering
        $isAdmin = $user->hasAnyRole(['Super Admin', 'Admin', 'Risk Manager']);
        $unitId = $user->unit_id;
        $unitName = $user->unit ? $user->unit->nama_unit : null;

        $riskQuery = \App\Models\Risk::query();
        if (!$isAdmin) {
            $riskQuery->where('unit_id', $unitId);
        }

        $totalRisks = (clone $riskQuery)->count();

        $risksByCategory = (clone $riskQuery)->with('kategori')
            ->select('kategori_id', DB::raw('count(*) as total'))
            ->groupBy('kategori_id')
            ->get();

        $risksByUnit = (clone $riskQuery)->with('unit')
            ->select('unit_id', DB::raw('count(*) as total'))
            ->groupBy('unit_id')
            ->get();

        $topRisks = (clone $riskQuery)->with(['unit', 'kategori'])
            ->orderBy('skor_risiko', 'desc')
            ->take(10)
            ->get();

        $allRisks = (clone $riskQuery)->get();
        $heatmapInherent = [];
        $heatmapResidual = [];
        $risksInCellInherent = [];
        $risksInCellResidual = [];

        // Initialize matrices
        for ($p = 5; $p >= 1; $p--) {
            for ($d = 1; $d <= 5; $d++) {
                $heatmapInherent[$p][$d] = 0;
                $heatmapResidual[$p][$d] = 0;
                $risksInCellInherent[$p][$d] = [];
                $risksInCellResidual[$p][$d] = [];
            }
        }

        foreach ($allRisks as $risk) {
            // Inherent
            if ($risk->probabilitas && $risk->level_dampak) {
                $heatmapInherent[$risk->probabilitas][$risk->level_dampak]++;
                $risksInCellInherent[$risk->probabilitas][$risk->level_dampak][] = $risk->nama_risiko;
            }

            // Residual
            $latestMonitoring = $risk->monitorings->sortByDesc('tanggal_update')->first();
            if ($latestMonitoring && $latestMonitoring->residual_probabilitas && $latestMonitoring->residual_impact) {
                $heatmapResidual[$latestMonitoring->residual_probabilitas][$latestMonitoring->residual_impact]++;
                $risksInCellResidual[$latestMonitoring->residual_probabilitas][$latestMonitoring->residual_impact][] = $risk->nama_risiko;
            } else {
                if ($risk->probabilitas && $risk->level_dampak) {
                    $heatmapResidual[$risk->probabilitas][$risk->level_dampak]++;
                    $risksInCellResidual[$risk->probabilitas][$risk->level_dampak][] = $risk->nama_risiko;
                }
            }
        }

        // Advanced Stats for Detailed Dashboard
        $mitigationQuery = \App\Models\RiskMonitoring::query();
        if (!$isAdmin) {
            $mitigationQuery->whereHas('risk', fn($q) => $q->where('unit_id', $unitId));
        }
        $avgProgress = $mitigationQuery->avg('progress') ?? 0;
        
        $kriCount = \App\Models\PerformanceIndicator::count();
        
        $openIncidents = (clone $riskQuery)->where('status', 'Approved')->count();

        // Monthly Mitigation Performance (Last 6 Months)
        $mitigationPerformance = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $count = (clone $mitigationQuery)->whereYear('tanggal_update', $date->year)
                ->whereMonth('tanggal_update', $date->month)
                ->count();
            $mitigationPerformance['labels'][] = $date->format('M');
            $mitigationPerformance['data'][] = $count;
        }

        // Critical Mitigation Tasks
        $criticalTasks = \App\Models\Mitigation::with('risk')
            ->whereHas('risk', function($q) use ($isAdmin, $unitId) {
                if (!$isAdmin) $q->where('unit_id', $unitId);
            })
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalRisks',
            'topRisks',
            'heatmapInherent',
            'heatmapResidual',
            'risksInCellInherent',
            'risksInCellResidual',
            'isAdmin',
            'unitName',
            'avgProgress',
            'openIncidents',
            'kriCount',
            'mitigationPerformance',
            'criticalTasks'
        ));
    }
}
