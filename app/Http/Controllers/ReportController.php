<?php

namespace App\Http\Controllers;

use App\Exports\RisksExport;
use App\Models\Risk;
use App\Models\Unit;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Tampilkan halaman filter laporan
     */
    public function index(Request $request)
    {
        $units = Unit::all();
        $query = Risk::with(['unit', 'kategori']);

        // Filter based on user role
        if (!Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Risk Manager'])) {
            $query->where('unit_id', Auth::user()->unit_id);
        }

        // Apply filters from request
        if ($request->filled('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal_identifikasi', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal_identifikasi', '<=', $request->end_date);
        }

        // Only fetch if a filter is applied or explicitly requested
        $risks = null;
        if ($request->anyFilled(['unit_id', 'status', 'start_date', 'end_date', 'view'])) {
            $risks = $query->latest()->get();
        }

        return view('reports.index', compact('units', 'risks'));
    }

    /**
     * Export Risk Register ke PDF
     */
    public function exportPdf(Request $request)
    {
        $query = Risk::with(['unit', 'kategori', 'mitigations']);

        // Filter based on user role
        if (!Auth::user()->hasAnyRole(['Super Admin', 'Admin', 'Risk Manager'])) {
            $query->where('unit_id', Auth::user()->unit_id);
        }

        if ($request->unit_id) {
            $query->where('unit_id', $request->unit_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->start_date) {
            $query->whereDate('tanggal_identifikasi', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('tanggal_identifikasi', '<=', $request->end_date);
        }

        $risks = $query->latest()->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.risks_pdf', [
            'risks' => $risks,
            'title' => 'Risk Register - UIN Syekh Nurjati Cirebon',
            'date' => now()->format('d F Y'),
            'filters' => $request->only(['start_date', 'end_date', 'status'])
        ])->setPaper('a4', 'landscape');

        return $pdf->download('Risk-Register-' . now()->format('YmdHis') . '.pdf');
    }

    /**
     * Export Risk Register ke Excel
     */
    public function exportExcel(Request $request)
    {
        return Excel::download(new RisksExport($request), 'Risk-Register-' . now()->format('YmdHis') . '.xlsx');
    }
}
