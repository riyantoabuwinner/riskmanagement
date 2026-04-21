<x-app-layout>
    @section('title', 'Daftar Mitigasi')
    @section('page-title', 'Manajemen & Monitoring Mitigasi')
    @section('breadcrumb')
        <li class="breadcrumb-item active">Mitigasi</li>
    @endsection

    <div class="card card-outline card-success shadow-sm">
        <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
            <h3 class="card-title font-weight-bold" style="color: var(--green-dark);">
                <i class="fas fa-shield-alt mr-2"></i> Daftar Rencana Perlakuan Risiko
            </h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr class="text-xs text-uppercase text-muted">
                            <th class="px-4">#</th>
                            <th>Risiko Terkait</th>
                            <th>Strategi</th>
                            <th>Rencana Aksi</th>
                            <th>Penanggung Jawab</th>
                            <th>Target Waktu</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mitigations as $i => $mit)
                        <tr>
                            <td class="px-4 text-muted small">{{ $mitigations->firstItem() + $i }}</td>
                            <td>
                                <a href="{{ route('risks.show', $mit->risk_id) }}" class="font-weight-bold text-dark">
                                    {{ Str::limit($mit->risk->nama_risiko ?? 'Unknown Risk', 30) }}
                                </a>
                                <div class="text-xs text-muted">{{ $mit->risk->unit->nama_unit ?? '-' }}</div>
                            </td>
                            <td>
                                <span class="badge badge-light border">{{ $mit->strategi }}</span>
                            </td>
                            <td>
                                <div class="small" title="{{ $mit->rencana_aksi }}">{{ Str::limit($mit->rencana_aksi, 40) }}</div>
                            </td>
                            <td>
                                <div class="text-xs font-weight-bold">{{ $mit->penanggung_jawab }}</div>
                            </td>
                            <td>
                                <div class="small text-muted">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    {{ $mit->target_waktu?->format('d M Y') ?? '-' }}
                                </div>
                            </td>
                            <td>
                                <form action="{{ route('mitigations.update', $mit) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-control form-control-sm text-xs font-weight-bold p-0" 
                                            onchange="this.form.submit()"
                                            style="height: 25px; border-radius: 4px; border: 1px solid {{ 
                                                $mit->status == 'Completed' ? '#10b981' : ($mit->status == 'In Progress' ? '#3b82f6' : '#94a3b8') 
                                            }}; color: {{ 
                                                $mit->status == 'Completed' ? '#065f46' : ($mit->status == 'In Progress' ? '#1e40af' : '#475569') 
                                            }}; background: {{ 
                                                $mit->status == 'Completed' ? '#ecfdf5' : ($mit->status == 'In Progress' ? '#eff6ff' : '#f8fafc') 
                                            }}">
                                        <option value="Pending" {{ $mit->status == 'Pending' ? 'selected' : '' }}>PENDING</option>
                                        <option value="In Progress" {{ $mit->status == 'In Progress' ? 'selected' : '' }}>IN PROGRESS</option>
                                        <option value="Completed" {{ $mit->status == 'Completed' ? 'selected' : '' }}>COMPLETED</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fas fa-tasks fa-3x mb-3 d-block opacity-10"></i>
                                Belum ada rencana mitigasi yang tercatat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($mitigations->hasPages())
        <div class="card-footer bg-white">
            {{ $mitigations->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
