<x-app-layout>
    @section('title', 'Edit User')
    @section('page-title', 'Edit Pengguna')
    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User Management</a></li>
        <li class="breadcrumb-item active">Edit: {{ $user->name }}</li>
    @endsection

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <i class="fas fa-user-edit mr-2" style="color:#047857;"></i>
                    <h3 class="card-title mb-0">Edit Pengguna: <strong>{{ $user->name }}</strong></h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="font-weight-bold" style="color:#374151;">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                           class="form-control @error('name') is-invalid @enderror" required autofocus>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="font-weight-bold" style="color:#374151;">Email <span class="text-danger">*</span></label>
                                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                           class="form-control @error('email') is-invalid @enderror" required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="role" class="font-weight-bold" style="color:#374151;">Role <span class="text-danger">*</span></label>
                                    <select id="role" name="role" class="form-control @error('role') is-invalid @enderror" required>
                                        <option value="">-- Pilih Role --</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" {{ (old('role') == $role->name || $user->hasRole($role->name)) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="unit_id" class="font-weight-bold" style="color:#374151;">Unit Kerja</label>
                                    <select id="unit_id" name="unit_id" class="form-control @error('unit_id') is-invalid @enderror">
                                        <option value="">-- Tidak Ada / Super Admin --</option>
                                        @foreach($units as $unit)
                                            <option value="{{ $unit->id }}" {{ (old('unit_id') == $unit->id || $user->unit_id == $unit->id) ? 'selected' : '' }}>
                                                {{ $unit->nama_unit }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Unit kerja menentukan risiko yang dapat diakses user ini.</small>
                                    @error('unit_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="card card-outline card-warning mt-3">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-lock mr-1"></i> Ganti Password</h3>
                                <div class="card-tools">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengganti password</small>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password" class="font-weight-bold" style="color:#374151;">Password Baru</label>
                                            <input type="password" id="password" name="password"
                                                   class="form-control @error('password') is-invalid @enderror"
                                                   placeholder="Minimal 8 karakter">
                                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation" class="font-weight-bold" style="color:#374151;">Konfirmasi Password Baru</label>
                                            <input type="password" id="password_confirmation" name="password_confirmation"
                                                   class="form-control" placeholder="Ulangi password baru">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save mr-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
