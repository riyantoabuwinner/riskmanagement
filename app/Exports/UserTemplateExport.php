<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class UserTemplateExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function array(): array
    {
        return [
            [
                'Ahmad Fauzi',
                'ahmad@example.com',
                'password123',
                'Risk Owner',
                'Fakultas Teknik'
            ],
            [
                'Siti Aminah',
                'siti@example.com',
                'password123',
                'Risk Officer',
                'Biro Akademik'
            ]
        ];
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Email',
            'Password',
            'Role',
            'Unit Kerja'
        ];
    }
}
