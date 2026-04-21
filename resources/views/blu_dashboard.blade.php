<x-app-layout>
    @section('title', 'BLU Strategic Dashboard')
    @section('page-title', 'BLU Strategic Dashboard')
    @section('breadcrumb')
        <li class="breadcrumb-item active">BLU Dashboard</li>
    @endsection

    <!-- Stat Cards -->
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="info-box">
                <span class="info-box-icon" style="background:linear-gradient(135deg,#047857,#10b981);color:#fff;">
                    <i class="fas fa-money-bill-wave"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text text-muted">Total Eksposur Finansial</span>
                    <span class="info-box-number font-weight-bold" style="font-size:1.1rem;color:#064e3b;">
                        Rp {{ number_format($financialExposure, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="info-box">
                <span class="info-box-icon" style="background:linear-gradient(135deg,#7c3aed,#8b5cf6);color:#fff;">
                    <i class="fas fa-star"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text text-muted">Risiko Berdampak IKU</span>
                    <span class="info-box-number font-weight-bold" style="font-size:1.8rem;color:#7c3aed;">{{ $ikuRisks }}</span>
                    <span class="progress-description text-muted" style="font-size:0.75rem;">dari {{ $totalRisks }} total risiko</span>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="info-box">
                <span class="info-box-icon" style="background:linear-gradient(135deg,#0369a1,#0ea5e9);color:#fff;">
                    <i class="fas fa-chart-pie"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text text-muted">Distribusi Tipe Risiko</span>
                    <div class="d-flex justify-content-between mt-1">
                        <div>
                            <span class="font-weight-bold" style="font-size:1.3rem;color:#1e40af;">{{ $risksByType['Academic'] ?? 0 }}</span>
                            <small class="text-muted d-block">Akademik</small>
                        </div>
                        <div class="text-center" style="color:#d1d5db;font-size:1.5rem;">|</div>
                        <div>
                            <span class="font-weight-bold" style="font-size:1.3rem;color:#0369a1;">{{ $risksByType['Non-Academic'] ?? 0 }}</span>
                            <small class="text-muted d-block">Non-Akademik</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Top Financial Risks -->
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle mr-2" style="color:#dc2626;"></i>
                    <h3 class="card-title mb-0">Top 5 Risiko Finansial Tertinggi</h3>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Peristiwa Risiko</th>
                                    <th>Unit</th>
                                    <th class="text-right">Dampak (Rp)</th>
                                    <th>Level</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topFinancialRisks as $risk)
                                <tr>
                                    <td>
                                        <div class="font-weight-bold" style="font-size:0.85rem;color:#111827;">
                                            {{ \Illuminate\Support\Str::limit($risk->event, 40) }}
                                        </div>
                                    </td>
                                    <td><small class="text-muted">{{ $risk->unit->name ?? '-' }}</small></td>
                                    <td class="text-right font-weight-bold" style="color:#dc2626;font-size:0.85rem;">
                                        {{ number_format($risk->financial_impact_amount, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        @php
                                            $level = $risk->risk_level;
                                            $bg = '#bbf7d0'; $col = '#064e3b';
                                            if($level >= 20) { $bg='#fee2e2'; $col='#dc2626'; }
                                            elseif($level >= 12) { $bg='#ffedd5'; $col='#c2410c'; }
                                            elseif($level >= 6) { $bg='#fef9c3'; $col='#854d0e'; }
                                        @endphp
                                        <span class="badge" style="background:{{ $bg }};color:{{ $col }};font-size:0.72rem;">{{ $level }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="fas fa-check-circle fa-2x mb-2 d-block text-success"></i>
                                        Tidak ada risiko finansial yang tercatat.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- IKU Performance Panel -->
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <i class="fas fa-bullseye mr-2" style="color:#7c3aed;"></i>
                    <h3 class="card-title mb-0">Manajemen Kinerja BLU</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted" style="font-size:0.85rem;">
                        Monitoring risiko yang berdampak langsung pada Indikator Kinerja Utama (IKU) universitas.
                        Risiko berdampak tinggi memerlukan perhatian segera dari Komite Manajemen Risiko.
                    </p>

                    <div class="callout callout-{{ $ikuRisks > 0 ? 'warning' : 'success' }} mt-3">
                        <h5><i class="fas fa-{{ $ikuRisks > 0 ? 'exclamation-triangle' : 'check-circle' }} mr-2"></i>Rekomendasi</h5>
                        <p class="mb-0" style="font-size:0.85rem;">
                            @if($ikuRisks > 0)
                                Terdapat <strong>{{ $ikuRisks }}</strong> risiko yang mempengaruhi target IKU.
                                Tinjau rencana mitigasi untuk memastikan target kinerja tetap tercapai.
                            @else
                                Tidak ada risiko kritis yang saat ini berdampak pada target IKU. Terus pantau secara berkala.
                            @endif
                        </p>
                    </div>

                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span style="font-size:0.85rem;font-weight:600;color:#374151;">Risiko IKU vs Total</span>
                            <span style="font-size:0.85rem;color:#6b7280;">{{ $ikuRisks }} / {{ $totalRisks }}</span>
                        </div>
                        <div class="progress" style="height:10px;border-radius:5px;">
                            <div class="progress-bar" role="progressbar"
                                 style="width:{{ $totalRisks > 0 ? round(($ikuRisks/$totalRisks)*100) : 0 }}%;background:linear-gradient(90deg,#7c3aed,#8b5cf6);"
                                 aria-valuenow="{{ $ikuRisks }}" aria-valuemin="0" aria-valuemax="{{ $totalRisks }}">
                            </div>
                        </div>
                        <small class="text-muted">{{ $totalRisks > 0 ? round(($ikuRisks/$totalRisks)*100) : 0 }}% risiko berdampak pada IKU</small>
                    </div>

                    <div class="mt-4 d-flex" style="gap:8px;">
                        <a href="{{ route('risks.index') }}" class="btn btn-success btn-sm flex-fill">
                            <i class="fas fa-clipboard-list mr-1"></i> Risk Register
                        </a>
                        <a href="{{ route('mitigations.index') }}" class="btn btn-outline-secondary btn-sm flex-fill">
                            <i class="fas fa-tasks mr-1"></i> Mitigasi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
