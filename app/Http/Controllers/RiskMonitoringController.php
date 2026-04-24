<?php

namespace App\Http\Controllers;

use App\Models\Risk;
use App\Models\RiskMonitoring;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiskMonitoringController extends Controller
{
    protected $riskService;

    public function __construct(\App\Services\RiskService $riskService)
    {
        $this->riskService = $riskService;
    }

    /**
     * Tampilkan form monitoring baru
     */
    public function create(Request $request)
    {
        $this->authorize('create', RiskMonitoring::class);

        $risk = null;
        if ($request->has('risk_id')) {
            $risk = Risk::with(['unit', 'kategori', 'monitorings' => function($q) {
                $q->orderBy('tanggal_update', 'desc');
            }])->findOrFail($request->risk_id);

            // Authorization check for non-admin
            if (!Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Risk Manager'])) {
                if ($risk->unit_id !== Auth::user()->unit_id) {
                    abort(403, 'Anda tidak diizinkan mengakses data unit lain.');
                }
            }
        }

        return view('monitorings.create', compact('risk'));
    }

    /**
     * Tampilkan daftar risiko yang perlu dimonitor
     */
    public function index()
    {
        $user = Auth::user();
        $isAdmin = $user->hasAnyRole(['Super Admin', 'Admin', 'Risk Manager']);

        $query = Risk::with(['unit', 'kategori', 'monitorings' => function($q) {
            $q->orderBy('tanggal_update', 'desc');
        }])->where('status', 'Approved');

        if (!$isAdmin) {
            $query->where('unit_id', $user->unit_id);
        }

        $risks = $query->latest()->paginate(15);

        // 1. Analytics Calculation
        $allRisks = Risk::with('monitorings')->where('status', 'Approved')
            ->when(!$isAdmin, fn($q) => $q->where('unit_id', $user->unit_id))
            ->get();

        $totalRisks = $allRisks->count();
        $totalProgress = 0;
        $completed = 0;
        $residualMatrix = [];
        $levelDistribution = ['Extreme' => 0, 'High' => 0, 'Medium' => 0, 'Low' => 0];

        for ($p = 5; $p >= 1; $p--) {
            for ($d = 1; $d <= 5; $d++) {
                $residualMatrix[$p][$d] = collect();
            }
        }

        foreach ($allRisks as $risk) {
            $latest = $risk->monitorings->sortByDesc('tanggal_update')->first();
            $progress = $latest ? $latest->progress : 0;
            $totalProgress += $progress;
            if ($progress == 100) $completed++;

            if ($latest && $latest->residual_probabilitas && $latest->residual_impact) {
                $residualMatrix[$latest->residual_probabilitas][$latest->residual_impact]->push($risk);
                $levelDistribution[$latest->residual_level]++;
            } else {
                // Default to inherent if no monitoring yet
                $residualMatrix[$risk->probabilitas][$risk->level_dampak]->push($risk);
                $levelDistribution[$risk->level_risiko]++;
            }
        }

        $avgProgress = $totalRisks > 0 ? round($totalProgress / $totalRisks, 1) : 0;

        return view('monitorings.index', compact(
            'risks', 'residualMatrix', 'totalRisks', 'avgProgress', 'completed', 'levelDistribution'
        ));
    }

    /**
     * Simpan update monitoring baru
     */
    public function store(Request $request)
    {
        $this->authorize('create', RiskMonitoring::class);

        $validated = $request->validate([
            'risk_id' => 'required|exists:risks,id',
            'progress' => 'required|integer|min:0|max:100',
            'keterangan' => 'required|string',
            'tanggal_update' => 'required|date',
            'residual_probabilitas' => 'nullable|integer|min:1|max:5',
            'residual_impact' => 'nullable|integer|min:1|max:5',
        ]);

        $risk = Risk::findOrFail($validated['risk_id']);

        // Security check: Only allow monitoring for risks in the user's unit
        if (!Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Risk Manager'])) {
            if ($risk->unit_id !== Auth::user()->unit_id) {
                abort(403, 'Anda tidak diizinkan memperbarui monitoring unit lain.');
            }
        }

        $data = [
            'risk_id' => $validated['risk_id'],
            'progress' => $validated['progress'],
            'catatan' => $validated['keterangan'],
            'tanggal_update' => $validated['tanggal_update'],
        ];

        // Calculate Residual Risk if provided
        if ($request->filled('residual_probabilitas') && $request->filled('residual_impact')) {
            $data['residual_probabilitas'] = $validated['residual_probabilitas'];
            $data['residual_impact'] = $validated['residual_impact'];
            $data['residual_score'] = $this->riskService->calculateScore($validated['residual_probabilitas'], $validated['residual_impact']);
            $data['residual_level'] = $this->riskService->getLevel($data['residual_score']);
        }

        RiskMonitoring::create($data);

        return back()->with('success', 'Update monitoring dan penilaian Residual Risk berhasil ditambahkan.');
    }

    /**
     * Hapus monitoring
     */
    public function destroy(RiskMonitoring $monitoring)
    {
        $this->authorize('delete', $monitoring);
        $monitoring->delete();
        return back()->with('success', 'Data monitoring berhasil dihapus.');
    }
}

