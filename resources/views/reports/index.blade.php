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
                                    <select name="unit_id" class="form-control bg-light select2">
                                        <option value="">Semua Unit</option>
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
                                        <option value="">Semua Status</option>
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

        <!-- Report Table -->
        <div class="col-md-12">
            @if($risks)
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
                                                <p class="text-muted">Tidak ada data risiko yang ditemukan untuk filter ini.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="card shadow-sm border-0" style="border-radius: 12px; height: 100%;">
                    <div class="card-body p-5 text-center d-flex flex-row align-items-center justify-content-center">
                        <div class="mr-4"
                            style="width: 100px; height: 100px; background: #f0fdf4; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-print fa-3x" style="color: var(--green-main);"></i>
                        </div>
                        <div class="text-left">
                            <h4 class="font-weight-bold" style="color: var(--green-dark);">Pusat Pelaporan ERM</h4>
                            <p class="text-muted mb-0">
                                Silakan tentukan parameter laporan pada filter di atas dan klik <strong>Lihat
                                    Laporan</strong> untuk menampilkan rincian data.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
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