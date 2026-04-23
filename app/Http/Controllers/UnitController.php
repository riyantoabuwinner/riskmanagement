<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\UnitType;
use App\Traits\HasAuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UnitImport;
use App\Exports\UnitTemplateExport;

class UnitController extends Controller
{
    use HasAuditLog;
    public function index()
    {
        $units = Unit::with('unitType')->withCount('risks')->get();
        $unitTypes = UnitType::all();
        return view('units.index', compact('units', 'unitTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_unit' => 'required|string|max:255',
            'unit_type_id' => 'required|exists:unit_types,id',
            'pimpinan' => 'nullable|string',
        ]);

        $unit = Unit::create($validated);
        $this->log(null, 'Menambahkan unit kerja baru: ' . $unit->nama_unit);
        return back()->with('success', 'Unit kerja berhasil ditambahkan.');
    }

    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'nama_unit' => 'required|string|max:255',
            'unit_type_id' => 'required|exists:unit_types,id',
            'pimpinan' => 'nullable|string',
        ]);

        $unit->update($validated);
        $this->log(null, 'Memperbarui unit kerja: ' . $unit->nama_unit);
        return back()->with('success', 'Unit kerja berhasil diperbarui.');
    }

    public function destroy(Unit $unit)
    {
        $nama = $unit->nama_unit;
        $unit->delete();
        $this->log(null, 'Menghapus unit kerja: ' . $nama);
        return back()->with('success', 'Unit kerja berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(new UnitImport, $request->file('file'));
            $this->log(null, 'Melakukan import unit kerja dari Excel');
            return back()->with('success', 'Data unit kerja berhasil diimport.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new UnitTemplateExport, 'Format_Import_Unit_Kerja.xlsx');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (empty($ids)) {
            return back()->with('error', 'Pilih data yang ingin dihapus terlebih dahulu.');
        }

        $count = count($ids);
        Unit::whereIn('id', $ids)->delete();
        $this->log(null, 'Menghapus masal ' . $count . ' unit kerja');
        
        return back()->with('success', $count . ' unit kerja berhasil dihapus.');
    }
}
