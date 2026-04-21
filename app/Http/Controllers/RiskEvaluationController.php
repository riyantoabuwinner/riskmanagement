<?php

namespace App\Http\Controllers;

use App\Models\Risk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiskEvaluationController extends Controller
{
    public function index()
    {
        // 1. Heatmap Data (Matrix 5x5) using probabilitas & level_dampak
        $matrixIds = [];
        for ($p = 5; $p >= 1; $p--) {
            for ($d = 1; $d <= 5; $d++) {
                $matrixIds[$p][$d] = Risk::where('probabilitas', $p)
                    ->where('level_dampak', $d)
                    ->count();
            }
        }

        // 2. Risks Pending Evaluation (Draft or Submitted status)
        $query = Risk::with(['unit', 'kategori'])
            ->whereIn('status', ['Draft', 'Submitted']);

        // Filter by Unit for non-admin
        if (!\Illuminate\Support\Facades\Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Risk Manager'])) {
            $query->where('unit_id', \Illuminate\Support\Facades\Auth::user()->unit_id);
        }

        // Prioritize Submitted risks, then by date
        $pendingRisks = $query->orderByRaw("FIELD(status, 'Submitted', 'Draft')")
            ->latest()
            ->paginate(10);

        return view('risk_evaluation.index', compact('matrixIds', 'pendingRisks'));
    }
}
