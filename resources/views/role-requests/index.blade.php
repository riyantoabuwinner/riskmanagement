<x-app-layout>
@section('title', 'Pengajuan Role')
@section('page-title', 'Pengajuan Role')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Pengajuan Role</li>
@endsection

@push('styles')
<style>
    .rr-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; flex-wrap: wrap; gap: 12px; }
    .rr-title { font-size: 1.4rem; font-weight: 800; color: #111827; }
    .rr-title span { color: var(--green-main, #047857); }

    /* Stat Cards */
    .stat-row { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
    .stat-card {
        background: #fff; border-radius: 14px; padding: 18px 20px;
        border: 1px solid #e5e7eb; display: flex; align-items: center; gap: 14px;
        transition: box-shadow 0.2s;
    }
    .stat-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
    .stat-icon {
        width: 44px; height: 44px; border-radius: 12px;
        display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;
    }
    .stat-icon.pending  { background: #fef3c7; color: #d97706; }
    .stat-icon.approved { background: #d1fae5; color: #059669; }
    .stat-icon.rejected { background: #fee2e2; color: #dc2626; }
    .stat-icon.all      { background: #ede9fe; color: #7c3aed; }
    .stat-num { font-size: 1.6rem; font-weight: 800; color: #111827; line-height: 1; }
    .stat-label { font-size: 0.75rem; color: #6b7280; font-weight: 500; margin-top: 2px; }

    /* Filter Tabs */
    .filter-tabs { display: flex; gap: 8px; margin-bottom: 20px; flex-wrap: wrap; }
    .tab-btn {
        padding: 7px 16px; border-radius: 8px; font-size: 0.82rem; font-weight: 600;
        border: 1.5px solid #e5e7eb; background: #fff; color: #6b7280;
        text-decoration: none; transition: all 0.2s; cursor: pointer;
    }
    .tab-btn:hover { border-color: #047857; color: #047857; }
    .tab-btn.active { background: #047857; border-color: #047857; color: #fff; }

    /* Table */
    .rr-table-wrap { background: #fff; border-radius: 16px; border: 1px solid #e5e7eb; overflow: hidden; }
    .rr-table { width: 100%; border-collapse: collapse; }
    .rr-table th {
        background: #f9fafb; padding: 12px 16px; text-align: left;
        font-size: 0.75rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;
        border-bottom: 1px solid #e5e7eb;
    }
    .rr-table td { padding: 14px 16px; border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
    .rr-table tr:last-child td { border-bottom: none; }
    .rr-table tr:hover td { background: #f9fafb; }

    .user-cell { display: flex; align-items: center; gap: 10px; }
    .user-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        background: linear-gradient(135deg, #047857, #10b981);
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-weight: 700; font-size: 0.85rem; flex-shrink: 0;
    }
    .user-name { font-weight: 600; font-size: 0.88rem; color: #111827; }
    .user-email { font-size: 0.75rem; color: #6b7280; }

    .rr-badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 10px; border-radius: 50px; font-size: 0.72rem; font-weight: 700;
    }
    .rr-badge-pending  { background: #fef3c7; color: #92400e; }
    .rr-badge-approved { background: #d1fae5; color: #065f46; }
    .rr-badge-rejected { background: #fee2e2; color: #991b1b; }

    .role-badge {
        display: inline-flex; align-items: center; gap: 5px;
        background: #f0fdf4; color: #065f46; border: 1px solid #bbf7d0;
        padding: 4px 10px; border-radius: 6px; font-size: 0.78rem; font-weight: 600;
    }

    .action-btns { display: flex; gap: 6px; }
    .btn-approve {
        display: flex; align-items: center; gap: 4px;
        background: linear-gradient(135deg, #059669, #10b981);
        color: #fff; border: none; border-radius: 7px;
        padding: 7px 14px; font-size: 0.78rem; font-weight: 600;
        cursor: pointer; transition: all 0.2s; font-family: inherit;
    }
    .btn-approve:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(5,150,105,0.35); }
    .btn-reject {
        display: flex; align-items: center; gap: 4px;
        background: #fff; color: #dc2626; border: 1.5px solid #fca5a5;
        border-radius: 7px; padding: 7px 14px; font-size: 0.78rem; font-weight: 600;
        cursor: pointer; transition: all 0.2s; font-family: inherit;
    }
    .btn-reject:hover { background: #fee2e2; border-color: #dc2626; }

    .sk-link { color: #047857; font-size: 0.78rem; font-weight: 600; text-decoration: none; }
    .sk-link:hover { text-decoration: underline; }

    /* Modal */
    .modal-overlay {
        display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5);
        z-index: 9999; align-items: center; justify-content: center;
    }
    .modal-overlay.show { display: flex; }
    .modal-box {
        background: #fff; border-radius: 20px; padding: 32px;
        max-width: 440px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    }
    .modal-title { font-size: 1.1rem; font-weight: 800; color: #111827; margin-bottom: 6px; }
    .modal-sub { font-size: 0.85rem; color: #6b7280; margin-bottom: 20px; }
    .modal-textarea {
        width: 100%; padding: 12px; border: 1.5px solid #d1d5db; border-radius: 10px;
        font-family: inherit; font-size: 0.88rem; resize: vertical; min-height: 100px;
        outline: none; transition: border-color 0.2s;
    }
    .modal-textarea:focus { border-color: #ef4444; }
    .modal-footer { display: flex; gap: 10px; justify-content: flex-end; margin-top: 16px; }
    .btn-cancel {
        padding: 9px 18px; border: 1.5px solid #d1d5db; border-radius: 8px;
        background: #fff; color: #6b7280; font-family: inherit;
        font-size: 0.85rem; font-weight: 600; cursor: pointer;
    }
    .btn-confirm-reject {
        padding: 9px 18px; background: #dc2626; color: #fff; border: none;
        border-radius: 8px; font-family: inherit;
        font-size: 0.85rem; font-weight: 600; cursor: pointer;
    }

    .empty-state { text-align: center; padding: 60px 20px; color: #9ca3af; }
    .empty-state i { font-size: 3rem; margin-bottom: 12px; display: block; }

    @media (max-width: 768px) {
        .stat-row { grid-template-columns: repeat(2, 1fr); }
        .rr-table { font-size: 0.82rem; }
        .action-btns { flex-direction: column; }
    }
</style>
@endpush

<div class="container-fluid">

    <!-- Header -->
    <div class="rr-header">
        <div>
            <div class="rr-title">Pengajuan <span>Role</span></div>
            <p style="font-size:0.85rem;color:#6b7280;margin-top:2px;">Kelola permintaan akses role dari pengguna baru</p>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius:12px;margin-bottom:16px;">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius:12px;margin-bottom:16px;">
        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
    @endif

    <!-- Stats -->
    <div class="stat-row">
        <div class="stat-card">
            <div class="stat-icon pending"><i class="fas fa-hourglass-half"></i></div>
            <div>
                <div class="stat-num">{{ $counts['pending'] }}</div>
                <div class="stat-label">Menunggu Review</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon approved"><i class="fas fa-check-circle"></i></div>
            <div>
                <div class="stat-num">{{ $counts['approved'] }}</div>
                <div class="stat-label">Disetujui</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon rejected"><i class="fas fa-times-circle"></i></div>
            <div>
                <div class="stat-num">{{ $counts['rejected'] }}</div>
                <div class="stat-label">Ditolak</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon all"><i class="fas fa-list"></i></div>
            <div>
                <div class="stat-num">{{ $counts['all'] }}</div>
                <div class="stat-label">Total Pengajuan</div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-tabs">
        <a href="{{ route('role-requests.index', ['status' => 'pending']) }}"
           class="tab-btn {{ $status === 'pending' ? 'active' : '' }}">
            <i class="fas fa-hourglass-half mr-1"></i> Pending ({{ $counts['pending'] }})
        </a>
        <a href="{{ route('role-requests.index', ['status' => 'approved']) }}"
           class="tab-btn {{ $status === 'approved' ? 'active' : '' }}">
            <i class="fas fa-check mr-1"></i> Disetujui
        </a>
        <a href="{{ route('role-requests.index', ['status' => 'rejected']) }}"
           class="tab-btn {{ $status === 'rejected' ? 'active' : '' }}">
            <i class="fas fa-times mr-1"></i> Ditolak
        </a>
        <a href="{{ route('role-requests.index', ['status' => 'all']) }}"
           class="tab-btn {{ $status === 'all' ? 'active' : '' }}">
            <i class="fas fa-list mr-1"></i> Semua
        </a>
    </div>

    <!-- Table -->
    <div class="rr-table-wrap">
        @if($roleRequests->isEmpty())
        <div class="empty-state">
            <i class="fas fa-inbox"></i>
            <p style="font-weight:600;color:#374151;">Tidak ada pengajuan</p>
            <p style="font-size:0.82rem;margin-top:4px;">Belum ada pengajuan role dengan status ini.</p>
        </div>
        @else
        <table class="rr-table">
            <thead>
                <tr>
                    <th>Pengguna</th>
                    <th>Role Diajukan</th>
                    <th>Jabatan</th>
                    <th>Unit/Fakultas</th>
                    <th>SK</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roleRequests as $rr)
                <tr>
                    <td>
                        <div class="user-cell">
                            <div class="user-avatar">{{ strtoupper(substr($rr->user->name, 0, 1)) }}</div>
                            <div>
                                <div class="user-name">{{ $rr->user->name }}</div>
                                <div class="user-email">{{ $rr->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="role-badge">
                            @if($rr->requested_role === 'Risk Manager') <i class="fas fa-crown"></i>
                            @elseif($rr->requested_role === 'Risk Officer') <i class="fas fa-user-shield"></i>
                            @else <i class="fas fa-tasks"></i>
                            @endif
                            {{ $rr->requested_role }}
                        </span>
                    </td>
                    <td style="font-size:0.85rem;color:#374151;">{{ $rr->position }}</td>
                    <td style="font-size:0.82rem;color:#6b7280;">{{ $rr->unit?->nama_unit ?? '—' }}</td>
                    <td>
                        @if($rr->sk_file)
                            <a href="{{ $rr->sk_url }}" target="_blank" class="sk-link">
                                <i class="fas fa-file-alt mr-1"></i>Lihat SK
                            </a>
                        @else
                            <span style="color:#d1d5db;font-size:0.78rem;">—</span>
                        @endif
                    </td>
                    <td style="font-size:0.78rem;color:#6b7280;white-space:nowrap;">
                        {{ $rr->created_at->format('d M Y') }}<br>
                        <span style="color:#9ca3af;">{{ $rr->created_at->format('H:i') }}</span>
                    </td>
                    <td>
                        @if($rr->status === 'pending')
                            <span class="rr-badge rr-badge-pending"><i class="fas fa-clock"></i> Pending</span>
                        @elseif($rr->status === 'approved')
                            <span class="rr-badge rr-badge-approved"><i class="fas fa-check"></i> Disetujui</span>
                        @else
                            <span class="rr-badge rr-badge-rejected"><i class="fas fa-times"></i> Ditolak</span>
                            @if($rr->rejection_reason)
                            <div style="font-size:0.72rem;color:#9ca3af;margin-top:3px;max-width:150px;">
                                {{ Str::limit($rr->rejection_reason, 50) }}
                            </div>
                            @endif
                        @endif
                    </td>
                    <td>
                        @if($rr->isPending())
                        <div class="action-btns">
                            <form method="POST" action="{{ route('role-requests.approve', $rr) }}"
                                  onsubmit="return confirm('Setujui pengajuan {{ addslashes($rr->user->name) }} sebagai {{ $rr->requested_role }}?')">
                                @csrf
                                <button type="submit" class="btn-approve">
                                    <i class="fas fa-check"></i> Setujui
                                </button>
                            </form>
                            <button type="button" class="btn-reject"
                                    onclick="openRejectModal({{ $rr->id }}, '{{ addslashes($rr->user->name) }}')">
                                <i class="fas fa-times"></i> Tolak
                            </button>
                        </div>
                        @else
                        <span style="font-size:0.75rem;color:#9ca3af;">
                            Oleh: {{ $rr->reviewer?->name ?? '—' }}<br>
                            {{ $rr->reviewed_at?->format('d M Y') }}
                        </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    <!-- Pagination -->
    @if($roleRequests->hasPages())
    <div style="margin-top:16px;">
        {{ $roleRequests->appends(['status' => $status])->links() }}
    </div>
    @endif
</div>

<!-- Modal Reject -->
<div class="modal-overlay" id="rejectModal">
    <div class="modal-box">
        <div class="modal-title"><i class="fas fa-times-circle" style="color:#dc2626;margin-right:8px;"></i>Tolak Pengajuan</div>
        <p class="modal-sub" id="rejectModalSub">Berikan alasan penolakan untuk pengguna ini.</p>
        <form method="POST" id="rejectForm">
            @csrf
            <textarea name="rejection_reason" class="modal-textarea"
                      placeholder="Contoh: Dokumen SK tidak lengkap, jabatan tidak sesuai dengan role yang diajukan..."
                      required minlength="10"></textarea>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeRejectModal()">Batal</button>
                <button type="submit" class="btn-confirm-reject">
                    <i class="fas fa-times mr-1"></i> Tolak Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openRejectModal(id, name) {
        document.getElementById('rejectModalSub').textContent = 'Berikan alasan penolakan untuk pengajuan dari ' + name + '.';
        document.getElementById('rejectForm').action = '/role-requests/' + id + '/reject';
        document.getElementById('rejectModal').classList.add('show');
    }
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.remove('show');
    }
    document.getElementById('rejectModal').addEventListener('click', function(e) {
        if (e.target === this) closeRejectModal();
    });
</script>
@endpush

</x-app-layout>
