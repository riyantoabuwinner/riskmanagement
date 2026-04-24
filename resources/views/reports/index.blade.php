<x-app-layout>
    @section('title', 'Laporan & Export')
    @section('page-title', 'Pusat Pelaporan & Dokumentasi')
    @section('breadcrumb')
        <li class="breadcrumb-item active">Laporan</li>
    @endsection

    <div class="row">
        <!-- Filter Card -->
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm border-0 overflow-hidden" style="border-radius: 15px;">
                <div class="card-header border-0 py-3 d-flex justify-content-between align-items-center"
                    style="background: linear-gradient(135deg, #064E3B 0%, #065F46 100%);">
                    <h5 class="card-title font-weight-bold mb-0 text-white"><i class="fas fa-filter mr-2"></i> Parameter
                        Laporan Risiko</h5>
                    <div class="header-actions">
                        <button type="button" onclick="exportReport('pdf')"
                            class="btn btn-sm btn-danger px-3 shadow-sm border-0">
                            <i class="fas fa-file-pdf mr-1"></i> PDF
                        </button>
                        <button type="button" onclick="exportReport('excel')"
                            class="btn btn-sm btn-success px-3 shadow-sm border-0 ml-2"
                            style="background-color: #059669;">
                            <i class="fas fa-file-excel mr-1"></i> Excel
                        </button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form id="report-form" method="GET" action="{{ route('reports.index') }}">
                        <input type="hidden" name="view" value="1">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label class="text-xs font-weight-bold text-muted text-uppercase mb-2">Unit
                                        Kerja</label>
                                    <select name="unit_id" class="form-control bg-light select2" data-placeholder="Pilih Unit Kerja">
                                        <option value="all" {{ request('unit_id') == 'all' ? 'selected' : '' }}>-- SEMUA UNIT KERJA --</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}" {{ request('unit_id') == $unit->id ? 'selected' : '' }}>
                                                {{ $unit->nama_unit }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-0">
                                    <label class="text-xs font-weight-bold text-muted text-uppercase mb-2">Status
                                        Risiko</label>
                                    <select name="status" class="form-control bg-light">
                                        <option value="">-- SEMUA STATUS --</option>
                                        <option value="Draft" {{ request('status') == 'Draft' ? 'selected' : '' }}>Draft
                                        </option>
                                        <option value="Submitted" {{ request('status') == 'Submitted' ? 'selected' : '' }}>Submitted</option>
                                        <option value="Reviewed" {{ request('status') == 'Reviewed' ? 'selected' : '' }}>
                                            Reviewed</option>
                                        <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>
                                            Approved</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-0">
                                    <label class="text-xs font-weight-bold text-muted text-uppercase mb-2">Dari
                                        Tanggal</label>
                                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                                        class="form-control bg-light">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group mb-0">
                                    <label class="text-xs font-weight-bold text-muted text-uppercase mb-2">Sampai
                                        Tanggal</label>
                                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                                        class="form-control bg-light">
                                </div>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary btn-block shadow-sm font-weight-bold">
                                    <i class="fas fa-search mr-1"></i> Lihat Laporan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Chart Category Section -->
        <div class="col-md-12 mb-4">
            <div class="row">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <div class="card shadow-sm border-0" style="border-radius: 12px; height: 100%;">
                        <div class="card-header bg-white py-3">
                            <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-chart-bar mr-2 text-success"></i> Grafik Distribusi Risiko per Kategori</h6>
                        </div>
                        <div class="card-body">
                            <div style="height: 300px;">
                                <canvas id="categoryChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card shadow-sm border-0" style="border-radius: 12px; height: 100%;">
                        <div class="card-header bg-white py-3">
                            <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-list-ol mr-2 text-info"></i> Rekapitulasi Per Kategori</h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="px-3 py-2 text-xs text-uppercase text-muted">Kategori</th>
                                            <th class="px-3 py-2 text-xs text-uppercase text-muted text-center">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $totalRisks = 0; @endphp
                                        @foreach($categoryStats as $stat)
                                            @php $totalRisks += $stat->risks_count; @endphp
                                            <tr>
                                                <td class="px-3 small font-weight-bold">{{ $stat->nama_kategori }}</td>
                                                <td class="px-3 small text-center"><span class="badge badge-pill badge-light border">{{ $stat->risks_count }}</span></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-light">
                                        <tr>
                                            <th class="px-3 font-weight-bold text-dark text-xs">TOTAL RISIKO</th>
                                            <th class="px-3 text-center text-dark text-xs">{{ $totalRisks }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Indicator Section (Segmented) -->
        @foreach($indicatorStats as $type => $group)
            <div class="col-md-12 mb-5">
                <div class="row">
                    <div class="col-lg-8 mb-4 mb-lg-0">
                        <div class="card shadow-sm border-0" style="border-radius: 12px; height: 100%;">
                            <div class="card-header bg-white py-3">
                                <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-chart-pie mr-2 text-primary"></i> Dampak Risiko terhadap {{ $type }}</h6>
                            </div>
                            <div class="card-body">
                                <div style="height: 300px;">
                                    <canvas id="chart-{{ \Illuminate\Support\Str::slug($type) }}"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card shadow-sm border-0" style="border-radius: 12px; height: 100%;">
                            <div class="card-header bg-white py-3">
                                <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-list-ol mr-2 text-danger"></i> Rincian {{ $type }}</h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                    <table class="table table-sm table-hover mb-0">
                                        <thead class="bg-light" style="position: sticky; top: 0; z-index: 1;">
                                            <tr>
                                                <th class="px-3 py-2 text-xs text-uppercase text-muted">Kode / Indikator</th>
                                                <th class="px-3 py-2 text-xs text-uppercase text-muted text-center">Risiko</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($group as $stat)
                                                <tr>
                                                    <td class="px-3 py-2">
                                                        <div class="small font-weight-bold text-primary">{{ $stat->code }}</div>
                                                        <div class="text-xs text-muted text-truncate" style="max-width: 200px;" title="{{ $stat->name }}">{{ $stat->name }}</div>
                                                    </td>
                                                    <td class="px-3 text-center align-middle">
                                                        <span class="badge badge-pill badge-primary">{{ $stat->risks_count }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Report Table -->
        <div class="col-md-12">
            <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="mb-0 font-weight-bold text-dark"><i class="fas fa-table mr-2 text-success"></i> Rincian
                        Data Risk Register</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr class="text-xs text-uppercase text-muted">
                                    <th class="px-4">Risiko</th>
                                    <th>Unit</th>
                                    <th>Causa / Akibat</th>
                                    <th class="text-center">Inherent</th>
                                    <th class="text-center">Mitigasi</th>
                                    <th class="px-4">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($risks as $risk)
                                    <tr>
                                        <td class="px-4">
                                            <div class="font-weight-bold">{{ $risk->nama_risiko }}</div>
                                            <small class="text-muted">{{ $risk->kategori->nama_kategori ?? '-' }}</small>
                                        </td>
                                        <td><small>{{ $risk->unit->nama_unit ?? '-' }}</small></td>
                                        <td>
                                            <small class="d-block text-truncate" style="max-width: 250px;"
                                                title="{{ $risk->penyebab }}"><strong>C:</strong>
                                                {{ $risk->penyebab }}</small>
                                            <small class="d-block text-truncate" style="max-width: 250px;"
                                                title="{{ $risk->dampak }}"><strong>A:</strong> {{ $risk->dampak }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-{{ $risk->level_color }} px-2 py-1">
                                                {{ $risk->level_risiko }} ({{ $risk->skor_risiko }})
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @php $mitCount = $risk->mitigations->count(); @endphp
                                            <span class="badge badge-{{ $mitCount > 0 ? 'info' : 'light border' }}">
                                                {{ $mitCount }} Aksi
                                            </span>
                                        </td>
                                        <td class="px-4">
                                            <span
                                                class="badge badge-{{ $risk->status == 'Approved' ? 'success' : ($risk->status == 'Rejected' ? 'danger' : 'secondary') }}">
                                                {{ strtoupper($risk->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="60"
                                                class="mb-3 opacity-50">
                                            <p class="text-muted">Tidak ada data risiko yang ditemukan.</p>
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
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('categoryChart').getContext('2d');
                const labels = @json($categoryStats->pluck('nama_kategori'));
                const data = @json($categoryStats->pluck('risks_count'));
                
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Jumlah Risiko',
                            data: data,
                            backgroundColor: [
                                '#059669', '#10b981', '#34d399', '#6ee7b7', '#a7f3d0', '#d1fae5'
                            ],
                            borderRadius: 8,
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1 }
                            },
                            x: {
                                grid: { display: false }
                            }
                        }
                    }
                });
                // 2. Segmented Indicator Charts
                @foreach($indicatorStats as $type => $group)
                (function() {
                    const ctxInd = document.getElementById('chart-{{ \Illuminate\Support\Str::slug($type) }}').getContext('2d');
                    const labelsInd = @json($group->pluck('code'));
                    const dataInd = @json($group->pluck('risks_count'));
                    const namesInd = @json($group->pluck('name'));
                    
                    new Chart(ctxInd, {
                        type: 'bar',
                        data: {
                            labels: labelsInd,
                            datasets: [{
                                label: 'Risiko',
                                data: dataInd,
                                backgroundColor: '#4f46e5',
                                borderRadius: 6,
                                barThickness: 20
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                                tooltip: {
                                    callbacks: {
                                        afterLabel: function(context) {
                                            return namesInd[context.dataIndex];
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: { beginAtZero: true, ticks: { stepSize: 1 } },
                                y: { grid: { display: false } }
                            }
                        }
                    });
                })();
                @endforeach
            });

            function exportReport(type) {
                const form = document.getElementById('report-form');
                const baseUrl = type === 'pdf' ? "{{ route('reports.risks.pdf') }}" : "{{ route('reports.risks.excel') }}";
                const formData = new FormData(form);
                const params = new URLSearchParams();

                for (const [key, value] of formData) {
                    if (value) params.append(key, value);
                }

                window.location.href = baseUrl + '?' + params.toString();
            }
        </script>
    @endpush
</x-app-layout>