<x-app-layout>
    @section('title', 'Monitoring Risiko')
    @section('page-title', 'Monitoring & Realisasi Risiko')

    <div class="row mb-4">
        <!-- Residual Heatmap -->
        <div class="col-md-5">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 12px;">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 font-weight-bold" style="color: var(--green-dark);"><i class="fas fa-map-marked-alt mr-2"></i> Residual Risk Map</h5>
                    <small class="text-muted">Posisi risiko setelah proses mitigasi</small>
                </div>
                <div class="card-body">
                    <div class="matrix-container" style="max-width: 300px; margin: 0 auto;">
                        <div class="d-flex" style="height: 250px;">
                            <!-- Y-Axis (Probabilitas) -->
                            <div class="d-flex flex-column justify-content-between pr-2 text-muted" style="font-size: 0.7rem; font-weight: bold;">
                                <div>5</div><div>4</div><div>3</div><div>2</div><div>1</div>
                            </div>
                            <!-- Matrix Cells -->
                            <div class="flex-grow-1" style="display: grid; grid-template-columns: repeat(5, 1fr); grid-template-rows: repeat(5, 1fr); gap: 2px;">
                                @for($p = 5; $p >= 1; $p--)
                                    @for($d = 1; $d <= 5; $d++)
                                        @php
                                            $score = $p * $d;
                                            $color = ($score >= 16) ? '#fecaca' : (($score >= 11) ? '#fed7aa' : (($score >= 6) ? '#fef3c7' : '#d1fae5'));
                                            $textColor = ($score >= 16) ? '#991b1b' : (($score >= 11) ? '#9a3412' : (($score >= 6) ? '#92400e' : '#065f46'));
                                            $count = $residualMatrix[$p][$d] ?? 0;
                                        @endphp
                                        <div class="d-flex align-items-center justify-content-center" 
                                             style="background-color: {{ $color }}; border-radius: 3px; font-weight: bold; color: {{ $textColor }}; font-size: 0.8rem; position: relative;">
                                            @if($count > 0)
                                                <span class="badge badge-pill badge-dark" style="font-size: 0.65rem; padding: 3px 6px;">{{ $count }}</span>
                                            @endif
                                        </div>
                                    @endfor
                                @endfor
                            </div>
                        </div>
                        <!-- X-Axis (Impact) -->
                        <div class="d-flex justify-content-between pl-4 mt-2 text-muted" style="font-size: 0.7rem; font-weight: bold;">
                            <div style="width: 20%;">1</div><div style="width: 20%; text-align: center;">2</div><div style="width: 20%; text-align: center;">3</div><div style="width: 20%; text-align: center;">4</div><div style="width: 20%; text-align: right;">5</div>
                        </div>
                    </div>
                    <div class="mt-4 d-flex justify-content-center flex-wrap" style="gap: 10px;">
                        <span class="badge" style="background:#d1fae5; color:#065f46; font-size: 0.65rem;">LOW</span>
                        <span class="badge" style="background:#fef3c7; color:#92400e; font-size: 0.65rem;">MEDIUM</span>
                        <span class="badge" style="background:#fed7aa; color:#9a3412; font-size: 0.65rem;">HIGH</span>
                        <span class="badge" style="background:#fecaca; color:#991b1b; font-size: 0.65rem;">EXTREME</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="col-md-7">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 12px; background: linear-gradient(135deg, var(--green-dark), #064e3b); color: white;">
                <div class="card-body d-flex flex-column justify-content-center p-4">
                    <h4 class="font-weight-bold mb-3"><i class="fas fa-chart-line mr-2"></i> Pengelolaan Residu</h4>
                    <p style="opacity: 0.9; line-height: 1.6;">
                        <strong>Risiko Residual</strong> adalah tingkat risiko yang masih tersisa setelah kita menerapkan seluruh rencana mitigasi. 
                        Tujuannya adalah menurunkan posisi risiko dari area merah/oranye ke area kuning/hijau.
                    </p>
                    <div class="row mt-3">
                        <div class="col-6">
                            <div class="p-3 bg-white-10" style="background: rgba(255,255,255,0.1); border-radius: 10px;">
                                <div class="text-xs text-uppercase opacity-70">Inherent Risk</div>
                                <div class="h5 font-weight-bold mb-0">Sebelum Mitigasi</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-white-10" style="background: rgba(255,255,255,0.1); border-radius: 10px;">
                                <div class="text-xs text-uppercase opacity-70">Residual Risk</div>
                                <div class="h5 font-weight-bold mb-0">Setelah Mitigasi</div>
                            </div>
                        </div>
                    </div>
                    <p class="mt-4 mb-0" style="font-size: 0.85rem; background: rgba(0,0,0,0.2); padding: 12px; border-radius: 8px;">
                        <i class="fas fa-info-circle mr-2 text-accent"></i> 
                        Jika <strong>Residual Risk</strong> masih di level "High" atau "Extreme", maka unit kerja wajib menambahkan rencana mitigasi tambahan hingga risiko mencapai level yang dapat diterima (Acceptable).
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 font-weight-bold" style="color: var(--green-dark);"><i class="fas fa-eye mr-2"></i> Daftar Risiko yang Dipantau</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr class="text-xs text-uppercase text-muted">
                                    <th class="px-4">Risiko & Unit</th>
                                    <th>Inherent (Awal)</th>
                                    <th>Residual (Terkini)</th>
                                    <th>Progress Mititgasi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($risks as $risk)
                                @php 
                                    $latestMon = $risk->monitorings->sortByDesc('tanggal_update')->first();
                                    $progress = $latestMon ? $latestMon->progress : 0;
                                @endphp
                                <tr>
                                    <td class="px-4">
                                        <div class="font-weight-bold text-dark">{{ $risk->nama_risiko }}</div>
                                        <div class="text-xs text-muted">{{ $risk->unit->nama_unit ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $risk->level_color }} px-2 py-1" title="Skor: {{ $risk->skor_risiko }}">
                                            {{ $risk->level_risiko }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($latestMon && $latestMon->residual_level)
                                            <span class="badge badge-{{ $latestMon->residual_level == 'Extreme' ? 'danger' : ($latestMon->residual_level == 'High' ? 'warning' : ($latestMon->residual_level == 'Medium' ? 'info' : 'success')) }} px-2 py-1" title="Skor: {{ $latestMon->residual_score }}">
                                                {{ $latestMon->residual_level }}
                                            </span>
                                        @else
                                            <small class="text-muted">Belum Dinilai</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 mr-2" style="height: 6px; border-radius: 10px; background: #edf2f7;">
                                                <div class="progress-bar bg-{{ $progress == 100 ? 'success' : ($progress > 50 ? 'info' : 'primary') }}" 
                                                     role="progressbar" style="width: {{ $progress }}%"></div>
                                            </div>
                                            <small class="font-weight-bold text-{{ $progress == 100 ? 'success' : 'dark' }}">{{ $progress }}%</small>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('risks.show', $risk->id) }}" class="btn btn-sm btn-outline-success shadow-sm" style="border-radius: 20px; font-size: 0.75rem;">
                                            <i class="fas fa-sync-alt mr-1"></i> Update
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="60" class="mb-3 opacity-50">
                                        <p>Belum ada risiko yang perlu dipantau.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($risks->hasPages())
                <div class="card-footer bg-white border-top-0 py-3">
                    {{ $risks->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
