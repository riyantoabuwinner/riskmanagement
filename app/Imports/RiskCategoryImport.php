<?php

namespace App\Imports;

use App\Models\RiskCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class RiskCategoryImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new RiskCategory([
            'kode'          => $row['kode'] ?? null,
            'nama_kategori' => $row['nama_kategori'],
            'deskripsi'     => $row['deskripsi'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_kategori' => 'required|string|max:255',
        ];
    }
}
