<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\UnitType;
use App\Traits\HasAuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    use HasAuditLog;
    public function index()
    {
        $units = Unit::with('unitType')->get();
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
}
