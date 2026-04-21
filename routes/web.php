<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UnitController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ── Role Request (untuk user yang belum punya role) ──
Route::get('/panduan/download', [\App\Http\Controllers\PanduanController::class , 'download'])->name('panduan.download');

Route::middleware('auth')->group(function () {
    Route::get('/role-request', [\App\Http\Controllers\RoleRequestController::class , 'create'])->name('role-request.create');
    Route::post('/role-request', [\App\Http\Controllers\RoleRequestController::class , 'store'])->name('role-request.store');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('risks', \App\Http\Controllers\RiskController::class);
    Route::match (['post', 'patch'], '/risks/{risk}/submit', [\App\Http\Controllers\RiskController::class , 'submit'])->name('risks.submit');
    Route::match (['post', 'patch'], '/risks/{risk}/review', [\App\Http\Controllers\RiskController::class , 'review'])->name('risks.review');
    Route::match (['post', 'patch'], '/risks/{risk}/approve', [\App\Http\Controllers\RiskController::class , 'approve'])->name('risks.approve');
    Route::post('/risks/{risk}/reject', [\App\Http\Controllers\RiskController::class , 'reject'])->name('risks.reject');

    // Core Modules
    Route::get('/mitigations', [\App\Http\Controllers\MitigationController::class , 'index'])->name('mitigations.index');
    Route::get('/mitigations/create', [\App\Http\Controllers\MitigationController::class , 'create'])->name('mitigations.create');
    Route::resource('mitigations', \App\Http\Controllers\MitigationController::class)->only(['store', 'update', 'destroy', 'edit']);

    // Modul Unit Kerja
    Route::resource('units', UnitController::class);

    // Modul Kategori Risiko
    Route::resource('risk-categories', \App\Http\Controllers\RiskCategoryController::class);

    // Modul Jenis Unit
    Route::resource('unit-types', \App\Http\Controllers\UnitTypeController::class);

    // Performance Indicators
    Route::resource('performance-indicators', \App\Http\Controllers\PerformanceIndicatorController::class);

    // Monitoring
    Route::resource('monitorings', \App\Http\Controllers\RiskMonitoringController::class);

    Route::get('/risk-evaluation', [\App\Http\Controllers\RiskEvaluationController::class , 'index'])->name('risk-evaluation.index');
    // Reporting
    Route::get('/reports', [\App\Http\Controllers\ReportController::class , 'index'])->name('reports.index');
    Route::get('/reports/risks/pdf', [\App\Http\Controllers\ReportController::class , 'exportPdf'])->name('reports.risks.pdf');
    Route::get('/reports/risks/excel', [\App\Http\Controllers\ReportController::class , 'exportExcel'])->name('reports.risks.excel');

    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class , 'index'])->name('dashboard');
    Route::get('/blu-dashboard', [\App\Http\Controllers\BluDashboardController::class , 'index'])->name('blu.dashboard');

    // User Management
    Route::resource('users', \App\Http\Controllers\UserController::class);

    // Impersonation
    Route::post('/users/{user}/impersonate', [\App\Http\Controllers\ImpersonationController::class , 'impersonate'])->name('users.impersonate');
    Route::post('/impersonation/stop', [\App\Http\Controllers\ImpersonationController::class , 'stopImpersonating'])->name('impersonation.stop');

    // Notifications
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class , 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [\App\Http\Controllers\NotificationController::class , 'markAllAsRead'])->name('notifications.readAll');

    // ── Role Requests Admin ──
    Route::middleware('role:Super Admin')->group(function () {
            Route::get('/role-requests', [\App\Http\Controllers\RoleRequestController::class , 'index'])->name('role-requests.index');
            Route::post('/role-requests/{roleRequest}/approve', [\App\Http\Controllers\RoleRequestController::class , 'approve'])->name('role-requests.approve');
            Route::post('/role-requests/{roleRequest}/reject', [\App\Http\Controllers\RoleRequestController::class , 'reject'])->name('role-requests.reject');

            // Audit Logs
            Route::get('/audit-logs', [\App\Http\Controllers\AuditLogController::class , 'index'])->name('audit-logs.index');

            // Backups
            Route::get('/backups', [\App\Http\Controllers\BackupController::class , 'index'])->name('backups.index');
            Route::post('/backups/update', [\App\Http\Controllers\BackupController::class , 'update'])->name('backups.update');
            Route::post('/backups/run', [\App\Http\Controllers\BackupController::class , 'run'])->name('backups.run');
            Route::get('/backups/download/{filename}', [\App\Http\Controllers\BackupController::class , 'download'])->name('backups.download');
            Route::delete('/backups/{filename}', [\App\Http\Controllers\BackupController::class , 'destroy'])->name('backups.destroy');
        }
        );
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class , 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class , 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
