<x-app-layout>
    @section('title', 'User Management')
    @section('page-title', 'Manajemen Pengguna')
    @section('breadcrumb')
        <li class="breadcrumb-item active">User Management</li>
    @endsection

    <style>
        .user-card { border-radius: 16px; border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.05); overflow: hidden; }
        .user-table thead th { 
            background: #f8fafc; text-transform: uppercase; font-size: 0.7rem; 
            font-weight: 800; letter-spacing: 1px; color: #64748b; border-top: none;
            padding: 15px 20px;
        }
        .user-table tbody td { padding: 15px 20px; vertical-align: middle; border-bottom: 1px solid #f1f5f9; }
        .user-avatar {
            width: 40px; height: 40px; border-radius: 12px;
            background: linear-gradient(135deg, #059669, #10b981);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: 0.9rem;
            box-shadow: 0 4px 10px rgba(16,185,129,0.2);
        }
        .user-name { 
            font-weight: 700; color: #1e293b; font-size: 0.9rem; margin-bottom: 2px;
            max-width: 180px; overflow: hidden; 
            text-overflow: ellipsis; white-space: nowrap;
        }
        .user-email { 
            font-size: 0.75rem; color: #64748b; 
            max-width: 180px; overflow: hidden; 
            text-overflow: ellipsis; white-space: nowrap; 
        }
        .btn-action { 
            width: 32px; height: 32px; border-radius: 8px; display: inline-flex; 
            align-items: center; justify-content: center; transition: all 0.2s;
            border: 1px solid #e2e8f0; background: #fff; color: #64748b;
        }
        .btn-action:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); color: #059669; border-color: #059669; }
        .btn-action.btn-delete:hover { color: #ef4444; border-color: #ef4444; box-shadow: 0 4px 12px rgba(239,68,68,0.15); }
        .role-badge { 
            padding: 4px 10px; border-radius: 6px; font-weight: 700; font-size: 0.65rem; 
            text-transform: uppercase; letter-spacing: 0.5px;
        }
    </style>

    <div class="card user-card">
        <div class="card-header bg-white py-4 px-4 border-0">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                <div>
                    <h3 class="font-weight-bold text-dark mb-1" style="font-size:1.25rem;">Daftar Pengguna</h3>
                    <p class="text-muted mb-0" style="font-size:0.85rem;">Kelola akses dan informasi pengguna sistem ({{ $users->total() }} user)</p>
                </div>
                <div class="d-flex mt-3 mt-md-0 align-items-center" style="gap:10px; flex-wrap: wrap;">
                    <form action="{{ route('users.index') }}" method="GET" class="d-flex" style="gap:5px;">
                        <div class="position-relative">
                            <i class="fas fa-search position-absolute" style="left:12px; top:11px; color:#94a3b8; font-size:0.9rem;"></i>
                            <input type="text" name="search" class="form-control shadow-none pl-5" placeholder="Cari nama, email, unit..." value="{{ request('search') }}" style="border-radius:10px; height:38px; width:220px; border-color:#e2e8f0; font-size:0.85rem;">
                            @if(request('search'))
                                <a href="{{ route('users.index') }}" class="position-absolute" style="right:12px; top:8px; color:#ef4444;"><i class="fas fa-times-circle"></i></a>
                            @endif
                        </div>
                    </form>
                    @role('Super Admin')
                    <button type="button" id="bulk-delete-btn" class="btn btn-outline-danger d-none shadow-sm" style="border-radius:10px; font-weight:600; height:38px;" onclick="confirmBulkDelete()">
                        <i class="fas fa-trash-alt mr-2"></i> Hapus (<span id="selected-count">0</span>)
                    </button>
                    @endrole
                    <button type="button" class="btn btn-outline-success shadow-sm" style="border-radius:10px; font-weight:600; height:38px;" data-toggle="modal" data-target="#importExcelModal">
                        <i class="fas fa-file-excel mr-2"></i> Import
                    </button>
                    <a href="{{ route('users.create') }}" class="btn btn-success shadow-sm px-4" style="border-radius:10px; font-weight:700; background:linear-gradient(135deg,#059669,#10b981); border:none; height:38px; display:flex; align-items:center;">
                        <i class="fas fa-plus-circle mr-2"></i> Tambah User
                    </a>
                </div>
            </div>
        </div>
        <form id="bulk-delete-form" action="{{ route('users.bulk-delete') }}" method="POST">
            @csrf
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table user-table mb-0">
                        <thead>
                            <tr>
                                @role('Super Admin')
                                <th style="width: 50px;">
                                    <div class="custom-control custom-checkbox ml-2">
                                        <input type="checkbox" class="custom-control-input" id="checkAll">
                                        <label class="custom-control-label" for="checkAll"></label>
                                    </div>
                                </th>
                                @endrole
                                <th>Pengguna</th>
                                <th>Kontak</th>
                                <th>Otoritas</th>
                                <th>Unit Kerja</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $i => $user)
                            <tr>
                                @role('Super Admin')
                                <td>
                                    <div class="custom-control custom-checkbox ml-2">
                                        <input type="checkbox" name="ids[]" value="{{ $user->id }}" class="custom-control-input row-checkbox" id="check{{ $user->id }}" {{ auth()->id() == $user->id ? 'disabled' : '' }}>
                                        <label class="custom-control-label" for="check{{ $user->id }}"></label>
                                    </div>
                                </td>
                                @endrole
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar mr-3">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="user-name" title="{{ $user->name }}">{{ $user->name }}</div>
                                            <div class="text-muted" style="font-size:0.75rem;">ID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="width: 200px;">
                                    <div class="user-email" title="{{ $user->email }}"><i class="far fa-envelope mr-1"></i> {{ $user->email }}</div>
                                </td>
                                <td>
                                    @forelse($user->roles as $role)
                                        @php
                                            $roleColors = [
                                                'Super Admin' => 'danger',
                                                'Risk Manager' => 'success',
                                                'Risk Officer' => 'primary',
                                                'Risk Owner' => 'info'
                                            ];
                                            $rc = $roleColors[$role->name] ?? 'secondary';
                                        @endphp
                                        <span class="role-badge badge-{{ $rc }}">{{ $role->name }}</span>
                                    @empty
                                        <span class="text-muted small">No Role</span>
                                    @endforelse
                                </td>
                                <td>
                                    @if($user->unit)
                                        <div class="font-weight-600 text-dark" style="font-size:0.85rem;">{{ $user->unit->nama_unit }}</div>
                                        <div class="text-muted" style="font-size:0.7rem;">{{ $user->unit->type->nama_jenis ?? 'Internal' }}</div>
                                    @else
                                        <span class="text-muted small">Universitas</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center" style="gap:8px;">
                                        <a href="{{ route('users.edit', $user) }}" class="btn-action" title="Edit Profil">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        @role('Super Admin')
                                        @if(auth()->id() !== $user->id && !$user->hasRole('Super Admin'))
                                        <button type="button" class="btn-action" title="Impersonate" onclick="confirmImpersonate('{{ route('users.impersonate', $user) }}', '{{ $user->name }}')">
                                            <i class="fas fa-fingerprint"></i>
                                        </button>
                                        @endif
                                        @if(auth()->id() !== $user->id)
                                        <button type="button" class="btn-action btn-delete" title="Hapus Akun" onclick="confirmDelete('{{ route('users.destroy', $user) }}', '{{ $user->name }}')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                        @endif
                                        @endrole
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/5087/5087579.png" style="width:80px; opacity:0.3;" class="mb-3">
                                    <p class="text-muted">Tidak ditemukan data pengguna.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($users->hasPages())
            <div class="card-footer bg-white border-0 py-4">
                {{ $users->links() }}
            </div>
            @endif
        </form>
    </div>

    <!-- Modal Import Excel -->
    <div class="modal fade" id="importExcelModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-xl" style="border-radius: 15px;">
                @csrf
                <div class="modal-header border-bottom-0 pt-4 px-4">
                    <h5 class="modal-title font-weight-bold text-dark"><i class="fas fa-file-excel mr-2 text-success"></i> Import Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-4">
                    <div class="alert alert-info py-2 shadow-sm mb-4" style="border-radius: 10px; border-left: 5px solid #0ea5e9;">
                        <i class="fas fa-info-circle mr-2"></i> Silakan unduh format Excel sebelum melakukan import untuk menghindari kesalahan data.
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Pilih File Excel</label>
                        <div class="custom-file">
                            <input type="file" name="file" class="custom-file-input" id="excelFile" required accept=".xlsx, .xls">
                            <label class="custom-file-label" for="excelFile">Pilih file...</label>
                        </div>
                        <small class="text-muted mt-2 d-block">Format: .xlsx, .xls (Maks. 2MB)</small>
                    </div>
                    <div class="text-center mt-4">
                        <a href="{{ route('users.template') }}" class="btn btn-link text-success font-weight-bold p-0">
                            <i class="fas fa-download mr-1"></i> Unduh Format Excel
                        </a>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pb-4 px-4">
                    <button type="button" class="btn btn-light px-4 mr-2" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success px-4 font-weight-bold shadow-sm">Mulai Import</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Hidden Action Forms -->
    <form id="delete-form" method="POST" style="display: none;">
        @csrf @method('DELETE')
    </form>
    <form id="impersonate-form" method="POST" style="display: none;">
        @csrf
    </form>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Update custom file input label
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });

            // Handle Check All
            $('#checkAll').on('change', function() {
                $('.row-checkbox:not(:disabled)').prop('checked', $(this).prop('checked'));
                updateBulkDeleteButton();
            });

            // Handle Row Checkbox change
            $('.row-checkbox').on('change', function() {
                if ($('.row-checkbox:checked').length == $('.row-checkbox:not(:disabled)').length) {
                    $('#checkAll').prop('checked', true);
                } else {
                    $('#checkAll').prop('checked', false);
                }
                updateBulkDeleteButton();
            });
        });

        function updateBulkDeleteButton() {
            const selectedCount = $('.row-checkbox:checked').length;
            if (selectedCount > 0) {
                $('#bulk-delete-btn').removeClass('d-none');
                $('#selected-count').text(selectedCount);
            } else {
                $('#bulk-delete-btn').addClass('d-none');
            }
        }

        function confirmBulkDelete() {
            if (confirm('Apakah Anda yakin ingin menghapus ' + $('.row-checkbox:checked').length + ' user terpilih?')) {
                $('#bulk-delete-form').submit();
            }
        }

        function confirmDelete(url, name) {
            if (confirm('Hapus user ' + name + '?')) {
                const form = $('#delete-form');
                form.attr('action', url);
                form.submit();
            }
        }

        function confirmImpersonate(url, name) {
            if (confirm('Login sebagai ' + name + '?\n\nAnda akan melihat sistem dari perspektif user ini.')) {
                const form = $('#impersonate-form');
                form.attr('action', url);
                form.submit();
            }
        }
    </script>
    @endpush
</x-app-layout>
