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

        // Optional: Add filters for user, activity, or date range here
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('aktivitas', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($qu) use ($search) {
                    $qu->where('name', 'like', "%{$search}%");
                }
                );
            });
        }

        $logs = $query->paginate(20);

        return view('audit_logs.index', compact('logs'));
    }
}
