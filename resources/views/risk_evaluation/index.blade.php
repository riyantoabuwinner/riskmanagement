<x-app-layout>
    @section('title', 'Analisis & Evaluasi')
    @section('page-title', 'Analisis & Evaluasi Risiko (ISO 31000)')
    @section('breadcrumb')
        <li class="breadcrumb-item active">Evaluasi</li>
    @endsection

    <!-- Summary Analytics Row -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 bg-primary text-white" style="border-radius: 12px;">
                <div class="card-body">
                    <small class="text-white-50 font-weight-bold d-block mb-1">TOTAL RISIKO</small>
                    <h3 class="font-weight-bold mb-0">{{ $inherentDist['Extreme'] + $inherentDist['High'] + $inherentDist['Medium'] + $inherentDist['Low'] }}</h3>
                    <div class="mt-2 text-xs text-white-50">Keseluruhan Identifikasi</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 bg-info text-white" style="border-radius: 12px;">
                <div class="card-body">
                    <small class="text-white-50 font-weight-bold d-block mb-1">DATA TERMONITOR</small>
                    <h3 class="font-weight-bold mb-0">{{ $monitoredCount }}</h3>
                    <div class="mt-2 text-xs text-white-50">{{ count($inherentDist) > 0 ? round(($monitoredCount / max(1, array_sum($inherentDist))) * 100, 1) : 0 }}% Compliance Rate</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 bg-success text-white" style="border-radius: 12px;">
                <div class="card-body">
                    <small class="text-white-50 font-weight-bold d-block mb-1">AVG. SCORE REDUCTION</small>
                    <h3 class="font-weight-bold mb-0">-{{ $avgReduction }}</h3>
                    <div class="mt-2 text-xs text-white-50">Efektivitas Mitigasi</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-3 mb-xl-0">
            <div class="card shadow-sm border-0 bg-danger text-white" style="border-radius: 12px;">
                <div class="card-body">
                    <small class="text-white-50 font-weight-bold d-block mb-1">RESIDUAL EXTREME</small>
                    <h3 class="font-weight-bold mb-0">{{ $residualDist['Extreme'] }}</h3>
                    <div class="mt-2 text-xs text-white-50">Butuh Penanganan Segera</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Heatmaps Row -->
        <div class="col-xl-12 mb-4">
            <div class="card shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-lg-6 border-right pr-4">
                            <h6 class="font-weight-bold text-dark mb-4 text-uppercase"><i class="fas fa-history mr-2 text-muted"></i> Peta Risiko Inherent</h6>
                            <div class="d-flex flex-column align-items-center">
                                <div class="heatmap-grid" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 4px;">
                                    @for($p = 5; $p >= 1; $p--)
                                        @for($d = 1; $d <= 5; $d++)
                                            @php
                                                $score = $p * $d;
                                                $risksInCell = $inherentMatrix[$p][$d] ?? collect();
                                                $count = $risksInCell->count();
                                                $names = $risksInCell->pluck('nama_risiko')->map(fn($n) => '• '.$n)->join("<br>");
                                                $bg = '#f8fafc'; $col = '#64748b';
                                                if ($score >= 16) { $bg = '#fee2e2'; $col = '#ef4444'; }
                                                elseif ($score >= 12) { $bg = '#ffedd5'; $col = '#f97316'; }
                                                elseif ($score >= 6) { $bg = '#fef9c3'; $col = '#f59e0b'; }
                                                elseif ($score >= 1) { $bg = '#ecfdf5'; $col = '#10b981'; }
                                            @endphp
                                            <div class="d-flex align-items-center justify-content-center heatmap-cell"
                                                 style="width: 55px; height: 55px; background: {{ $bg }}; color: {{ $col }}; border-radius: 6px; font-weight: 800; border: 1px solid rgba(0,0,0,0.05); cursor: help;"
                                                 data-toggle="tooltip" data-html="true" title="<b>Skor {{ $score }}</b><br>{{ $names ?: 'Tidak ada risiko' }}">
                                                {{ $count > 0 ? $count : '' }}
                                            </div>
                                        @endfor
                                    @endfor
                                </div>
                                <div class="mt-4 w-100">
                                    <table class="table table-sm text-xs font-weight-bold mb-0">
                                        @foreach(['Extreme' => '#ef4444', 'High' => '#f97316', 'Medium' => '#f59e0b', 'Low' => '#10b981'] as $lvl => $clr)
                                            <tr>
                                                <td class="pl-0"><span class="rounded-circle d-inline-block mr-2" style="width: 8px; height: 8px; background: {{ $clr }};"></span>{{ $lvl }}</td>
                                                <td class="text-right">{{ $inherentDist[$lvl] }} Risiko</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 pl-4">
                            <h6 class="font-weight-bold text-dark mb-4 text-uppercase"><i class="fas fa-bullseye mr-2 text-primary"></i> Peta Risiko Residual</h6>
                            <div class="d-flex flex-column align-items-center">
                                <div class="heatmap-grid" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 4px;">
                                    @for($p = 5; $p >= 1; $p--)
                                        @for($d = 1; $d <= 5; $d++)
                                            @php
                                                $score = $p * $d;
                                                $risksInCell = $residualMatrix[$p][$d] ?? collect();
                                                $count = $risksInCell->count();
                                                $names = $risksInCell->pluck('nama_risiko')->map(fn($n) => '• '.$n)->join("<br>");
                                                $bg = '#f8fafc'; $col = '#64748b';
                                                if ($score >= 16) { $bg = '#fee2e2'; $col = '#ef4444'; }
                                                elseif ($score >= 12) { $bg = '#ffedd5'; $col = '#f97316'; }
                                                elseif ($score >= 6) { $bg = '#fef9c3'; $col = '#f59e0b'; }
                                                elseif ($score >= 1) { $bg = '#ecfdf5'; $col = '#10b981'; }
                                            @endphp
                                            <div class="d-flex align-items-center justify-content-center heatmap-cell"
                                                 style="width: 55px; height: 55px; background: {{ $bg }}; color: {{ $col }}; border-radius: 6px; font-weight: 800; border: 1px solid rgba(0,0,0,0.05); cursor: help;"
                                                 data-toggle="tooltip" data-html="true" title="<b>Skor {{ $score }}</b><br>{{ $names ?: 'Tidak ada risiko' }}">
                                                {{ $count > 0 ? $count : '' }}
                                            </div>
                                        @endfor
                                    @endfor
                                </div>
                                <div class="mt-4 w-100">
                                    <table class="table table-sm text-xs font-weight-bold mb-0">
                                        @foreach(['Extreme' => '#ef4444', 'High' => '#f97316', 'Medium' => '#f59e0b', 'Low' => '#10b981'] as $lvl => $clr)
                                            <tr>
                                                <td class="pl-0">
                                                    <span class="rounded-circle d-inline-block mr-2" style="width: 8px; height: 8px; background: {{ $clr }};"></span>{{ $lvl }}
                                                </td>
                                                <td class="text-right">
                                                    {{ $residualDist[$lvl] }} Risiko
                                                    @php $delta = $residualDist[$lvl] - $inherentDist[$lvl]; @endphp
                                                    @if($delta != 0)
                                                        <span class="ml-1 {{ $delta < 0 ? 'text-success' : 'text-danger' }}">({{ $delta > 0 ? '+' : '' }}{{ $delta }})</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Table -->
        <div class="col-md-12">
            <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title font-weight-bold mb-0 text-dark">
                        <i class="fas fa-clipboard-check mr-2 text-success"></i> Matriks Evaluasi & Evaluasi Efektivitas
                    </h5>
                    <div class="badge badge-light border px-3 py-2 text-muted">
                        <i class="fas fa-clock mr-1"></i> Terakhir Diperbarui: {{ now()->format('d M Y') }}
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="text-xs text-uppercase text-muted" style="background: #fafafa;">
                                    <th class="px-4">Uraian Risiko & Unit Kerja</th>
                                    <th class="text-center">Inherent Level</th>
                                    <th class="text-center">Residual Level</th>
                                    <th class="text-center">Delta Score</th>
                                    <th class="text-center">Progress</th>
                                    <th class="px-4 text-right">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingRisks as $risk)
                                @php
                                    $latest = $risk->monitorings->first();
                                    $residualScore = $latest ? ($latest->residual_probabilitas * $latest->residual_impact) : $risk->skor_risiko;
                                    $delta = $risk->skor_risiko - $residualScore;
                                    $resLvl = $latest ? \App\Http\Controllers\RiskEvaluationController::calculateLevel($residualScore) : $risk->level_risiko;
                                @endphp
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="font-weight-bold text-dark mb-1">{{ $risk->nama_risiko }}</div>
                                        <div class="text-xs text-muted mb-2"><i class="fas fa-building mr-1"></i> {{ $risk->unit->nama_unit ?? '-' }}</div>
                                        @if($latest && $latest->catatan)
                                            <div class="p-2 bg-light rounded text-xs text-muted border-left" style="border-left: 3px solid var(--green-main) !important;">
                                                <i class="fas fa-comment-dots mr-1"></i> <b>Catatan Terakhir:</b> {{ Str::limit($latest->catatan, 100) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-{{ $risk->level_color }} px-2 py-1">{{ $risk->level_risiko }} ({{ $risk->skor_risiko }})</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-{{ strtolower($resLvl) == 'extreme' ? 'danger' : (strtolower($resLvl) == 'high' ? 'warning' : (strtolower($resLvl) == 'medium' ? 'primary' : 'success')) }} px-2 py-1">
                                            {{ $resLvl }} ({{ $residualScore }})
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="font-weight-bold {{ $delta > 0 ? 'text-success' : ($delta < 0 ? 'text-danger' : 'text-muted') }}">
                                            {{ $delta > 0 ? '▼' : ($delta < 0 ? '▲' : '▬') }} {{ abs($delta) }}
                                        </span>
                                    </td>
                                    <td class="text-center" style="width: 120px;">
                                        <div class="progress shadow-sm" style="height: 6px; border-radius: 3px;">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $latest->progress ?? 0 }}%"></div>
                                        </div>
                                        <div class="text-xs mt-1 text-muted">{{ $latest->progress ?? 0 }}%</div>
                                    </td>
                                    <td class="px-4 text-right">
                                        <div class="btn-group shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                            <a href="{{ route('risks.show', $risk) }}" class="btn btn-sm btn-white border-right" title="Detail"><i class="fas fa-eye text-primary"></i></a>
                                            <a href="{{ route('monitorings.create', ['risk_id' => $risk->id]) }}" class="btn btn-sm btn-white" title="Monitoring Baru"><i class="fas fa-chart-line text-success"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="fas fa-folder-open fa-3x text-muted opacity-20 mb-3"></i>
                                            <p class="text-muted">Belum ada data evaluasi risiko yang tersedia.</p>
                                        </div>
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
    @push('scripts')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip({
                container: 'body'
            });
        });
    </script>
    @endpush
</x-app-layout>
