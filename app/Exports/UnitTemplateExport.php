<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UnitTemplateExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function array(): array
    {
        return [
            [
                'UK001',
                'Fakultas Teknik',
                'Fakultas',
                'Dekan Fakultas Teknik'
            ],
            [
                'UK002',
                'Biro Akademik',
                'Biro',
                'Kepala Biro Akademik'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'Kode Unit',
            'Nama Unit',
            'Jenis Unit',
            'Pimpinan'
        ];
    }
}
