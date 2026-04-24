<?php

namespace App\Http\Controllers;

use App\Models\Risk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiskEvaluationController extends Controller
{
    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $isAdmin = $user->hasAnyRole(['Super Admin', 'Admin', 'Risk Manager']);

        // 1. Matrices (storing list of risks for tooltips)
        $inherentMatrix = [];
        $residualMatrix = [];
        for ($p = 5; $p >= 1; $p--) {
            for ($d = 1; $d <= 5; $d++) {
                $inherentMatrix[$p][$d] = collect();
                $residualMatrix[$p][$d] = collect();
            }
        }

        // 2. Risk Level Distributions
        $levels = ['Extreme' => 0, 'High' => 0, 'Medium' => 0, 'Low' => 0];
        $inherentDist = $levels;
        $residualDist = $levels;

        // Base Query for Risks
        $baseQuery = Risk::with(['unit', 'kategori', 'monitorings' => function($q) {
            $q->orderBy('tanggal_update', 'desc');
        }]);
        if (!$isAdmin) { $baseQuery->where('unit_id', $user->unit_id); }
        $allRisks = $baseQuery->get();

        $trends = ['improved' => 0, 'stable' => 0, 'worsened' => 0];
        $totalReduction = 0;
        $monitoredCount = 0;

        foreach ($allRisks as $risk) {
            // Inherent stats
            $inherentMatrix[$risk->probabilitas][$risk->level_dampak]->push($risk);
            $inherentDist[$risk->level_risiko]++;

            $latest = $risk->monitorings->first();
            if ($latest && $latest->residual_probabilitas && $latest->residual_impact) {
                $monitoredCount++;
                $p_res = $latest->residual_probabilitas;
                $d_res = $latest->residual_impact;
                $residualMatrix[$p_res][$d_res]->push($risk);
                
                $residualScore = $p_res * $d_res;
                $residualLevel = self::calculateLevel($residualScore);
                $residualDist[$residualLevel]++;

                $reduction = $risk->skor_risiko - $residualScore;
                $totalReduction += $reduction;

                if ($reduction > 0) $trends['improved']++;
                elseif ($reduction < 0) $trends['worsened']++;
                else $trends['stable']++;
            } else {
                // If not monitored, residual = inherent
                $residualDist[$risk->level_risiko]++;
                $residualMatrix[$risk->probabilitas][$risk->level_dampak]->push($risk);
                $trends['stable']++;
            }
        }

        $avgReduction = $monitoredCount > 0 ? round($totalReduction / $monitoredCount, 1) : 0;

        // 3. Pending Risks (for the table)
        $pendingRisks = Risk::with(['unit', 'monitorings'])
            ->when(!$isAdmin, fn($q) => $q->where('unit_id', $user->unit_id))
            ->orderBy('skor_risiko', 'desc')
            ->paginate(10);

        return view('risk_evaluation.index', compact(
            'inherentMatrix', 'residualMatrix', 'pendingRisks', 'trends', 
            'inherentDist', 'residualDist', 'avgReduction', 'monitoredCount'
        ));
    }

    public static function calculateLevel($score)
    {
        if ($score >= 16) return 'Extreme';
        if ($score >= 12) return 'High';
        if ($score >= 6) return 'Medium';
        return 'Low';
    }
}
