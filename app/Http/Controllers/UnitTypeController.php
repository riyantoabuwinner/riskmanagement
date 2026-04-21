<?php

namespace App\Http\Controllers;

use App\Models\UnitType;
use App\Traits\HasAuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
