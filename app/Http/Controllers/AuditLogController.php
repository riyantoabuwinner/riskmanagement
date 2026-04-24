<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditLogController extends Controller
{
    /**
     * Display a listing of the audit logs.
     */
    public function index(Request $request)
    {
        $this->authorize('view audit logs');

        $query = AuditLog::with(['user', 'risk'])->latest('waktu');

        // Apply filters
        if ($request->filled('start_date')) {
            $query->whereDate('waktu', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('waktu', '<=', $request->end_date);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('aktivitas', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($qu) use ($search) {
                        $qu->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('risk', function ($qr) use ($search) {
                        $qr->where('nama_risiko', 'like', "%{$search}%");
                    });
            });
        }

        $isFiltered = $request->anyFilled(['start_date', 'end_date', 'search']);
        
        // Use pagination for both to ensure links() works in view
        $logs = $query->paginate($isFiltered ? 50 : 10);

        return view('audit_logs.index', compact('logs', 'isFiltered'));
    }

    public function exportExcel(Request $request)
    {
        $this->authorize('view audit logs');
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\AuditLogsExport($request), 'Audit_Log_' . now()->format('Y-m-d') . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $this->authorize('view audit logs');
        
        $query = AuditLog::with(['user', 'risk'])->latest('waktu');

        if ($request->filled('start_date')) {
            $query->whereDate('waktu', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('waktu', '<=', $request->end_date);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('aktivitas', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($qu) use ($search) {
                        $qu->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $logs = $query->get();
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('audit_logs.pdf', compact('logs', 'start_date', 'end_date'));
        return $pdf->download('Audit_Log_' . now()->format('Y-m-d') . '.pdf');
    }
}
