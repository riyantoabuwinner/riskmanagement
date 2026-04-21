<x-app-layout>
@section('title', 'Backup Data')
@section('page-title', 'Pusat Backup Data')

@section('breadcrumb')
    <li class="breadcrumb-item active">Backup Data</li>
@endsection

@push('styles')
<style>
    .backup-card {
        border-radius: 15px;
        transition: all 0.3s ease;
        border: none;
        overflow: hidden;
    }
    .backup-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
    }
    .table-luxury thead th {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%) !important;
        color: white;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
        border: none;
    }
    .btn-luxury {
        border-radius: 10px;
        padding: 10px 20px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s;
    }
    .btn-luxury-primary {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        border: none;
        color: white;
    }
    .btn-luxury-primary:hover {
        background: linear-gradient(135deg, #047857 0%, #059669 100%);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        color: white;
    }
    .empty-state {
        text-align: center;
        padding: 40px;
        color: #6b7280;
    }
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 15px;
        color: #d1fae5;
    }
</style>
@endpush

@section('slot')
<div class="container-fluid">
    <div class="row">
        <!-- Status & Stats -->
        <div class="col-md-4">
            <div class="card backup-card shadow-sm mb-4">
                <div class="card-header d-flex align-items-center bg-white">
                    <i class="fas fa-info-circle mr-2 text-success"></i>
                    <h3 class="card-title font-weight-bold mb-0">Status Terakhir</h3>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div style="font-size: 0.8rem; color: #6b7280;">Dijalankan Terakhir</div>
                        <div class="font-weight-bold h4 mb-0" style="color: #064e3b;">
                            {{ $setting->last_run_at ? \Carbon\Carbon::parse($setting->last_run_at)->diffForHumans() : 'Belum pernah' }}
                        </div>
                        <small class="text-muted">{{ $setting->last_run_at ? \Carbon\Carbon::parse($setting->last_run_at)->format('d M Y, H:i') : '-' }}</small>
                    </div>
                    
                    <form action="{{ route('backups.run') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-luxury btn-luxury-primary btn-block">
                            <i class="fas fa-play mr-2"></i> Backup Sekarang
                        </button>
                    </form>
                </div>
            </div>

            <!-- Configuration -->
            <div class="card backup-card shadow-sm">
                <div class="card-header d-flex align-items-center bg-white">
                    <i class="fas fa-cog mr-2 text-success"></i>
                    <h3 class="card-title font-weight-bold mb-0">Pengaturan Otomatis</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('backups.update') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="font-weight-600">Frekuensi Backup</label>
                            <select name="frequency" class="form-control custom-select">
                                <option value="daily" {{ $setting->frequency == 'daily' ? 'selected' : '' }}>Harian (Setiap Hari)</option>
                                <option value="weekly" {{ $setting->frequency == 'weekly' ? 'selected' : '' }}>Mingguan (Setiap Senin)</option>
                                <option value="monthly" {{ $setting->frequency == 'monthly' ? 'selected' : '' }}>Bulanan (Tanggal 1)</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ $setting->is_active ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Aktifkan Backup Otomatis</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-luxury btn-light border btn-block text-dark mt-3">
                            <i class="fas fa-save mr-2 text-success"></i> Simpan Pengaturan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- History & Files -->
        <div class="col-md-8">
            <div class="card backup-card shadow-sm">
                <div class="card-header bg-white">
                    <ul class="nav nav-pills" id="backupTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="files-tab" data-toggle="pill" href="#files" role="tab">
                                <i class="fas fa-file-archive mr-2"></i> File Backup
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="logs-tab" data-toggle="pill" href="#logs" role="tab">
                                <i class="fas fa-history mr-2"></i> Riwayat Proses
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-0">
                    <div class="tab-content" id="backupTabsContent">
                        <!-- File Tab -->
                        <div class="tab-pane fade show active" id="files" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-luxury table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nama File</th>
                                            <th>Ukuran</th>
                                            <th>Dibuat</th>
                                            <th class="text-right">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($backups as $file)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fas fa-file-zip text-warning mr-3 fa-lg"></i>
                                                        <span class="font-weight-600">{{ $file['filename'] }}</span>
                                                    </div>
                                                </td>
                                                <td><span class="badge badge-light border">{{ $file['size'] }}</span></td>
                                                <td><small class="text-muted">{{ date('d M Y, H:i', $file['created_at']) }}</small></td>
                                                <td class="text-right">
                                                    <div class="btn-group">
                                                        <a href="{{ route('backups.download', $file['filename']) }}" class="btn btn-sm btn-info" title="Download">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                        <form action="{{ route('backups.destroy', $file['filename']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus file backup ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger ml-1" title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="empty-state">
                                                    <i class="fas fa-database"></i>
                                                    <p>Belum ada file backup yang tersedia.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Logs Tab -->
                        <div class="tab-pane fade" id="logs" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-luxury table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Waktu</th>
                                            <th>Status</th>
                                            <th>Pesan / File</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($logs as $log)
                                            <tr>
                                                <td><small>{{ $log->created_at->format('d/m/Y H:i') }}</small></td>
                                                <td>
                                                    @if($log->status == 'success')
                                                        <span class="status-badge bg-success text-white">BERHASIL</span>
                                                    @else
                                                        <span class="status-badge bg-danger text-white">GAGAL</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($log->status == 'success')
                                                        <span class="text-muted small">{{ $log->filename }} ({{ $log->size }})</span>
                                                    @else
                                                        <span class="text-danger small">{{ $log->error_message }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="empty-state">
                                                    <i class="fas fa-history"></i>
                                                    <p>Belum ada catatan riwayat backup.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
