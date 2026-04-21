<?php

namespace App\Http\Controllers;

use App\Models\RiskCategory;
use App\Traits\HasAuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiskCategoryController extends Controller
{
    use HasAuditLog;

    public function index()
    {
        $this->authorize('manage master data');
        $categories = RiskCategory::all();
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
}
