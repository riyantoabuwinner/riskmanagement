<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UnitTypeTemplateExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function array(): array
    {
        return [
            [
                'Fakultas',
                'Unit kerja tingkat fakultas'
            ],
            [
                'Lembaga',
                'Unit kerja tingkat lembaga'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Jenis',
            'Deskripsi'
        ];
    }
}
