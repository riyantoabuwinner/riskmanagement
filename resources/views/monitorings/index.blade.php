<x-app-layout>
    @section('title', 'Monitoring Risiko')
    @section('page-title', 'Monitoring & Realisasi Risiko')
    @section('breadcrumb')
        <li class="breadcrumb-item active">Monitoring</li>
    @endsection

    <!-- Monitoring Analytics Row -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0" style="border-radius: 15px; border-left: 5px solid var(--green-main) !important;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="mr-3 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fas fa-clipboard-list text-primary"></i>
                        </div>
                        <div>
                            <h4 class="font-weight-bold mb-0 text-dark">{{ $totalRisks }}</h4>
                            <small class="text-muted font-weight-bold">TOTAL MONITORING</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0" style="border-radius: 15px; border-left: 5px solid #10b981 !important;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="mr-3 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fas fa-check-double text-success"></i>
                        </div>
                        <div>
                            <h4 class="font-weight-bold mb-0 text-success">{{ $completed }}</h4>
                            <small class="text-muted font-weight-bold">MITIGASI SELESAI</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0" style="border-radius: 15px; border-left: 5px solid #3b82f6 !important;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="mr-3 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fas fa-tasks text-info"></i>
                        </div>
                        <div>
                            <h4 class="font-weight-bold mb-0 text-info">{{ $avgProgress }}%</h4>
                            <small class="text-muted font-weight-bold">AVG. PROGRESS</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0" style="border-radius: 15px; border-left: 5px solid #ef4444 !important;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="mr-3 bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fas fa-radiation text-danger"></i>
                        </div>
                        <div>
                            <h4 class="font-weight-bold mb-0 text-danger">{{ $levelDistribution['Extreme'] }}</h4>
                            <small class="text-muted font-weight-bold">EXTREME RESIDUAL</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Residual Risk Map -->
        <div class="col-xl-4 mb-4">
            <div class="card shadow-sm border-0" style="border-radius: 15px; height: 100%;">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="font-weight-bold text-dark mb-0"><i class="fas fa-map-marked-alt mr-2 text-primary"></i> Peta Risiko Terkini (Residual)</h6>
                </div>
                <div class="card-body">
                    <div class="heatmap-grid mb-4" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 4px; border-left: 2px solid #e2e8f0; border-bottom: 2px solid #e2e8f0; padding: 4px;">
                        @for($p = 5; $p >= 1; $p--)
                            @for($d = 1; $d <= 5; $d++)
                                @php
                                    $score = $p * $d;
                                    $risksInCell = $residualMatrix[$p][$d] ?? collect();
                                    $count = $risksInCell->count();
                                    $names = $risksInCell->pluck('nama_risiko')->map(fn($n) => '• '.$n)->join('<br>');
                                    $bg = '#f8fafc'; $col = '#64748b';
                                    if ($score >= 16) { $bg = '#fee2e2'; $col = '#ef4444'; }
                                    elseif ($score >= 12) { $bg = '#ffedd5'; $col = '#f97316'; }
                                    elseif ($score >= 6) { $bg = '#fef9c3'; $col = '#f59e0b'; }
                                    elseif ($score >= 1) { $bg = '#ecfdf5'; $col = '#10b981'; }
                                @endphp
                                <div class="d-flex align-items-center justify-content-center"
                                     style="width: 100%; aspect-ratio: 1; background: {{ $bg }}; color: {{ $col }}; border-radius: 4px; font-weight: 800; font-size: 0.75rem; border: 1px solid rgba(0,0,0,0.03); cursor: help;"
                                     data-toggle="tooltip" data-html="true" title="<b>Residual Score {{ $score }}</b><br>{{ $names ?: 'Tidak ada risiko' }}">
                                    {{ $count > 0 ? $count : '' }}
                                </div>
                            @endfor
                        @endfor
                    </div>
                    
                    <div class="p-3 bg-light rounded" style="border-radius: 10px;">
                        <h6 class="text-xs font-weight-bold text-muted text-uppercase mb-2">Sebaran Level Residual</h6>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-xs font-weight-bold text-danger">EXTREME</span>
                            <span class="text-xs font-weight-bold">{{ $levelDistribution['Extreme'] }}</span>
                        </div>
                        <div class="progress mb-2" style="height: 4px;"><div class="progress-bar bg-danger" style="width: {{ $totalRisks > 0 ? ($levelDistribution['Extreme']/$totalRisks)*100 : 0 }}%"></div></div>
                        
                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-xs font-weight-bold text-warning">HIGH</span>
                            <span class="text-xs font-weight-bold">{{ $levelDistribution['High'] }}</span>
                        </div>
                        <div class="progress mb-2" style="height: 4px;"><div class="progress-bar bg-warning" style="width: {{ $totalRisks > 0 ? ($levelDistribution['High']/$totalRisks)*100 : 0 }}%"></div></div>

                        <div class="d-flex justify-content-between mb-1">
                            <span class="text-xs font-weight-bold text-success">LOW/MEDIUM</span>
                            <span class="text-xs font-weight-bold">{{ $levelDistribution['Low'] + $levelDistribution['Medium'] }}</span>
                        </div>
                        <div class="progress" style="height: 4px;"><div class="progress-bar bg-success" style="width: {{ $totalRisks > 0 ? (($levelDistribution['Low']+$levelDistribution['Medium'])/$totalRisks)*100 : 0 }}%"></div></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monitoring List Table -->
        <div class="col-xl-8 mb-4">
            <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title font-weight-bold mb-0 text-dark">
                        <i class="fas fa-eye mr-2 text-primary"></i> Realisasi & Pengawasan Risiko
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="text-xs text-uppercase text-muted" style="background: #fafafa;">
                                    <th class="px-4">Uraian Risiko</th>
                                    <th class="text-center">Progress</th>
                                    <th class="text-center">Posisi (Inh → Res)</th>
                                    <th class="text-center">Update</th>
                                    <th class="px-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($risks as $risk)
                                @php
                                    $latest = $risk->monitorings->first();
                                    $progress = $latest ? $latest->progress : 0;
                                    $resScore = $latest ? ($latest->residual_probabilitas * $latest->residual_impact) : $risk->skor_risiko;
                                    $resLvl = $latest ? \App\Http\Controllers\RiskEvaluationController::calculateLevel($resScore) : $risk->level_risiko;
                                @endphp
                                <tr>
                                    <td class="px-4">
                                        <div class="font-weight-bold text-dark">{{ $risk->nama_risiko }}</div>
                                        <div class="text-xs text-muted mb-1">{{ $risk->unit->nama_unit ?? '-' }}</div>
                                        @if($latest && $latest->catatan)
                                            <div class="text-xs font-italic text-muted truncate-2" title="{{ $latest->catatan }}">
                                                "{{ Str::limit($latest->catatan, 60) }}"
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center" style="width: 140px;">
                                        <div class="progress shadow-sm" style="height: 6px; border-radius: 3px;">
                                            <div class="progress-bar bg-{{ $progress == 100 ? 'success' : ($progress >= 50 ? 'info' : 'warning') }}" 
                                                 role="progressbar" style="width: {{ $progress }}%"></div>
                                        </div>
                                        <div class="text-xs mt-1 font-weight-bold {{ $progress == 100 ? 'text-success' : 'text-muted' }}">{{ $progress }}%</div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex align-items-center justify-content-center" style="gap: 8px;">
                                            <span class="badge badge-{{ $risk->level_color }} px-2 py-1" style="min-width: 50px;">{{ $risk->skor_risiko }}</span>
                                            <i class="fas fa-long-arrow-alt-right text-muted"></i>
                                            <span class="badge badge-{{ strtolower($resLvl) == 'extreme' ? 'danger' : (strtolower($resLvl) == 'high' ? 'warning' : (strtolower($resLvl) == 'medium' ? 'primary' : 'success')) }} px-2 py-1" style="min-width: 50px;">
                                                {{ $resScore }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="text-xs text-dark font-weight-bold">{{ $latest ? \Carbon\Carbon::parse($latest->tanggal_update)->format('d/m/Y') : '-' }}</div>
                                        <div class="text-xs text-muted">Update Terakhir</div>
                                    </td>
                                    <td class="px-4 text-right">
                                        <div class="btn-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                            <a href="{{ route('risks.show', $risk) }}" class="btn btn-sm btn-white border-right" title="Detail"><i class="fas fa-eye text-primary"></i></a>
                                            <a href="{{ route('monitorings.create', ['risk_id' => $risk->id]) }}" class="btn btn-sm btn-white" title="Input Update"><i class="fas fa-plus-circle text-success"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada data risiko.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip({ container: 'body' });
        });
    </script>
    @endpush
</x-app-layout>
