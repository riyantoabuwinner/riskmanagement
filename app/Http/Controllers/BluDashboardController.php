<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BluDashboardController extends Controller
{
    public function index()
    {
        $totalRisks = \App\Models\Risk::count();
        $ikuRisks = \App\Models\Risk::where('is_iku_related', true)->count();
        $financialExposure = \App\Models\Risk::sum('financial_impact_amount');

        $risksByType = \App\Models\Risk::selectRaw('type, count(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type');

        // Top 5 Financial Risks
        $topFinancialRisks = \App\Models\Risk::whereNotNull('financial_impact_amount')
            ->orderByDesc('financial_impact_amount')
            ->take(5)
            ->get();

        return view('blu_dashboard', compact('totalRisks', 'ikuRisks', 'financialExposure', 'risksByType', 'topFinancialRisks'));
    }
}
