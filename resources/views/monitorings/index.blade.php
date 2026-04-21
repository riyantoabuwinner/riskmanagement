<x-app-layout>
    @section('title', 'Monitoring Risiko')
    @section('page-title', 'Monitoring & Realisasi Risiko')

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
