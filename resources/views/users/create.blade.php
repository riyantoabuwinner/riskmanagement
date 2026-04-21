<x-app-layout>
    @section('title', 'Tambah User')
    @section('page-title', 'Tambah Pengguna Baru')
    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User Management</a></li>
        <li class="breadcrumb-item active">Tambah User</li>
    @endsection

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <i class="fas fa-user-plus mr-2" style="color:#047857;"></i>
                    <h3 class="card-title mb-0">Form Tambah Pengguna</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="font-weight-bold" style="color:#374151;">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                                           class="form-control @error('name') is-invalid @enderror"
                                           placeholder="Masukkan nama lengkap" required autofocus>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="font-weight-bold" style="color:#374151;">Email <span class="text-danger">*</span></label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                                           class="form-control @error('email') is-invalid @enderror"
                                           placeholder="email@uinsc.ac.id" required>
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
                                            <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
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
                                            <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                                {{ $unit->nama_unit }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-muted">Unit kerja menentukan risiko mana yang dapat diakses user ini.</small>
                                    @error('unit_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="font-weight-bold" style="color:#374151;">Password <span class="text-danger">*</span></label>
                                    <input type="password" id="password" name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Minimal 8 karakter" required>
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation" class="font-weight-bold" style="color:#374151;">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                           class="form-control"
                                           placeholder="Ulangi password" required>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save mr-1"></i> Simpan Pengguna
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
