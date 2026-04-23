<?php

namespace App\Imports;

use App\Models\UnitType;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UnitTypeImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new UnitType([
            'nama_jenis' => $row['nama_jenis'],
            'deskripsi'  => $row['deskripsi'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_jenis' => 'required|string|max:255|unique:unit_types,nama_jenis',
        ];
    }
}
