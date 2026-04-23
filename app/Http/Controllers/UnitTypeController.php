<?php

namespace App\Http\Controllers;

use App\Models\UnitType;
use App\Traits\HasAuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UnitTypeImport;
use App\Exports\UnitTypeTemplateExport;

class UnitTypeController extends Controller
{
    use HasAuditLog;

    public function index()
    {
        $this->authorize('manage master data');
        $types = UnitType::all();
        return view('unit_types.index', compact('types'));
    }

    public function store(Request $request)
    {
        $this->authorize('manage master data');
        $validated = $request->validate([
            'nama_jenis' => 'required|string|max:255|unique:unit_types,nama_jenis',
            'deskripsi' => 'nullable|string',
        ]);

        $type = UnitType::create($validated);
        $this->log(null, 'Menambahkan jenis unit baru: ' . $type->nama_jenis);

        return back()->with('success', 'Jenis unit berhasil ditambahkan.');
    }

    public function update(Request $request, UnitType $unitType)
    {
        $this->authorize('manage master data');
        $validated = $request->validate([
            'nama_jenis' => 'required|string|max:255|unique:unit_types,nama_jenis,' . $unitType->id,
            'deskripsi' => 'nullable|string',
        ]);

        $unitType->update($validated);
        $this->log(null, 'Memperbarui jenis unit: ' . $unitType->nama_jenis);

        return back()->with('success', 'Jenis unit berhasil diperbarui.');
    }

    public function destroy(UnitType $unitType)
    {
        $this->authorize('manage master data');

        if ($unitType->units()->count() > 0) {
            return back()->with('error', 'Jenis unit ini tidak dapat dihapus karena masih digunakan oleh data unit kerja.');
        }

        $nama = $unitType->nama_jenis;
        $unitType->delete();
        $this->log(null, 'Menghapus jenis unit: ' . $nama);

        return back()->with('success', 'Jenis unit berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $this->authorize('manage master data');
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(new UnitTypeImport, $request->file('file'));
            $this->log(null, 'Melakukan import jenis unit dari Excel');
            return back()->with('success', 'Data jenis unit berhasil diimport.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        $this->authorize('manage master data');
        return Excel::download(new UnitTypeTemplateExport, 'Format_Import_Jenis_Unit.xlsx');
    }

    public function bulkDelete(Request $request)
    {
        $this->authorize('manage master data');
        $ids = $request->ids;
        if (empty($ids)) {
            return back()->with('error', 'Pilih data yang ingin dihapus terlebih dahulu.');
        }

        $count = count($ids);
        
        // Check if any of these types are in use
        $inUse = UnitType::whereIn('id', $ids)->whereHas('units')->count();
        if ($inUse > 0) {
            return back()->with('error', $inUse . ' dari data yang dipilih tidak dapat dihapus karena masih digunakan oleh unit kerja.');
        }

        UnitType::whereIn('id', $ids)->delete();
        $this->log(null, 'Menghapus masal ' . $count . ' jenis unit');
        
        return back()->with('success', $count . ' jenis unit berhasil dihapus.');
    }
}
