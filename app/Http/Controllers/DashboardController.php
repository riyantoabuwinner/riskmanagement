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

        // Heatmap Data (Matrix 5x5)
        $heatmapData = (clone $riskQuery)->select('probabilitas', 'level_dampak', DB::raw('count(*) as count'))
            ->groupBy('probabilitas', 'level_dampak')
            ->get();

        $heatmap = [];
        for ($p = 5; $p >= 1; $p--) {
            for ($d = 1; $d <= 5; $d++) {
                $count = $heatmapData->where('probabilitas', $p)->where('level_dampak', $d)->first()->count ?? 0;
                $heatmap[$p][$d] = $count;
            }
        }

        // Chart Data Format
        $chartCategory = [
            'labels' => $risksByCategory->map(fn($r) => $r->kategori->nama_kategori ?? 'Unknown'),
            'data' => $risksByCategory->pluck('total')
        ];

        $chartUnit = [
            'labels' => $risksByUnit->map(fn($r) => $r->unit->nama_unit ?? 'Unknown'),
            'data' => $risksByUnit->pluck('total')
        ];

        return view('dashboard', compact(
            'totalRisks',
            'chartCategory',
            'chartUnit',
            'topRisks',
            'heatmap',
            'isAdmin',
            'unitName'
        ));
    }
}
