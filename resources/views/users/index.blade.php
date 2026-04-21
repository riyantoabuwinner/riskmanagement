<x-app-layout>
    @section('title', 'User Management')
    @section('page-title', 'Manajemen Pengguna')
    @section('breadcrumb')
        <li class="breadcrumb-item active">User Management</li>
    @endsection

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="fas fa-users-cog mr-2" style="color:#047857;"></i>
                <h3 class="card-title mb-0">Daftar Pengguna ({{ $users->total() }})</h3>
            </div>
            <a href="{{ route('users.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-user-plus mr-1"></i> Tambah User
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
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
                                    <form action="{{ route('users.impersonate', $user) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Login sebagai {{ $user->name }}?\n\nAnda akan melihat sistem dari perspektif user ini.');">
                                        @csrf
                                        <button class="btn btn-xs btn-outline-warning" title="Impersonate: Login sebagai {{ $user->name }}">
                                            <i class="fas fa-user-secret"></i>
                                        </button>
                                    </form>
                                    @endif
                                    @endrole
                                    @if(auth()->id() !== $user->id)
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus user {{ $user->name }}?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-xs btn-outline-danger" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
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
</x-app-layout>
