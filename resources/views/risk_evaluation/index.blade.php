<x-app-layout>
    @section('title', 'Analisis & Evaluasi')
    @section('page-title', 'Analisis & Evaluasi Risiko (ISO 31000)')
    @section('breadcrumb')
        <li class="breadcrumb-item active">Evaluasi</li>
    @endsection

    <div class="row">
        <!-- Dashboard Heatmap -->
        <div class="col-xl-6 col-lg-7">
            <div class="card shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="card-title font-weight-bold mb-0" style="color: var(--green-dark);">
                        <i class="fas fa-th mr-2"></i> Matriks Analisis Risiko
                    </h5>
                </div>
                <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                    <div class="heatmap-container position-relative mb-4">
                        <div class="y-axis-label text-muted font-weight-bold" style="position: absolute; left: -60px; top: 50%; transform: rotate(-90deg) translateY(-50%); font-size: 0.7rem; letter-spacing: 1px;">PROBABILITAS</div>
                        
                        <div class="heatmap-grid" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 4px; border-left: 2px solid #e2e8f0; border-bottom: 2px solid #e2e8f0; padding: 4px;">
                            @for($p = 5; $p >= 1; $p--)
                                @for($d = 1; $d <= 5; $d++)
                                    @php
                                        $score = $p * $d;
                                        $count = $matrixIds[$p][$d] ?? 0;
                                        
                                        $bg = '#f8fafc'; $col = '#64748b';
                                        if ($score >= 16) { $bg = '#fee2e2'; $col = '#ef4444'; }
                                        elseif ($score >= 12) { $bg = '#ffedd5'; $col = '#f97316'; }
                                        elseif ($score >= 6) { $bg = '#fef9c3'; $col = '#f59e0b'; }
                                        elseif ($score >= 1) { $bg = '#ecfdf5'; $col = '#10b981'; }
                                    @endphp
                                    <div class="heatmap-cell d-flex flex-column align-items-center justify-content-center shadow-sm"
                                         style="width: 60px; height: 60px; background: {{ $bg }}; color: {{ $col }}; border-radius: 6px; font-weight: 800; border: 1px solid rgba(0,0,0,0.03); transition: all 0.2s;"
                                         data-toggle="tooltip" title="Skor {{ $score }}: {{ $count }} Risiko">
                                        @if($count > 0)
                                            <span style="font-size: 1.2rem;">{{ $count }}</span>
                                        @else
                                            <span style="opacity: 0.2; font-size: 0.7rem;">{{ $score }}</span>
                                        @endif
                                    </div>
                                @endfor
                            @endfor
                        </div>
                        
                        <div class="x-axis-label text-center text-muted font-weight-bold mt-3" style="font-size: 0.7rem; letter-spacing: 1px;">LEVEL DAMPAK</div>
                    </div>

                    <!-- Legend with Premium Styling -->
                    <div class="d-flex flex-wrap justify-content-center gap-3 mt-2">
                        <div class="d-flex align-items-center mr-3">
                            <span class="rounded-circle mr-2" style="width: 10px; height: 10px; background: #10b981;"></span>
                            <small class="font-weight-bold">Low</small>
                        </div>
                        <div class="d-flex align-items-center mr-3">
                            <span class="rounded-circle mr-2" style="width: 10px; height: 10px; background: #f59e0b;"></span>
                            <small class="font-weight-bold">Medium</small>
                        </div>
                        <div class="d-flex align-items-center mr-3">
                            <span class="rounded-circle mr-2" style="width: 10px; height: 10px; background: #f97316;"></span>
                            <small class="font-weight-bold">High</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="rounded-circle mr-2" style="width: 10px; height: 10px; background: #ef4444;"></span>
                            <small class="font-weight-bold">Extreme</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Risk List Table -->
        <div class="col-xl-6 col-lg-5">
            <div class="card shadow-sm border-0 h-100" style="border-radius: 12px;">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="card-title font-weight-bold mb-0" style="color: var(--blue-dark);">
                        <i class="fas fa-list-ul mr-2"></i> Daftar Evaluasi Risiko
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr class="text-xs text-uppercase text-muted" style="background: #fafafa;">
                                    <th class="px-4">Risiko</th>
                                    <th>Skor</th>
                                    <th>Level</th>
                                    <th class="px-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingRisks as $risk)
                                <tr>
                                    <td class="px-4">
                                        <div class="font-weight-bold text-dark mb-1">{{ Str::limit($risk->nama_risiko, 40) }}</div>
                                        <div class="text-xs text-muted">{{ $risk->unit->nama_unit ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div class="badge badge-light border">{{ $risk->probabilitas }} × {{ $risk->level_dampak }} = <strong>{{ $risk->skor_risiko }}</strong></div>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $risk->level_color }} px-2 py-1 text-uppercase text-xs" style="border-radius: 4px;">{{ $risk->level_risiko }}</span>
                                    </td>
                                    <td class="px-4 text-center">
                                        <a href="{{ route('risks.show', $risk) }}" class="btn btn-sm btn-outline-primary shadow-sm" style="border-radius: 6px;">
                                            <i class="fas fa-search-plus mr-1"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="fas fa-check-double fa-3x mb-3 d-block opacity-10"></i>
                                        Belum ada risiko yang terdaftar.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($pendingRisks->hasPages())
                <div class="card-footer bg-white border-0">
                    {{ $pendingRisks->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
