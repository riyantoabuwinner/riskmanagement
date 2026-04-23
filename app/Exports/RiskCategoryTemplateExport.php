<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RiskCategoryTemplateExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function array(): array
    {
        return [
            [
                'RC-01',
                'Risiko Strategis',
                'Risiko yang mempengaruhi pencapaian visi dan misi'
            ],
            [
                'RC-02',
                'Risiko Operasional',
                'Risiko pada proses bisnis harian'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'Kode',
            'Nama Kategori',
            'Deskripsi'
        ];
    }
}
