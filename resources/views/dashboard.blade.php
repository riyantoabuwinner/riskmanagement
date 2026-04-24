<x-app-layout>
    @section('title', 'Dashboard')
    @section('page-title', 'Dashboard Overview')
    @section('breadcrumb')
        <li class="breadcrumb-item active">Dashboard</li>
    @endsection

    @push('styles')
    <style>
        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.04);
            border: 1px solid #f1f5f9;
            transition: transform 0.3s ease;
            height: 100%;
        }
        .stat-card:hover { transform: translateY(-5px); }
        .stat-label { font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; }
        .stat-value { font-size: 1.8rem; font-weight: 800; color: #1e293b; margin: 8px 0; }
        .stat-sub { font-size: 0.75rem; font-weight: 600; color: #64748b; }
        .stat-trend-up { color: #10b981; }
        .stat-trend-down { color: #ef4444; }

        .dashboard-header {
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .dashboard-header h1 { font-size: 1.5rem; font-weight: 700; color: #1e293b; }
        .dashboard-date { color: #64748b; font-size: 0.9rem; }

        .card-detailed {
            background: #fff;
            border-radius: 16px;
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.04);
            overflow: hidden;
            margin-bottom: 24px;
        }
        .card-detailed .card-header {
            background: #fff;
            padding: 20px 24px;
            border-bottom: 1px solid #f1f5f9;
        }
        .card-detailed .card-title {
            font-size: 0.9rem;
            font-weight: 700;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .risk-table th {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            border-top: none !important;
            padding: 16px 24px !important;
        }
        .risk-table td {
            padding: 16px 24px !important;
            font-size: 0.85rem;
            color: #334155;
            vertical-align: middle !important;
        }
        .status-badge {
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
        }
        .status-active { background: #f0fdf4; color: #10b981; }

        .heatmap-mini {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 4px;
        }
        .heatmap-mini-cell {
            width: 100%;
            aspect-ratio: 1;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            font-weight: 700;
            color: rgba(255,255,255,0.9);
        }

        .task-item {
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .task-item:last-child { border-bottom: none; }
        .task-title { font-size: 0.85rem; font-weight: 600; color: #334155; }
        .task-due { font-size: 0.75rem; color: #94a3b8; }
    </style>
    @endpush

    <div class="dashboard-header">
        <div>
            <h1>Dashboard Overview <span class="badge badge-light ml-2" style="font-weight: 400; font-size: 0.7rem;">Inter, Semi-Bold</span></h1>
        </div>
        <div class="dashboard-date">
            <i class="far fa-calendar-alt mr-2"></i> {{ now()->format('F d, Y') }}
        </div>
    </div>

    <!-- Top Statistics Row -->
    <div class="row mb-4">
        <div class="col-md-3">
            <a href="{{ route('risks.index') }}" class="text-decoration-none h-100 d-block">
                <div class="stat-card clickable-card">
                    <div class="stat-label">Total Risks</div>
                    <div class="d-flex align-items-end justify-content-between">
                        <div>
                            <div class="stat-value">{{ $totalRisks }}</div>
                            <div class="stat-sub"><span class="stat-trend-up">+5%</span> vs Sept</div>
                        </div>
                        <div style="width: 80px; height: 40px;">
                            <canvas id="totalRisksSparkline"></canvas>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('mitigations.index') }}" class="text-decoration-none h-100 d-block">
                <div class="stat-card clickable-card">
                    <div class="stat-label">Mitigation Progress</div>
                    <div class="d-flex align-items-end justify-content-between">
                        <div>
                            <div class="stat-value">{{ round($avgProgress) }}%</div>
                            <div class="stat-sub">32 Plans Active</div>
                        </div>
                        <div style="width: 50px; height: 50px; position: relative;">
                            <canvas id="progressCircle"></canvas>
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 0.6rem; font-weight: 700; color: #64748b;">{{ round($avgProgress) }}%</div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('risks.index', ['status' => 'Approved']) }}" class="text-decoration-none h-100 d-block">
                <div class="stat-card clickable-card">
                    <div class="stat-label">Open Incidents</div>
                    <div class="d-flex align-items-end justify-content-between">
                        <div>
                            <div class="stat-value">{{ $openIncidents }}</div>
                            <div class="stat-sub">3 High Priority</div>
                        </div>
                        <div class="bg-warning-light p-2 rounded-lg text-warning">
                            <i class="fas fa-exclamation-triangle fa-lg"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('performance-indicators.index') }}" class="text-decoration-none h-100 d-block">
                <div class="stat-card clickable-card">
                    <div class="stat-label">Key Risk Indicators (KRI)</div>
                    <div class="d-flex align-items-end justify-content-between">
                        <div>
                            <div class="stat-value">{{ $kriCount }}</div>
                            <div class="stat-sub">2 Critical Status</div>
                        </div>
                        <div style="width: 80px; height: 40px;">
                            <canvas id="kriSparkline"></canvas>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Risk Register Table -->
        <div class="col-lg-8">
            <div class="card-detailed">
                <div class="card-header">
                    <h3 class="card-title">Active Risk Register</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table risk-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Impact</th>
                                    <th>Score</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topRisks->take(5) as $risk)
                                <tr>
                                    <td class="font-weight-bold text-muted" style="font-size: 0.7rem;">R0{{ $risk->id }}</td>
                                    <td class="font-weight-bold">{{ $risk->nama_risiko }}</td>
                                    <td>{{ $risk->kategori->nama_kategori ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-light text-capitalize">{{ $risk->level_risiko }}</span>
                                    </td>
                                    <td class="font-weight-bold">{{ $risk->skor_risiko }}</td>
                                    <td>
                                        <span class="status-badge status-active">{{ $risk->status }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card-detailed">
                <div class="card-header">
                    <h3 class="card-title">Mitigation Performance</h3>
                </div>
                <div class="card-body">
                    <div style="height: 300px;">
                        <canvas id="performanceChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Widgets -->
        <div class="col-lg-4">
            <!-- Inherent Heatmap -->
            <div class="card-detailed">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Inherent Risk Map</h3>
                    <span class="badge badge-light" style="font-size: 0.6rem;">INITIAL</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-auto pr-0 d-flex flex-column justify-content-between py-1" style="font-size: 0.6rem; font-weight: 700; color: #94a3b8;">
                            <span>High</span>
                            <span>Med</span>
                            <span>Low</span>
                        </div>
                        <div class="col">
                            <div class="heatmap-mini">
                                @for($p = 5; $p >= 1; $p--)
                                    @for($d = 1; $d <= 5; $d++)
                                        @php
                                            $score = $p * $d;
                                            $count = $heatmapInherent[$p][$d] ?? 0;
                                            $risks = $risksInCellInherent[$p][$d] ?? [];
                                            $riskList = count($risks) > 0 ? implode('<br>• ', array_map('e', $risks)) : 'No risks';
                                            $tooltipContent = "<b>Probabilitas: $p | Dampak: $d</b><br>Daftar Risiko:<br>• $riskList";
                                            $bg = ($score >= 16) ? '#ef4444' : (($score >= 11) ? '#f97316' : (($score >= 6) ? '#f59e0b' : '#10b981'));
                                        @endphp
                                        <div class="heatmap-mini-cell" 
                                             style="background: {{ $bg }}; opacity: {{ $count > 0 ? '1' : '0.15' }}; cursor: pointer;"
                                             data-toggle="tooltip" 
                                             data-html="true"
                                             title="{!! $tooltipContent !!}">
                                            @if($count > 0) {{ $count }} @endif
                                        </div>
                                    @endfor
                                @endfor
                            </div>
                            <div class="d-flex justify-content-between mt-2 px-1" style="font-size: 0.6rem; font-weight: 700; color: #94a3b8;">
                                <span>1</span><span>2</span><span>3</span><span>4</span><span>5</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Residual Heatmap -->
            <div class="card-detailed">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Residual Risk Map</h3>
                    <span class="badge badge-success" style="font-size: 0.6rem;">CURRENT</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-auto pr-0 d-flex flex-column justify-content-between py-1" style="font-size: 0.6rem; font-weight: 700; color: #94a3b8;">
                            <span>High</span>
                            <span>Med</span>
                            <span>Low</span>
                        </div>
                        <div class="col">
                            <div class="heatmap-mini">
                                @for($p = 5; $p >= 1; $p--)
                                    @for($d = 1; $d <= 5; $d++)
                                        @php
                                            $score = $p * $d;
                                            $count = $heatmapResidual[$p][$d] ?? 0;
                                            $risks = $risksInCellResidual[$p][$d] ?? [];
                                            $riskList = count($risks) > 0 ? implode('<br>• ', array_map('e', $risks)) : 'No risks';
                                            $tooltipContent = "<b>Probabilitas: $p | Dampak: $d (Residual)</b><br>Daftar Risiko:<br>• $riskList";
                                            $bg = ($score >= 16) ? '#ef4444' : (($score >= 11) ? '#f97316' : (($score >= 6) ? '#f59e0b' : '#10b981'));
                                        @endphp
                                        <div class="heatmap-mini-cell" 
                                             style="background: {{ $bg }}; opacity: {{ $count > 0 ? '1' : '0.15' }}; cursor: pointer;"
                                             data-toggle="tooltip" 
                                             data-html="true"
                                             title="{!! $tooltipContent !!}">
                                            @if($count > 0) {{ $count }} @endif
                                        </div>
                                    @endfor
                                @endfor
                            </div>
                            <div class="d-flex justify-content-between mt-2 px-1" style="font-size: 0.6rem; font-weight: 700; color: #94a3b8;">
                                <span>1</span><span>2</span><span>3</span><span>4</span><span>5</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Critical Tasks -->
            <div class="card-detailed">
                <div class="card-header">
                    <h3 class="card-title">Critical Mitigation Tasks</h3>
                </div>
                <div class="card-body pt-0">
                    @foreach($criticalTasks as $task)
                    <div class="task-item">
                        <div>
                            <div class="task-title">{{ Str::limit($task->nama_mitigasi, 35) }}</div>
                            <small class="text-muted">{{ $task->risk->nama_risiko }}</small>
                        </div>
                        <div class="task-due">Due {{ $task->target_waktu ? \Carbon\Carbon::parse($task->target_waktu)->format('d M') : 'N/A' }}</div>
                    </div>
                    @endforeach
                    <div class="mt-3">
                        <a href="{{ route('mitigations.index') }}" class="btn btn-sm btn-block btn-light text-muted font-weight-bold" style="font-size: 0.7rem;">VIEW ALL TASKS</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        Chart.defaults.font.family = "'Inter', sans-serif";

        // Sparklines
        const sparklineOptions = {
            responsive: true,
            maintainAspectRatio: false,
            elements: { point: { radius: 0 }, line: { tension: 0.4, borderWidth: 2 } },
            scales: { x: { display: false }, y: { display: false } },
            plugins: { legend: { display: false }, tooltip: { enabled: false } }
        };

        new Chart(document.getElementById('totalRisksSparkline').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['1', '2', '3', '4', '5', '6', '7'],
                datasets: [{ data: [12, 19, 3, 5, 2, 3, 9], backgroundColor: '#eab308' }]
            },
            options: sparklineOptions
        });

        new Chart(document.getElementById('kriSparkline').getContext('2d'), {
            type: 'line',
            data: {
                labels: ['1', '2', '3', '4', '5', '6', '7'],
                datasets: [{ data: [12, 15, 10, 18, 14, 20, 18], borderColor: '#eab308', fill: false }]
            },
            options: sparklineOptions
        });

        // Progress Circle
        new Chart(document.getElementById('progressCircle').getContext('2d'), {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [{{ $avgProgress }}, {{ 100 - $avgProgress }}],
                    backgroundColor: ['#eab308', '#f1f5f9'],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '80%',
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { enabled: false } }
            }
        });

        // Performance Area Chart
        const perfCtx = document.getElementById('performanceChart').getContext('2d');
        const gradient = perfCtx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(234, 179, 8, 0.4)');
        gradient.addColorStop(1, 'rgba(234, 179, 8, 0)');

        new Chart(perfCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($mitigationPerformance['labels']) !!},
                datasets: [{
                    label: 'Monitoring Activity',
                    data: {!! json_encode($mitigationPerformance['data']) !!},
                    borderColor: '#eab308',
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#eab308',
                    pointBorderWidth: 2,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { grid: { borderDash: [5, 5] }, beginAtZero: true },
                    x: { grid: { display: false } }
                }
            }
        });

        // Initialize Bootstrap Tooltips
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    @endpush
</x-app-layout>
