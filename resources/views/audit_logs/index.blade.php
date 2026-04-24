<x-app-layout>
    @section('title', 'Audit Log')
    @section('page-title', 'Log Aktivitas')
    @section('breadcrumb')
        <li class="breadcrumb-item active">Audit Log</li>
    @endsection

    <style>
        .log-timeline {
            position: relative;
            padding: 20px 0;
        }
        .log-item {
            position: relative;
            padding-left: 50px;
            margin-bottom: 30px;
        }
        .log-item::before {
            content: '';
            position: absolute;
            left: 19px;
            top: 40px;
            bottom: -30px;
            width: 2px;
            background: #e9ecef;
        }
        .log-item:last-child::before {
            display: none;
        }
        .log-icon {
            position: absolute;
            left: 0;
            top: 0;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            z-index: 1;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .log-content {
            background: #fff;
            border-radius: 12px;
            padding: 15px 20px;
            border: 1px solid #f1f5f9;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            transition: all 0.3s ease;
        }
        .log-content:hover {
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
            transform: translateY(-2px);
        }
        .log-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }
        .log-time {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 500;
        }
        .log-user {
            font-weight: 600;
            color: #047857;
            font-size: 0.9rem;
        }
        .log-activity {
            color: #1e293b;
            font-size: 0.95rem;
            line-height: 1.5;
        }
        .log-badge-ip {
            font-family: monospace;
            font-size: 0.7rem;
            color: #94a3b8;
            background: #f8fafc;
            padding: 2px 8px;
            border-radius: 4px;
        }
        .search-container {
            background: linear-gradient(135deg, #065f46, #047857);
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            color: #fff;
        }
    </style>

    <div class="container-fluid">
        <div class="search-container shadow-lg">
            <div class="row">
                <div class="col-lg-4 mb-3 mb-lg-0">
                    <h4 class="mb-1 font-weight-bold">Riwayat Aktivitas</h4>
                    <p class="mb-0 opacity-75 small">Pantau seluruh perubahan dan kegiatan sistem secara real-time.</p>
                    
                    @if(!$isFiltered)
                        <div class="mt-2 badge badge-warning px-3 py-1 rounded-pill shadow-sm">
                            <i class="fas fa-clock mr-1"></i> Menampilkan 10 Aktivitas Terakhir
                        </div>
                    @else
                        <div class="mt-2 badge badge-info px-3 py-1 rounded-pill shadow-sm">
                            <i class="fas fa-filter mr-1"></i> Mode Filter Aktif
                        </div>
                    @endif
                </div>
                <div class="col-lg-8">
                    <form action="{{ route('audit-logs.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <div class="form-group mb-0">
                                    <label class="small font-weight-bold text-white mb-1">Dari Tanggal</label>
                                    <input type="date" name="start_date" class="form-control form-control-sm rounded-pill border-0" value="{{ request('start_date') }}">
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="form-group mb-0">
                                    <label class="small font-weight-bold text-white mb-1">Sampai Tanggal</label>
                                    <input type="date" name="end_date" class="form-control form-control-sm rounded-pill border-0" value="{{ request('end_date') }}">
                                </div>
                            </div>
                            <div class="col-md-4 mb-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-warning btn-sm btn-block rounded-pill font-weight-bold shadow-sm">
                                    <i class="fas fa-filter mr-1"></i> Terapkan Filter
                                </button>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-8 mb-2">
                                <div class="input-group input-group-sm bg-white rounded-pill p-1 shadow-sm">
                                    <input type="text" name="search" class="form-control border-0 rounded-pill px-3" 
                                           placeholder="Cari aktivitas, user, atau risiko..." 
                                           value="{{ request('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-emerald rounded-pill px-3" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2 d-flex align-items-center justify-content-between">
                                @if($isFiltered)
                                    <a href="{{ route('audit-logs.index') }}" class="btn btn-link text-white btn-sm px-0 mr-2">Reset</a>
                                @endif
                                <div class="btn-group shadow-sm">
                                    <a href="{{ route('audit-logs.export-excel', request()->query()) }}" class="btn btn-light btn-sm rounded-left" title="Export Excel">
                                        <i class="fas fa-file-excel text-success"></i>
                                    </a>
                                    <a href="{{ route('audit-logs.export-pdf', request()->query()) }}" class="btn btn-light btn-sm rounded-right" title="Export PDF">
                                        <i class="fas fa-file-pdf text-danger"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="log-timeline">
                    @forelse ($logs as $log)
                        @php
                            $icon = 'fa-info-circle';
                            $color = '#047857'; // Emerald
                            
                            if (str_contains(strtolower($log->aktivitas), 'tambah') || str_contains(strtolower($log->aktivitas), 'buat')) {
                                $icon = 'fa-plus-circle';
                                $color = '#10b981'; // Green
                            } elseif (str_contains(strtolower($log->aktivitas), 'hapus')) {
                                $icon = 'fa-trash-alt';
                                $color = '#ef4444'; // Red
                            } elseif (str_contains(strtolower($log->aktivitas), 'perbarui') || str_contains(strtolower($log->aktivitas), 'update') || str_contains(strtolower($log->aktivitas), 'edit')) {
                                $icon = 'fa-sync-alt';
                                $color = '#f59e0b'; // Amber
                            } elseif (str_contains(strtolower($log->aktivitas), 'approve') || str_contains(strtolower($log->aktivitas), 'setuju')) {
                                $icon = 'fa-check-double';
                                $color = '#065f46'; // Dark Emerald
                            }
                        @endphp
                        
                        <div class="log-item">
                            <div class="log-icon" style="background-color: {{ $color }};">
                                <i class="fas {{ $icon }}"></i>
                            </div>
                            <div class="log-content">
                                <div class="log-meta">
                                    <div class="log-user">
                                        <i class="fas fa-user-circle mr-1"></i>
                                        {{ $log->user->name ?? 'System' }}
                                        <span class="text-muted font-weight-normal mx-1">•</span>
                                        <span class="log-badge-ip">{{ $log->ip_address }}</span>
                                    </div>
                                    <div class="log-time">
                                        <i class="far fa-clock mr-1"></i>
                                        {{ $log->waktu->translatedFormat('d M Y, H:i') }}
                                    </div>
                                </div>
                                <div class="log-activity">
                                    {{ $log->aktivitas }}
                                    
                                    @if($log->risk_id)
                                        <div class="mt-2 pt-2 border-top">
                                            <small class="text-muted d-block mb-1">Risiko Terkait:</small>
                                            <a href="{{ route('risks.show', $log->risk_id) }}" class="text-emerald font-weight-bold">
                                                <i class="fas fa-exclamation-triangle mr-1 text-warning"></i>
                                                {{ $log->risk->nama_risiko ?? 'Lihat Detail Risiko' }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-history fa-4x text-gray-200"></i>
                            </div>
                            <h5 class="text-muted">Bel_um ada aktivitas yang tercatat.</h5>
                            <p class="text-muted small">Mulai berinteraksi dengan sistem untuk melihat log di sini.</p>
                        </div>
                    @endforelse
                </div>

                <div class="d-flex justify-content-center mt-5">
                    {{ $logs->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
