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
     * Tampilkan daftar risiko yang perlu dimonitor
     */
    public function index()
    {
        $this->authorize('viewAny', RiskMonitoring::class);

        $query = Risk::with(['unit', 'kategori', 'monitorings'])
            ->where('status', 'Approved');

        // Filter by Unit for non-admin
        if (!Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Risk Manager'])) {
            $query->where('unit_id', Auth::user()->unit_id);
        }

        $risks = $query->latest()->paginate(15);

        // Calculate Residual Matrix (5x5)
        $residualMatrix = [];
        for ($p = 5; $p >= 1; $p--) {
            for ($d = 1; $d <= 5; $d++) {
                $residualMatrix[$p][$d] = 0;
            }
        }

        $allApproved = Risk::with('monitorings')->where('status', 'Approved')->get();
        foreach ($allApproved as $risk) {
            $latest = $risk->monitorings->sortByDesc('tanggal_update')->first();
            if ($latest && $latest->residual_probabilitas && $latest->residual_impact) {
                $residualMatrix[$latest->residual_probabilitas][$latest->residual_impact]++;
            }
        }

        return view('monitorings.index', compact('risks', 'residualMatrix'));
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

