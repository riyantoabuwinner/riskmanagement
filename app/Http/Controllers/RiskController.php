<?php

namespace App\Http\Controllers;

use App\Models\Risk;
use App\Models\AuditLog;
use App\Models\RiskCategory;
use App\Models\Unit;
use App\Services\RiskService;
use App\Traits\HasAuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\RiskStatusUpdated;
use App\Models\User;
use App\Models\PerformanceIndicator;

class RiskController extends Controller
{
    use HasAuditLog;

    protected $riskService;

    public function __construct(RiskService $riskService)
    {
        $this->riskService = $riskService;
    }


    public function index(Request $request)
    {
        $this->authorize('viewAny', Risk::class);

        $query = Risk::with(['unit', 'kategori']);

        // Applicabe filters
        if ($request->filled('probabilitas')) {
            $query->where('probabilitas', $request->probabilitas);
        }
        if ($request->filled('level_dampak')) {
            $query->where('level_dampak', $request->level_dampak);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }

        if (!Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Risk Manager'])) {
            $query->where('unit_id', Auth::user()->unit_id);
        }

        $risks = $query->latest()->paginate(15);
        return view('risks.index', compact('risks'));
    }

    public function create()
    {
        $this->authorize('create', Risk::class);

        $categories = RiskCategory::all();
        $units = Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Risk Manager'])
            ? Unit::all()
            : Unit::where('id', Auth::user()->unit_id)->get();
        
        $indicators = PerformanceIndicator::whereNull('parent_id')
            ->with('children')
            ->get()
            ->groupBy('type');

        return view('risks.create', compact('categories', 'units', 'indicators'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Risk::class);

        $validated = $request->validate([
            'nama_risiko' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'misi_universitas' => 'nullable|array',
            'sasaran_strategis' => 'required|string',
            'kategori_id' => 'required|exists:risk_categories,id',
            'unit_id' => 'required|exists:units,id',
            'penyebab' => 'nullable|string',
            'dampak' => 'nullable|string',
            'probabilitas' => 'required|integer|min:1|max:5',
            'level_dampak' => 'required|integer|min:1|max:5',
            'pemilik_risiko' => 'nullable|string',
            'tanggal_identifikasi' => 'nullable|date',
            'performance_indicator_ids' => 'nullable|array',
            'performance_indicator_ids.*' => 'exists:performance_indicators,id',
        ]);

        $validated['skor_risiko'] = $this->riskService->calculateScore($validated['probabilitas'], $validated['level_dampak']);
        $validated['level_risiko'] = $this->riskService->getLevel($validated['skor_risiko']);
        $validated['status'] = 'Draft';
        $validated['created_by'] = Auth::id();

        // Security check: Risk Owners can only create risks for their own unit
        if (!Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Risk Manager'])) {
            $validated['unit_id'] = Auth::user()->unit_id;
        }

        $risk = Risk::create($validated);
        
        if ($request->has('performance_indicator_ids')) {
            $risk->performanceIndicators()->sync($request->performance_indicator_ids);
        }

        $this->log($risk->id, 'Mengidentifikasi risiko baru sebagai Draft');

        return redirect()->route('risks.index')->with('success', 'Identifikasi risiko berhasil disimpan sebagai Draft.');
    }

    public function show(Risk $risk)
    {
        $this->authorize('view', $risk);
        $risk->load(['unit', 'kategori', 'mitigations', 'monitorings', 'auditLogs.user', 'performanceIndicators']);
        return view('risks.show', compact('risk'));
    }

    public function edit(Risk $risk)
    {
        $this->authorize('update', $risk);

        $categories = RiskCategory::all();
        $units = Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Risk Manager'])
            ? Unit::all()
            : Unit::where('id', Auth::user()->unit_id)->get();
        
        $indicators = PerformanceIndicator::whereNull('parent_id')
            ->with('children')
            ->get()
            ->groupBy('type');

        return view('risks.edit', compact('risk', 'categories', 'units', 'indicators'));
    }

    public function update(Request $request, Risk $risk)
    {
        $this->authorize('update', $risk);

        $validated = $request->validate([
            'nama_risiko' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'misi_universitas' => 'nullable|array',
            'sasaran_strategis' => 'required|string',
            'kategori_id' => 'required|exists:risk_categories,id',
            'penyebab' => 'nullable|string',
            'dampak' => 'nullable|string',
            'probabilitas' => 'required|integer|min:1|max:5',
            'level_dampak' => 'required|integer|min:1|max:5',
            'pemilik_risiko' => 'nullable|string',
            'tanggal_identifikasi' => 'nullable|date',
            'performance_indicator_ids' => 'nullable|array',
            'performance_indicator_ids.*' => 'exists:performance_indicators,id',
        ]);

        $validated['skor_risiko'] = $this->riskService->calculateScore($validated['probabilitas'], $validated['level_dampak']);
        $validated['level_risiko'] = $this->riskService->getLevel($validated['skor_risiko']);

        // If rejected, updating moves it back to Draft
        if ($risk->status === 'Rejected') {
            $validated['status'] = 'Draft';
        }

        $risk->update($validated);
        
        if ($request->has('performance_indicator_ids')) {
            $risk->performanceIndicators()->sync($request->performance_indicator_ids);
        } else {
            $risk->performanceIndicators()->detach();
        }

        $this->log($risk->id, 'Memperbarui detail identifikasi risiko');

        return redirect()->route('risks.show', $risk)->with('success', 'Identifikasi risiko berhasil diperbarui.');
    }

    public function submit(Risk $risk)
    {
        $this->authorize('submit', $risk);
        $risk->update(['status' => 'Submitted']);
        $this->log($risk->id, 'Mengajukan risiko untuk direview');
        return back()->with('success', 'Risiko telah diajukan untuk direview.');
    }

    public function review(Request $request, Risk $risk)
    {
        $this->authorize('review', $risk);

        $validated = $request->validate([
            'catatan_evaluasi' => 'required|string|min:5',
            'probabilitas' => 'required|integer|min:1|max:5',
            'level_dampak' => 'required|integer|min:1|max:5',
        ]);

        $oldStatus = $risk->status;

        // Final assessment by Risk Officer
        $newScore = $this->riskService->calculateScore($validated['probabilitas'], $validated['level_dampak']);
        $newLevel = $this->riskService->getLevel($newScore);

        $risk->update([
            'status' => 'Reviewed',
            'probabilitas' => $validated['probabilitas'],
            'level_dampak' => $validated['level_dampak'],
            'skor_risiko' => $newScore,
            'level_risiko' => $newLevel,
            'catatan_evaluasi' => $validated['catatan_evaluasi'],
        ]);

        $this->log($risk->id, "Mengevaluasi Risiko (Reviewed). Hasil Asesmen: P={$validated['probabilitas']}, D={$validated['level_dampak']}, Skor={$newScore}. Catatan: {$validated['catatan_evaluasi']}");

        // Notify Risk Owner
        $owner = User::find($risk->created_by);
        if ($owner) {
            $owner->notify(new RiskStatusUpdated($risk, $oldStatus, 'Reviewed'));
        }

        return back()->with('success', 'Risiko telah berhasil dievaluasi dan ditandai sebagai Reviewed.');
    }

    public function approve(Risk $risk)
    {
        $this->authorize('approve', $risk);
        $oldStatus = $risk->status;

        // Generate Risk Code if not already set
        if (!$risk->kode_risiko) {
            $lastRisk = Risk::whereNotNull('nomor_urut')->orderBy('nomor_urut', 'desc')->first();
            $nextNumber = $lastRisk ? $lastRisk->nomor_urut + 1 : 1;

            $unitCode = $risk->unit->kode ?? 'U' . $risk->unit_id;
            $catCode = $risk->kategori->kode ?? 'RC' . $risk->kategori_id;

            $risk->nomor_urut = $nextNumber;
            $risk->kode_risiko = sprintf("%s/%s/%03d", $unitCode, $catCode, $nextNumber);
        }

        $risk->update(['status' => 'Approved']);
        $this->log($risk->id, 'Menyetujui (Approve) risiko. Kode Generated: ' . $risk->kode_risiko);

        // Notify Risk Owner
        $owner = User::find($risk->created_by);
        if ($owner) {
            $owner->notify(new RiskStatusUpdated($risk, $oldStatus, 'Approved'));
        }

        return back()->with('success', 'Risiko telah disetujui (Approved) dengan kode: ' . $risk->kode_risiko);
    }

    public function reject(Request $request, Risk $risk)
    {
        $this->authorize('reject', $risk);
        $request->validate(['rejection_reason' => 'required|string']);

        $oldStatus = $risk->status;
        $risk->update([
            'status' => 'Rejected',
            'rejection_reason' => $request->rejection_reason
        ]);

        $this->log($risk->id, 'Menolak risiko dengan alasan: ' . $request->rejection_reason);

        // Notify Risk Owner
        $owner = User::find($risk->created_by);
        if ($owner) {
            $owner->notify(new RiskStatusUpdated($risk, $oldStatus, 'Rejected'));
        }

        return back()->with('warning', 'Risiko telah ditolak dan dikembalikan untuk revisi.');
    }

    public function destroy(Risk $risk)
    {
        $this->authorize('delete', $risk);
        $risk->delete();
        return redirect()->route('risks.index')->with('success', 'Data risiko berhasil dihapus.');
    }
}
