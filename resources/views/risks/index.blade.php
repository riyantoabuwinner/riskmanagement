<x-app-layout>
    @section('title', 'Risk Register')
    @section('page-title', 'Identifikasi & Register Risiko')
    @section('breadcrumb')
        <li class="breadcrumb-item active">Risk Register</li>
    @endsection

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="fas fa-clipboard-list mr-2" style="color:#047857;"></i>
                <h3 class="card-title mb-0">Risk Register</h3>
            </div>
            @can('create risks')
                <a href="{{ route('risks.create') }}" class="btn btn-success btn-sm">
                    <i class="fas fa-plus mr-1"></i> Identifikasi Risiko Baru
                </a>
            @endcan
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode Risiko</th>
                            <th>Nama Risiko</th>
                            <th>Unit Kerja</th>
                            <th>Kategori</th>
                            <th>Skor</th>
                            <th>Level</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($risks as $i => $risk)
                            <tr>
                                <td class="text-muted" style="font-size:0.8rem;">{{ $risks->firstItem() + $i }}</td>
                                <td>
                                    @if($risk->kode_risiko)
                                        <span class="badge badge-primary px-2"
                                            style="font-size:0.75rem; background-color:#334155;">{{ $risk->kode_risiko }}</span>
                                    @else
                                        <span class="text-muted italic" style="font-size:0.75rem;">(Belum digenerate)</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="font-weight-bold" style="color:#1e293b; font-size:0.9rem;">
                                        {{ $risk->nama_risiko }}</div>
                                    <small class="text-muted"><i
                                            class="fas fa-calendar-alt mr-1"></i>{{ $risk->tanggal_identifikasi?->format('d M Y') ?? '-' }}</small>
                                </td>
                                <td>
                                    <div style="font-size: 0.85rem;">{{ $risk->unit->nama_unit ?? '-' }}</div>
                                </td>
                                <td>
                                    <span class="badge badge-light"
                                        style="font-size: 0.75rem; border: 1px solid #e2e8f0;">{{ $risk->kategori->nama_kategori ?? '-' }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-light font-weight-bold"
                                        style="font-size: 0.85rem;">{{ $risk->skor_risiko }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $risk->level_color }} px-2 py-1"
                                        style="font-size: 0.75rem;">
                                        {{ $risk->level_risiko }}
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $sc = match ($risk->status) {
                                            'Draft' => 'secondary',
                                            'Submitted' => 'info',
                                            'Reviewed' => 'warning',
                                            'Approved' => 'success',
                                            'Rejected' => 'danger',
                                            default => 'light'
                                        };
                                    @endphp
                                    <span class="badge badge-{{ $sc }} px-2 py-1"
                                        style="font-size: 0.7rem; letter-spacing: 0.5px;">{{ strtoupper($risk->status) }}</span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('risks.show', $risk) }}" class="btn btn-xs btn-outline-info"
                                            title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if($risk->status === 'Draft')
                                            @can('update', $risk)
                                                <a href="{{ route('risks.edit', $risk) }}" class="btn btn-xs btn-outline-primary"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endcan

                                            @can('submit', $risk)
                                                <form action="{{ route('risks.submit', $risk) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-xs btn-outline-success"
                                                        title="Submit ke Manager"
                                                        onclick="return confirm('Ajukan risiko ini untuk direview?')">
                                                        <i class="fas fa-paper-plane"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        @endif

                                        @if($risk->status === 'Submitted')
                                            @can('review risks')
                                                <form action="{{ route('risks.review', $risk) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-xs btn-outline-warning"
                                                        title="Tandai Sudah Direview"
                                                        onclick="return confirm('Tandai risiko ini sebagai Reviewed?')">
                                                        <i class="fas fa-check-double"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        @endif

                                        @if($risk->status === 'Reviewed')
                                            @can('approve risks')
                                                <form action="{{ route('risks.approve', $risk) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-xs btn-outline-success"
                                                        title="Setujui (Approve)" onclick="return confirm('Setujui risiko ini?')">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        @endif

                                        @if(in_array($risk->status, ['Submitted', 'Reviewed']))
                                            @can('review risks') <!-- Manager/SPI/Pimpinan can reject -->
                                                <form action="{{ route('risks.reject', $risk) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-xs btn-outline-danger"
                                                        title="Tolak (Reject)"
                                                        onclick="return confirm('Tolak risiko ini dan kembalikan ke Draft?')">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        @endif

                                        @can('delete', $risk)
                                            <form action="{{ route('risks.destroy', $risk) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-xs btn-outline-danger" title="Hapus"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block opacity-20"></i>
                                    Belum ada data risiko yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($risks->hasPages())
            <div class="card-footer bg-white">
                {{ $risks->links() }}
            </div>
        @endif
    </div>
</x-app-layout>