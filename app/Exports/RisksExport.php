<?php

namespace App\Exports;

use App\Models\Risk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\Auth;

class RisksExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Risk::with(['unit', 'kategori']);

        if (!Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Risk Manager'])) {
            $query->where('unit_id', Auth::user()->unit_id);
        }

        if ($this->request->unit_id) {
            $query->where('unit_id', $this->request->unit_id);
        }

        if ($this->request->status) {
            $query->where('status', $this->request->status);
        }

        if ($this->request->start_date) {
            $query->whereDate('tanggal_identifikasi', '>=', $this->request->start_date);
        }

        if ($this->request->end_date) {
            $query->whereDate('tanggal_identifikasi', '<=', $this->request->end_date);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Risiko',
            'Unit Kerja',
            'Kategori',
            'Penyebab',
            'Dampak',
            'Probabilitas',
            'Level Dampak',
            'Skor Risiko',
            'Level Risiko',
            'Status',
            'Tanggal Identifikasi',
        ];
    }

    public function map($risk): array
    {
        return [
            $risk->id,
            $risk->nama_risiko,
            $risk->unit->nama_unit ?? '-',
            $risk->kategori->nama_kategori ?? '-',
            $risk->penyebab,
            $risk->dampak,
            $risk->probabilitas,
            $risk->level_dampak,
            $risk->skor_risiko,
            $risk->level_risiko,
            $risk->status,
            $risk->created_at->format('d/m/Y'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '064E3B']
                ]
            ],
        ];
    }
}
