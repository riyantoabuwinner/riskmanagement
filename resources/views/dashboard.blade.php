<x-app-layout>
    @section('title', 'Dashboard')
    @section('page-title', 'Dashboard Analysis Risk Management')
    @section('breadcrumb')
        <li class="breadcrumb-item active">Dashboard</li>
    @endsection

    <!-- Summary Box -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4" style="background: linear-gradient(135deg, var(--green-mid), var(--green-main)); color: #fff;">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="mb-1 font-weight-bold">Selamat Datang, {{ Auth::user()->name }}</h4>
                        @if($isAdmin)
                            <p class="mb-0 opacity-80">Pantau profil risiko Universitas Islam Negeri Syekh Nurjati Cirebon secara real-time.</p>
                        @else
                            <p class="mb-0 opacity-80 font-weight-bold"><i class="fas fa-building mr-1"></i> Data Unit: {{ $unitName ?? 'Internal' }}</p>
                        @endif
                    </div>
                    <div class="text-right">
                        <div class="text-xs text-uppercase opacity-70 mb-1">Total Risiko Tercatat</div>
                        <h2 class="mb-0 font-weight-bold" style="font-size: 2.5rem;">{{ $totalRisks }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Analysis (Heatmap) -->
        <div class="col-lg-7">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold">Risk Heatmap (ISO 31000)</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center">
                        <div class="d-flex w-100 justify-content-center align-items-center mb-4">
                            <!-- Y-axis Label -->
                            <div class="mr-4 text-center" style="writing-mode: vertical-lr; transform: rotate(180deg); font-size: 0.7rem; font-weight: 800; letter-spacing: 2px; color: #64748b;">PROBABILITAS</div>
                            
                            <div class="heatmap-grid" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 4px; padding: 10px; background: #f8fafc; border-radius: 12px; border: 2px solid #e2e8f0;">
                                @for ($p = 5; $p >= 1; $p--)
                                    @for ($d = 1; $d <= 5; $d++)
                                        @php
                                            $score = $p * $d;
                                            $count = $heatmap[$p][$d] ?? 0;
                                            // Mapping colors based on requirements
                                            if ($score >= 16) { $bg = '#ef4444'; $color = '#fff'; } // Extreme
                                            elseif ($score >= 11) { $bg = '#f97316'; $color = '#fff'; } // High
                                            elseif ($score >= 6) { $bg = '#f59e0b'; $color = '#fff'; } // Medium
                                            else { $bg = '#10b981'; $color = '#fff'; } // Low
                                        @endphp
                                        <a href="{{ route('risks.index', ['probabilitas' => $p, 'level_dampak' => $d]) }}" 
                                           class="heatmap-cell" 
                                           style="width: 70px; height: 70px; background: {{ $bg }}; color: {{ $color }}; display: flex; flex-direction: column; align-items: center; justify-content: center; border-radius: 8px; font-weight: 800; cursor: pointer; transition: transform 0.2s; text-decoration: none;"
                                           onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'"
                                           title="Probabilitas: {{ $p }} × Dampak: {{ $d }} = {{ $score }}">
                                            <span style="font-size: 1.2rem;">{{ $count > 0 ? $count : '-' }}</span>
                                            <small style="font-size: 0.6rem; opacity: 0.7;">Skor: {{ $score }}</small>
                                        </a>
                                    @endfor
                                @endfor
                            </div>
                        </div>
                        <!-- X-axis Label -->
                        <div class="text-center w-100" style="font-size: 0.7rem; font-weight: 800; letter-spacing: 2px; color: #64748b; margin-left: 20px;">LEVEL DAMPAK</div>

                        <!-- Legend -->
                        <div class="d-flex justify-content-center mt-4 flex-wrap" style="gap: 20px;">
                            <div class="d-flex align-items-center"><span style="width:14px; height:14px; background:#10b981; border-radius:3px; margin-right:8px;"></span> <span class="text-sm">Low (1-5)</span></div>
                            <div class="d-flex align-items-center"><span style="width:14px; height:14px; background:#f59e0b; border-radius:3px; margin-right:8px;"></span> <span class="text-sm">Medium (6-10)</span></div>
                            <div class="d-flex align-items-center"><span style="width:14px; height:14px; background:#f97316; border-radius:3px; margin-right:8px;"></span> <span class="text-sm">High (11-15)</span></div>
                            <div class="d-flex align-items-center"><span style="width:14px; height:14px; background:#ef4444; border-radius:3px; margin-right:8px;"></span> <span class="text-sm">Extreme (16-25)</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts (Category) -->
        <div class="col-lg-5">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold">Risiko per Kategori</h3>
                </div>
                <div class="card-body">
                    <canvas id="categoryChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold">Risiko per Unit Kerja</h3>
                </div>
                <div class="card-body">
                    <canvas id="unitChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Top 10 Risks Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title font-weight-bold">Top 10 Risiko Tertinggi</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Risiko</th>
                                    <th>Unit</th>
                                    <th>Kategori</th>
                                    <th>Skor</th>
                                    <th>Level</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topRisks as $risk)
                                <tr>
                                    <td class="font-weight-bold" style="color: #1e293b;">{{ $risk->nama_risiko }}</td>
                                    <td>{{ $risk->unit->nama_unit ?? '-' }}</td>
                                    <td>{{ $risk->kategori->nama_kategori ?? '-' }}</td>
                                    <td><span class="badge badge-light px-3 py-2" style="font-size: 0.9rem;">{{ $risk->skor_risiko }}</span></td>
                                    <td>
                                        <span class="badge badge-{{ $risk->level_color }} px-2 py-1">
                                            {{ $risk->level_risiko ?? 'Low' }}
                                        </span>
                                    </td>
                                    <td>{{ $risk->status }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Category Chart
        const ctxCat = document.getElementById('categoryChart').getContext('2d');
        new Chart(ctxCat, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($chartCategory['labels']) !!},
                datasets: [{
                    data: {!! json_encode($chartCategory['data']) !!},
                    backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444', '#8b5cf6', '#64748b'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });

        // Unit Chart
        const ctxUnit = document.getElementById('unitChart').getContext('2d');
        new Chart(ctxUnit, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartUnit['labels']) !!},
                datasets: [{
                    label: 'Jumlah Risiko',
                    data: {!! json_encode($chartUnit['data']) !!},
                    backgroundColor: 'rgba(5, 150, 105, 0.7)',
                    borderColor: '#059669',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } },
                plugins: { legend: { display: false } }
            }
        });
    </script>
    @endpush
</x-app-layout>
