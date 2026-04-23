<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PanduanController extends Controller
{
    /**
     * Display the interactive user guide page.
     */
    public function index()
    {
        return view('panduan.index');
    }

    /**
     * Download the Panduan Penggunaan PDF.
     */
    public function download()
    {
        // Load the view and pass generic data if needed.
        $pdf = Pdf::loadView('panduan.pdf', []);

        // Optional: set paper size and orientation.
        // $pdf->setPaper('a4', 'portrait');

        return $pdf->download('Panduan_Penggunaan_RiskManagement.pdf');
    }
}
