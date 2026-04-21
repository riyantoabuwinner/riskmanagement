<x-app-layout>
    @section('title', 'Detail Risiko')
    @section('page-title', 'Detail & Alur Review Risiko')
    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('risks.index') }}">Risk Register</a></li>
        <li class="breadcrumb-item active">Detail</li>
    @endsection

    @php
        $statusSteps = ['Draft', 'Submitted', 'Reviewed', 'Approved'];
        $currentStatusIndex = array_search($risk->status, $statusSteps);
        if($risk->status === 'Rejected') $currentStatusIndex = 1;
    @endphp

    <div class="row">
        <!-- Workflow Progress Timeline -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
                <div class="card-body p-0">
                    <div class="d-flex align-items-center justify-content-between p-4 bg-white">
                        @foreach($statusSteps as $index => $step)
                            <div class="text-center flex-grow-1 position-relative">
                                @if($index > 0)
                                    <div class="position-absolute w-100" style="top: 15px; left: -50%; height: 3px; background: {{ $index <= $currentStatusIndex ? 'var(--green-main)' : '#e2e8f0' }}; z-index: 1;"></div>
                                @endif
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2 shadow-sm" 
                                     style="width: 35px; height: 35px; background: {{ $risk->status === 'Rejected' && $index == 1 ? '#ef4444' : ($index <= $currentStatusIndex ? 'var(--green-main)' : '#fff') }}; 
                                            color: {{ $index <= $currentStatusIndex || ($risk->status === 'Rejected' && $index == 1) ? '#fff' : '#64748b' }}; 
                                            border: 2px solid {{ $risk->status === 'Rejected' && $index == 1 ? '#ef4444' : ($index <= $currentStatusIndex ? 'var(--green-main)' : '#e2e8f0') }};
                                            position: relative; z-index: 2;">
                                    @if($risk->status === 'Rejected' && $index == 1)
                                        <i class="fas fa-times"></i>
                                    @elseif($index < $currentStatusIndex)
                                        <i class="fas fa-check"></i>
                                    @else
                                        {{ $index + 1 }}
                                    @endif
                                </div>
                                <div class="small font-weight-bold {{ $index <= $currentStatusIndex ? 'text-dark' : 'text-muted' }}">
                                    {{ $step }}
                                    @if($risk->status === 'Rejected' && $index == 1)
                                        <span class="text-danger d-block text-xs">(Rejected)</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- Alert Rejection -->
            @if($risk->status === 'Rejected')
            <div class="alert alert-danger shadow-sm mb-4 border-0" style="border-radius: 10px; border-left: 5px solid #b91c1c !important;">
                <h6 class="font-weight-bold"><i class="fas fa-exclamation-triangle mr-2"></i> Risiko Ditolak (Perlu Revisi)</h6>
                <p class="mb-0 small"><strong>Alasan:</strong> {{ $risk->rejection_reason }}</p>
                <hr class="my-2 opacity-10">
                <p class="mb-0 text-xs">Silakan perbarui data identifikasi risiko sesuai catatan di atas.</p>
            </div>
            @endif

            <!-- Card Detail Utama -->
            <div class="card card-outline card-success shadow-sm mb-4">
                <div class="card-header bg-white d-flex align-items-center justify-content-between">
                    <h3 class="card-title font-weight-bold" style="color: var(--green-dark);">
                        <i class="fas fa-shield-virus mr-2"></i> Pernyataan Risiko: {{ $risk->nama_risiko }}
                    </h3>
                    <div class="d-flex align-items-center">
                        @if($risk->kode_risiko)
                            <span class="badge badge-dark px-3 py-2 text-uppercase mr-2" style="letter-spacing: 1px; background-color:#1e293b;">{{ $risk->kode_risiko }}</span>
                        @endif
                        <span class="badge badge-{{ $risk->level_color }} px-3 py-2 text-uppercase" style="letter-spacing: 1px;">{{ $risk->level_risiko }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-12 mb-3">
                            <label class="text-xs text-uppercase text-muted font-weight-bold"><i class="fas fa-bullseye mr-1"></i> Indikator Kinerja terkait</label>
                            <div class="d-flex flex-wrap">
                                @if(is_array($risk->misi_universitas))
                                    @forelse($risk->misi_universitas as $indicator)
                                        <span class="badge badge-outline-success mr-2 mb-2 p-2 border" style="color: var(--green-dark); font-weight: 500; background: #f0fdf4;">
                                            {{ $indicator }}
                                        </span>
                                    @empty
                                        <p class="mb-0 text-muted small">Tidak ada indikator terkait.</p>
                                    @endforelse
                                @elseif($risk->misi_universitas)
                                    <span class="badge badge-outline-success mr-2 mb-2 p-2 border" style="color: var(--green-dark); font-weight: 500; background: #f0fdf4;">
                                        {{ $risk->misi_universitas }}
                                    </span>
                                @else
                                    <p class="mb-0 text-muted small">-</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="text-xs text-uppercase text-muted font-weight-bold"><i class="fas fa-bullseye mr-1"></i> Sasaran Strategis Unit</label>
                            <p class="mb-0 text-dark">{{ $risk->sasaran_strategis ?? '-' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-xs text-uppercase text-muted font-weight-bold">Unit Kerja</label>
                            <p class="mb-0 font-weight-bold text-dark">{{ $risk->unit->nama_unit ?? '-' }}</p>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-xs text-uppercase text-muted font-weight-bold">Kategori</label>
                            <p class="mb-0 font-weight-bold text-dark">{{ $risk->kategori->nama_kategori ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="text-xs text-uppercase text-muted font-weight-bold">Deskripsi Peristiwa</label>
                        <div class="p-3 bg-light rounded" style="border-left: 4px solid var(--green-main);">
                            {{ $risk->deskripsi ?? 'Tidak ada deskripsi tambahan.' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-xs text-uppercase text-muted font-weight-bold">Penyebab (Root Cause)</label>
                                <p class="mb-0 text-sm">{{ $risk->penyebab ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-xs text-uppercase text-muted font-weight-bold">Dampak (Impact)</label>
                                <p class="mb-0 text-sm">{{ $risk->dampak ?? '-' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-xs text-uppercase text-muted font-weight-bold">Pemilik Risiko</label>
                                <p class="mb-0 font-weight-bold">{{ $risk->pemilik_risiko ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-xs text-uppercase text-muted font-weight-bold">Tanggal Identifikasi</label>
                                <p class="mb-0">{{ $risk->tanggal_identifikasi ? \Carbon\Carbon::parse($risk->tanggal_identifikasi)->format('d F Y') : '-' }}</p>
                            </div>
                        </div>
                    </div>
                    </div>

                    @if($risk->catatan_evaluasi || $risk->rejection_reason)
                    <div class="mt-4 border-top pt-4">
                        <h6 class="text-xs text-uppercase font-weight-bold mb-3 text-primary"><i class="fas fa-comment-dots mr-1"></i> Feedback dari Reviewer/Approver</h6>
                        
                        @if($risk->catatan_evaluasi)
                        <div class="alert alert-warning border-0 shadow-sm mb-3" style="border-radius: 10px;">
                            <div class="d-flex">
                                <i class="fas fa-info-circle mr-3 mt-1" style="font-size: 1.2rem;"></i>
                                <div>
                                    <div class="font-weight-bold text-xs text-uppercase mb-1">Catatan Evaluasi</div>
                                    <div class="text-sm">{{ $risk->catatan_evaluasi }}</div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($risk->rejection_reason)
                        <div class="alert alert-danger border-0 shadow-sm mb-0" style="border-radius: 10px;">
                            <div class="d-flex">
                                <i class="fas fa-exclamation-triangle mr-3 mt-1" style="font-size: 1.2rem;"></i>
                                <div>
                                    <div class="font-weight-bold text-xs text-uppercase mb-1">Alasan Penolakan / Revisi</div>
                                    <div class="text-sm font-italic font-weight-bold">"{{ $risk->rejection_reason }}"</div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>
                <div class="card-footer bg-white border-top py-3">
                    <div class="d-flex justify-content-between w-100">
                        <a href="{{ route('risks.index') }}" class="btn btn-light shadow-sm btn-sm px-3">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                        
                        <div class="btn-group">
                            @if($risk->status === 'Draft' || $risk->status === 'Rejected')
                                @can('update', $risk)
                                <a href="{{ route('risks.edit', $risk) }}" class="btn btn-primary btn-sm shadow-sm mr-2 rounded"><i class="fas fa-edit mr-1"></i> Edit</a>
                                @endcan
                                
                                <form action="{{ route('risks.submit', $risk) }}" method="POST" class="d-inline mr-2">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm shadow-sm px-3 rounded" onclick="return confirm('Ajukan risiko ini untuk direview?')">
                                        <i class="fas fa-paper-plane mr-1"></i> Ajukan Review
                                    </button>
                                </form>
                            @endif

                            @if($risk->status === 'Submitted')
                                @can('review', $risk)
                                <button type="button" class="btn btn-warning btn-sm shadow-sm px-3 rounded text-dark mr-2" data-toggle="modal" data-target="#reviewModal">
                                    <i class="fas fa-check-double mr-1"></i> Evaluasi (Review)
                                </button>
                                @endcan

                                @can('reject', $risk)
                                <button type="button" class="btn btn-danger btn-sm shadow-sm px-3 rounded" data-toggle="modal" data-target="#rejectModal">
                                    <i class="fas fa-times mr-1"></i> Tolak
                                </button>
                                @endcan
                            @endif

                            @if($risk->status === 'Reviewed')
                                @can('approve', $risk)
                                <form action="{{ route('risks.approve', $risk) }}" method="POST" class="d-inline mr-2">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm shadow-sm px-3 rounded" onclick="return confirm('Setujui risiko ini?')">
                                        <i class="fas fa-check mr-1"></i> Setujui (Approve)
                                    </button>
                                </form>
                                @endcan

                                @can('reject', $risk)
                                <button type="button" class="btn btn-danger btn-sm shadow-sm px-3 rounded" data-toggle="modal" data-target="#rejectModal">
                                    <i class="fas fa-times mr-1"></i> Tolak
                                </button>
                                @endcan
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Mitigasi -->
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold" style="color: var(--green-dark);"><i class="fas fa-shield-alt mr-2"></i> Rencana Mitigasi</h5>
                    <div class="btn-group">
                        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm mr-2 shadow-sm d-print-none">
                            <i class="fas fa-print mr-1"></i> Cetak Laporan
                        </button>
                        @if(in_array($risk->status, ['Draft', 'Submitted', 'Reviewed', 'Approved', 'Rejected']))
                        <a href="{{ route('mitigations.create', ['risk_id' => $risk->id]) }}" class="btn btn-success btn-sm shadow-sm d-print-none">
                            <i class="fas fa-plus mr-1"></i> Tambah Mitigasi
                        </a>
                        @endif
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr class="text-xs text-uppercase text-muted">
                                    <th class="px-4">Strategi & Aksi</th>
                                    <th>PIC</th>
                                    <th>Timeline</th>
                                    <th class="text-center">Status</th>
                                    <th>Anggaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($risk->mitigations as $mit)
                                <tr>
                                    <td class="px-4">
                                        <div class="font-weight-bold">{{ $mit->strategi }}</div>
                                        <div class="small text-muted">{{ $mit->rencana_aksi }}</div>
                                    </td>
                                    <td><small class="font-weight-bold">{{ $mit->penanggung_jawab }}</small></td>
                                    <td>
                                        <div class="small">Mulai: {{ $mit->tanggal_mulai ? \Carbon\Carbon::parse($mit->tanggal_mulai)->format('d/m/Y') : '-' }}</div>
                                        <div class="font-weight-bold {{ $mit->status != 'Completed' && $mit->target_waktu < date('Y-m-d') ? 'text-danger' : '' }}">
                                            Target: {{ $mit->target_waktu ? \Carbon\Carbon::parse($mit->target_waktu)->format('d/m/Y') : '-' }}
                                            @if($mit->status != 'Completed' && $mit->target_waktu < date('Y-m-d'))
                                                <span class="badge badge-danger ml-1 pulse" title="Early Warning: Melewati Target!">OVERDUE</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-{{ $mit->status == 'Completed' ? 'success' : ($mit->status == 'In Progress' ? 'info' : 'secondary') }} px-2 py-1">
                                            {{ $mit->status ?? 'Pending' }}
                                        </span>
                                    </td>
                                    <td><small class="text-success font-weight-bold">Rp {{ number_format($mit->anggaran, 0, ',', '.') }}</small></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fas fa-clipboard-list fa-3x mb-3 d-block opacity-10"></i>
                                        Belum ada rencana mitigasi.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Monitoring History -->
            <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold" style="color: var(--blue-dark);"><i class="fas fa-chart-line mr-2"></i> Monitoring & Realisasi</h5>
                    @if($risk->status === 'Approved')
                    <button type="button" class="btn btn-primary btn-sm shadow-sm" data-toggle="modal" data-target="#monitoringModal">
                        <i class="fas fa-plus mr-1"></i> Update Progress
                    </button>
                    @endif
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($risk->monitorings->sortByDesc('tanggal_update') as $mon)
                        <li class="list-group-item p-4 border-bottom-0 mb-2">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge badge-info px-3">{{ $mon->progress }}% Selesai</span>
                                <small class="text-muted font-weight-bold"><i class="far fa-calendar-alt mr-1"></i> {{ $mon->tanggal_update ? \Carbon\Carbon::parse($mon->tanggal_update)->format('d F Y') : '-' }}</small>
                            </div>
                            <div class="progress mb-3" style="height: 6px; border-radius: 3px;">
                                <div class="progress-bar bg-info" style="width: {{ $mon->progress }}%"></div>
                            </div>
                            <p class="mb-0 text-sm text-dark bg-white p-3 rounded shadow-sm" style="border-left: 3px solid #0ea5e9;">
                                {{ $mon->catatan }}
                            </p>

                            @if($mon->residual_level)
                            <div class="mt-3 d-flex align-items-center bg-white p-2 rounded border" style="border-style: dashed !important;">
                                <div class="mr-4">
                                    <small class="text-xs text-uppercase font-weight-bold text-muted d-block">Residual Risk</small>
                                    <span class="badge badge-{{ $mon->residual_level == 'Extreme' ? 'danger' : ($mon->residual_level == 'High' ? 'warning' : ($mon->residual_level == 'Medium' ? 'info' : 'success')) }} text-uppercase">
                                        {{ $mon->residual_level }}
                                    </span>
                                </div>
                                <div class="mr-4 text-center">
                                    <small class="text-xs text-muted d-block">Prob</small>
                                    <span class="font-weight-bold">{{ $mon->residual_probabilitas }}</span>
                                </div>
                                <div class="text-center">
                                    <small class="text-xs text-muted d-block">Impact</small>
                                    <span class="font-weight-bold">{{ $mon->residual_impact }}</span>
                                </div>
                                <div class="ml-auto text-right">
                                    <small class="text-xs text-muted d-block">Residual Score</small>
                                    <span class="h6 font-weight-bold mb-0 text-primary">{{ $mon->residual_score }}</span>
                                </div>
                            </div>
                            @endif
                        </li>
                        @empty
                        <li class="list-group-item text-center py-5 text-muted bg-transparent border-0">
                            <i class="fas fa-history fa-3x mb-3 d-block opacity-10"></i>
                            Belum ada catatan monitoring realisasi.
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Card Skor Hasil Penilaian -->
            <div class="card card-outline card-info shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title font-weight-bold mb-0">Hasil Penilaian Inherent</h5>
                </div>
                <div class="card-body text-center p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4 px-3">
                        <div class="text-center">
                            <div class="text-xs text-uppercase text-muted font-weight-bold mb-1">Probabilitas</div>
                            <div class="h4 font-weight-bold mb-0 text-dark">{{ $risk->probabilitas }}</div>
                        </div>
                        <div class="h3 font-weight-light text-muted">×</div>
                        <div class="text-center">
                            <div class="text-xs text-uppercase text-muted font-weight-bold mb-1">Dampak</div>
                            <div class="h4 font-weight-bold mb-0 text-dark">{{ $risk->level_dampak }}</div>
                        </div>
                    </div>
                    
                    <div class="py-3 rounded mb-4" style="background: #f8fafc; border: 2px dashed #e2e8f0; border-radius: 12px !important;">
                        <div class="text-xs text-uppercase font-weight-bold text-muted mb-1">Skor Risiko Total</div>
                        <div class="display-4 font-weight-bold" style="color: #1e293b;">{{ $risk->skor_risiko }}</div>
                    </div>

                    <div class="badge badge-{{ $risk->level_color }} w-100 py-3 text-uppercase shadow-sm" style="font-size: 0.9rem; letter-spacing: 1.5px; border-radius: 8px;">
                        {{ $risk->level_risiko }}
                    </div>
                </div>
            </div>

            <!-- Activity Log Card -->
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header bg-white py-3 border-bottom-0">
                    <h5 class="mb-0 font-weight-bold" style="color: var(--blue-dark);"><i class="fas fa-history mr-2"></i> Audit Trail</h5>
                </div>
                <div class="card-body p-0">
                    <div class="timeline timeline-inverse m-3" style="font-size: 0.75rem;">
                        @foreach($risk->auditLogs->sortByDesc('waktu') as $log)
                        <div>
                            <i class="fas fa-circle bg-gray" style="font-size: 8px; width: 20px; height: 20px; line-height: 20px;"></i>
                            <div class="timeline-item shadow-none border-0 bg-transparent py-1 ml-4" style="margin-top: -5px;">
                                <span class="time text-xs"><i class="far fa-clock"></i> {{ $log->waktu->format('d M H:i') }}</span>
                                <div class="timeline-header border-0 font-weight-bold" style="padding-top: 0;">{{ $log->aktivitas }}</div>
                                <small class="text-muted">Oleh: {{ $log->user->name ?? 'System' }}</small>
                            </div>
                        </div>
                        @endforeach

                        @if($risk->auditLogs->isEmpty())
                        <div class="text-center py-4 text-muted small">
                            Belum ada catatan aktivitas.
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Reject -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('risks.reject', $risk) }}" method="POST" class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                @csrf
                <div class="modal-header border-bottom-0 pt-4 px-4">
                    <h5 class="modal-title font-weight-bold">Tolak & Revisi Risiko</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body px-4">
                    <div class="form-group border rounded p-3 bg-light">
                        <label class="text-xs text-uppercase font-weight-bold text-muted">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea name="rejection_reason" class="form-control border-0 bg-transparent" rows="4" required placeholder="Jelaskan perbaikan yang diperlukan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pb-4 px-4">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger font-weight-bold shadow-sm">Kirim Penolakan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Evaluasi Mendalam (Review) -->
    <div class="modal fade" id="reviewModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('risks.review', $risk) }}" method="POST" class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                @csrf
                <div class="modal-header border-bottom-0 pt-4 px-4">
                    <h5 class="modal-title font-weight-bold text-warning"><i class="fas fa-clipboard-check mr-2"></i> Evaluasi Mendalam</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body px-4">
                    <div class="alert alert-warning border-0" style="border-radius: 10px; font-size: 0.85rem;">
                        <i class="fas fa-info-circle mr-1"></i> Anda akan menandai risiko ini sebagai <strong>Direview</strong>. Silakan lakukan asesmen akhir terhadap skor risiko.
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-xs text-uppercase font-weight-bold text-muted">Probabilitas (Likelihood) <span class="text-danger">*</span></label>
                                <select name="probabilitas" class="form-control" required>
                                    <option value="1" {{ $risk->probabilitas == 1 ? 'selected' : '' }}>1 - Sangat Jarang</option>
                                    <option value="2" {{ $risk->probabilitas == 2 ? 'selected' : '' }}>2 - Jarang</option>
                                    <option value="3" {{ $risk->probabilitas == 3 ? 'selected' : '' }}>3 - Mungkin</option>
                                    <option value="4" {{ $risk->probabilitas == 4 ? 'selected' : '' }}>4 - Sering</option>
                                    <option value="5" {{ $risk->probabilitas == 5 ? 'selected' : '' }}>5 - Hampir Pasti</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-xs text-uppercase font-weight-bold text-muted">Level Dampak (Impact) <span class="text-danger">*</span></label>
                                <select name="level_dampak" class="form-control" required>
                                    <option value="1" {{ $risk->level_dampak == 1 ? 'selected' : '' }}>1 - Sangat Rendah</option>
                                    <option value="2" {{ $risk->level_dampak == 2 ? 'selected' : '' }}>2 - Rendah</option>
                                    <option value="3" {{ $risk->level_dampak == 3 ? 'selected' : '' }}>3 - Sedang</option>
                                    <option value="4" {{ $risk->level_dampak == 4 ? 'selected' : '' }}>4 - Tinggi</option>
                                    <option value="5" {{ $risk->level_dampak == 5 ? 'selected' : '' }}>5 - Sangat Tinggi</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="text-xs text-uppercase font-weight-bold text-muted">Catatan Evaluasi / Rekomendasi <span class="text-danger">*</span></label>
                        <textarea name="catatan_evaluasi" class="form-control" rows="4" required placeholder="Tuliskan hasil evaluasi teknis, justifikasi skor, atau arahan mitigasi untuk Unit Kerja..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pb-4 px-4">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning font-weight-bold shadow-sm text-dark">Simpan Review</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Monitoring -->
    <div class="modal fade" id="monitoringModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('monitorings.store') }}" method="POST" class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                @csrf
                <input type="hidden" name="risk_id" value="{{ $risk->id }}">
                <div class="modal-header border-bottom-0 pt-4 px-4">
                    <h5 class="modal-title font-weight-bold"><i class="fas fa-chart-line mr-2 text-primary"></i> Update Progress Realisasi</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body px-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Persentase Terlaksana (%) <span class="text-danger">*</span></label>
                                <input type="number" name="progress" class="form-control shadow-sm" min="0" max="100" required placeholder="0-100">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Tanggal Update <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_update" class="form-control shadow-sm" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label class="text-xs text-uppercase font-weight-bold text-muted">Aksi Mitigasi Terkini <span class="text-danger">*</span></label>
                        <textarea name="keterangan" class="form-control" rows="3" required placeholder="Deskripsikan langkah mitigasi yang baru saja dilaksanakan..."></textarea>
                    </div>

                    <hr class="my-4">
                    <h6 class="font-weight-bold text-dark mb-3"><i class="fas fa-balance-scale mr-2 text-info"></i> Re-Asesmen Residual Risk (Apresiasi Risiko)</h6>
                    <p class="text-xs text-muted mb-3">Tentukan tingkat risiko yang masih tersisa setelah langkah mitigasi di atas dilaksanakan.</p>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-xs text-uppercase font-weight-bold text-muted">Residual Probabilitas <span class="text-danger">*</span></label>
                                <select name="residual_probabilitas" class="form-control" required>
                                    <option value="1" {{ $risk->probabilitas == 1 ? 'selected' : '' }}>1 - Sangat Jarang</option>
                                    <option value="2" {{ $risk->probabilitas == 2 ? 'selected' : '' }}>2 - Jarang</option>
                                    <option value="3" {{ $risk->probabilitas == 3 ? 'selected' : '' }}>3 - Mungkin</option>
                                    <option value="4" {{ $risk->probabilitas == 4 ? 'selected' : '' }}>4 - Sering</option>
                                    <option value="5" {{ $risk->probabilitas == 5 ? 'selected' : '' }}>5 - Hampir Pasti</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-xs text-uppercase font-weight-bold text-muted">Residual Impact <span class="text-danger">*</span></label>
                                <select name="residual_impact" class="form-control" required>
                                    <option value="1" {{ $risk->level_dampak == 1 ? 'selected' : '' }}>1 - Sangat Rendah</option>
                                    <option value="2" {{ $risk->level_dampak == 2 ? 'selected' : '' }}>2 - Rendah</option>
                                    <option value="3" {{ $risk->level_dampak == 3 ? 'selected' : '' }}>3 - Sedang</option>
                                    <option value="4" {{ $risk->level_dampak == 4 ? 'selected' : '' }}>4 - Tinggi</option>
                                    <option value="5" {{ $risk->level_dampak == 5 ? 'selected' : '' }}>5 - Sangat Tinggi</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pb-4 px-4">
                    <button type="button" class="btn btn-light px-4" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 font-weight-bold shadow-sm">Simpan Update</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
