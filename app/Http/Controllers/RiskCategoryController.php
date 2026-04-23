<?php

namespace App\Http\Controllers;

use App\Models\RiskCategory;
use App\Traits\HasAuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RiskCategoryImport;
use App\Exports\RiskCategoryTemplateExport;

class RiskCategoryController extends Controller
{
    use HasAuditLog;

    public function index()
    {
        $this->authorize('manage master data');
        $categories = RiskCategory::withCount('risks')->get();
        return view('risk_categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->authorize('manage master data');
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $category = RiskCategory::create($validated);
        $this->log(null, 'Menambahkan kategori risiko baru: ' . $category->nama_kategori);

        return back()->with('success', 'Kategori risiko berhasil ditambahkan.');
    }

    public function update(Request $request, RiskCategory $riskCategory)
    {
        $this->authorize('manage master data');
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $riskCategory->update($validated);
        $this->log(null, 'Memperbarui kategori risiko: ' . $riskCategory->nama_kategori);

        return back()->with('success', 'Kategori risiko berhasil diperbarui.');
    }

    public function destroy(RiskCategory $riskCategory)
    {
        $this->authorize('manage master data');

        if ($riskCategory->risks()->count() > 0) {
            return back()->with('error', 'Kategori ini tidak dapat dihapus karena masih digunakan oleh data risiko.');
        }

        $nama = $riskCategory->nama_kategori;
        $riskCategory->delete();
        $this->log(null, 'Menghapus kategori risiko: ' . $nama);

        return back()->with('success', 'Kategori risiko berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $this->authorize('manage master data');
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(new RiskCategoryImport, $request->file('file'));
            $this->log(null, 'Melakukan import kategori risiko dari Excel');
            return back()->with('success', 'Data kategori risiko berhasil diimport.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $this->authorize('manage master data');
        return Excel::download(new RiskCategoryTemplateExport, 'Format_Import_Kategori_Risiko.xlsx');
    }

    public function bulkDelete(Request $request)
    {
        $this->authorize('manage master data');
        $ids = $request->ids;
        if (empty($ids)) {
            return back()->with('error', 'Pilih data yang ingin dihapus terlebih dahulu.');
        }

        $count = count($ids);
        
        // Check if any are in use
        $inUse = RiskCategory::whereIn('id', $ids)->whereHas('risks')->count();
        if ($inUse > 0) {
            return back()->with('error', $inUse . ' dari data yang dipilih tidak dapat dihapus karena masih digunakan oleh data risiko.');
        }

        RiskCategory::whereIn('id', $ids)->delete();
        $this->log(null, 'Menghapus masal ' . $count . ' kategori risiko');
        
        return back()->with('success', $count . ' kategori risiko berhasil dihapus.');
    }
}
