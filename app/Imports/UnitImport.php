<?php

namespace App\Imports;

use App\Models\Unit;
use App\Models\UnitType;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UnitImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        $unitType = UnitType::where('nama_jenis', 'like', '%' . $row['jenis_unit'] . '%')->first();

        return new Unit([
            'kode'         => $row['kode_unit'] ?? null,
            'nama_unit'    => $row['nama_unit'],
            'unit_type_id' => $unitType ? $unitType->id : 1, // Default to first type if not found
            'pimpinan'     => $row['pimpinan'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_unit'  => 'required|string|max:255',
            'jenis_unit' => 'required|string',
        ];
    }
}
