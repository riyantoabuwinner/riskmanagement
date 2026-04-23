<x-app-layout>
    @section('title', 'User Management')
    @section('page-title', 'Manajemen Pengguna')
    @section('breadcrumb')
        <li class="breadcrumb-item active">User Management</li>
    @endsection

    <form id="bulk-delete-form" action="{{ route('users.bulk-delete') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <i class="fas fa-users-cog mr-2" style="color:#047857;"></i>
                    <h3 class="card-title mb-0">Daftar Pengguna ({{ $users->total() }})</h3>
                </div>
                <div class="d-flex" style="gap:8px;">
                    @role('Super Admin')
                    <button type="button" id="bulk-delete-btn" class="btn btn-danger btn-sm d-none" onclick="confirmBulkDelete()">
                        <i class="fas fa-trash mr-1"></i> Hapus Terpilih (<span id="selected-count">0</span>)
                    </button>
                    @endrole
                    <button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#importExcelModal">
                        <i class="fas fa-file-import mr-1"></i> Import Excel
                    </button>
                    <a href="{{ route('users.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-user-plus mr-1"></i> Tambah User
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                @role('Super Admin')
                                <th style="width: 40px;" class="px-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkAll">
                                        <label class="custom-control-label" for="checkAll"></label>
                                    </div>
                                </th>
                                @endrole
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Unit Kerja</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $i => $user)
                            <tr>
                                @role('Super Admin')
                                <td class="px-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="ids[]" value="{{ $user->id }}" class="custom-control-input row-checkbox" id="check{{ $user->id }}" {{ auth()->id() == $user->id ? 'disabled' : '' }}>
                                        <label class="custom-control-label" for="check{{ $user->id }}"></label>
                                    </div>
                                </td>
                                @endrole
                                <td class="text-muted" style="font-size:0.8rem;">{{ $users->firstItem() + $i }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#047857,#10b981);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.85rem;flex-shrink:0;margin-right:10px;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-weight-bold" style="color:#111827;font-size:0.88rem;">{{ $user->name }}</div>
                                            @if($user->unit)
                                            <small class="text-muted"><i class="fas fa-building fa-xs mr-1"></i>{{ $user->unit->nama_unit }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td><small class="text-muted">{{ $user->email }}</small></td>
                                <td>
                                    @forelse($user->roles as $role)
                                        @php
                                            $roleColors = [
                                                'Super Admin' => 'danger',
                                                'Risk Manager' => 'success',
                                                'Risk Officer' => 'primary',
                                                'Risk Owner' => 'info',
                                                'Admin Universitas' => 'warning'
                                            ];
                                            $rc = $roleColors[$role->name] ?? 'secondary';
                                        @endphp
                                        <span class="badge badge-{{ $rc }}" style="font-size:0.72rem;">{{ $role->name }}</span>
                                    @empty
                                        <span class="badge badge-light text-muted">Tidak ada role</span>
                                    @endforelse
                                </td>
                                <td>
                                    @if($user->unit)
                                        <small style="color:#374151;">{{ $user->unit->nama_unit }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex" style="gap:4px;">
                                        <a href="{{ route('users.edit', $user) }}" class="btn btn-xs btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @role('Super Admin')
                                        @if(auth()->id() !== $user->id && !$user->hasRole('Super Admin'))
                                        <button type="button" class="btn btn-xs btn-outline-warning" title="Impersonate: Login sebagai {{ $user->name }}" onclick="confirmImpersonate('{{ route('users.impersonate', $user) }}', '{{ $user->name }}')">
                                            <i class="fas fa-user-secret"></i>
                                        </button>
                                        @endif
                                        @endrole
                                        @role('Super Admin')
                                        @if(auth()->id() !== $user->id)
                                        <button type="button" class="btn btn-xs btn-outline-danger" title="Hapus" onclick="confirmDelete('{{ route('users.destroy', $user) }}', '{{ $user->name }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @endif
                                        @endrole
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-users fa-3x mb-3 d-block"></i>
                                    Belum ada pengguna.
                                    <br><a href="{{ route('users.create') }}" class="btn btn-success btn-sm mt-2"><i class="fas fa-user-plus mr-1"></i> Tambah User Pertama</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($users->hasPages())
            <div class="card-footer">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </form>

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
