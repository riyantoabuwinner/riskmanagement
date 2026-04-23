<?php

namespace App\Http\Controllers;

use App\Models\PerformanceIndicator;
use App\Traits\HasAuditLog;
use Illuminate\Http\Request;

class PerformanceIndicatorController extends Controller
{
    use HasAuditLog;

    public function index()
    {
        $this->authorize('manage master data');
        
        // Load only top-level indicators, eager load children with risk count
        $indicators = PerformanceIndicator::whereNull('parent_id')
            ->with(['children' => function($q) {
                $q->withCount('risks');
            }])
            ->withCount('risks')
            ->get()
            ->groupBy('type');
        
        $types = ['ASTA PROTAS', 'IKU PTN', 'PERKIN PENDIS', 'SDGs'];
        foreach ($types as $type) {
            if (!isset($indicators[$type])) {
                $indicators[$type] = collect();
            }
        }

        return view('indicators.index', compact('indicators'));
    }

    public function store(Request $request)
    {
        $this->authorize('manage master data');
        
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:performance_indicators,id',
            'code' => 'required|string|unique:performance_indicators,code',
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'period' => 'required|string',
        ]);

        $indicator = PerformanceIndicator::create($validated);
        $this->log(null, 'Menambahkan indikator kinerja baru: ' . $indicator->code);

        return back()->with('success', 'Indikator berhasil ditambahkan.');
    }

    public function update(Request $request, PerformanceIndicator $performanceIndicator)
    {
        $this->authorize('manage master data');
        
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:performance_indicators,id',
            'code' => 'required|string|unique:performance_indicators,code,' . $performanceIndicator->id,
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'period' => 'required|string',
        ]);

        $performanceIndicator->update($validated);
        $this->log(null, 'Memperbarui indikator kinerja: ' . $performanceIndicator->code);

        return back()->with('success', 'Indikator berhasil diperbarui.');
    }

    public function destroy(PerformanceIndicator $performanceIndicator)
    {
        $this->authorize('manage master data');
        
        $code = $performanceIndicator->code;
        $performanceIndicator->delete();
        $this->log(null, 'Menghapus indikator kinerja: ' . $code);

        return back()->with('success', 'Indikator berhasil dihapus.');
    }
}
