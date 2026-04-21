<x-app-layout>
    @section('title', 'Manajemen Unit Kerja')
    @section('page-title', 'Manajemen Unit Kerja')

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold" style="color: var(--green-dark);"><i
                            class="fas fa-building mr-2"></i> Daftar Unit Kerja</h5>
                    <button type="button" class="btn btn-success btn-sm shadow-sm" data-toggle="modal"
                        data-target="#addUnitModal">
                        <i class="fas fa-plus mr-1"></i> Tambah Unit
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr class="text-xs text-uppercase text-muted">
                                    <th class="px-4">Kode</th>
                                    <th>Nama Unit</th>
                                    <th>Jenis</th>
                                    <th>Pimpinan</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($units as $unit)
                                    <tr>
                                        <td class="px-4 font-weight-bold"><span class="badge badge-primary px-2"
                                                style="background-color:#047857;">{{ $unit->kode ?? 'N/A' }}</span></td>
                                        <td class="font-weight-bold">{{ $unit->nama_unit }}</td>
                                        <td><span
                                                class="badge badge-light border">{{ $unit->unitType->nama_jenis ?? 'N/A' }}</span>
                                        </td>
                                        <td>{{ $unit->pimpinan ?? '-' }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-light text-primary shadow-sm" data-toggle="modal"
                                                data-target="#editUnitModal{{ $unit->id }}"><i
                                                    class="fas fa-edit"></i></button>
                                            <form action="{{ route('units.destroy', $unit) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light text-danger shadow-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus unit kerja ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">Belum ada data unit kerja.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals Section -->
    @foreach($units as $unit)
    <div class="modal fade" id="editUnitModal{{ $unit->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="{{ route('units.update', $unit) }}" method="POST"
                class="modal-content border-0 shadow-xl" style="border-radius: 15px; background: #fff;">
                @csrf
                @method('PUT')
                <div class="modal-header border-bottom-0 pt-4 px-4 bg-white" style="border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title font-weight-bold text-dark"><i class="fas fa-edit mr-2 text-primary"></i> Edit Unit Kerja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold text-dark">Kode Unit</label>
                                <input type="text" name="kode" class="form-control shadow-sm"
                                    value="{{ $unit->kode }}" placeholder="AUTO">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="font-weight-bold text-dark">Nama Unit <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="nama_unit" class="form-control shadow-sm"
                                    value="{{ $unit->nama_unit }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold text-dark">Jenis Unit <span
                                class="text-danger">*</span></label>
                        <select name="unit_type_id" class="form-control shadow-sm" required>
                            @foreach($unitTypes as $type)
                                <option value="{{ $type->id }}" {{ $unit->unit_type_id == $type->id ? 'selected' : '' }}>
                                    {{ $type->nama_jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark">Pimpinan</label>
                        <input type="text" name="pimpinan" class="form-control shadow-sm"
                            value="{{ $unit->pimpinan }}">
                    </div>
                </div>
                <div class="modal-footer border-top-0 pb-4 px-4 bg-white" style="border-radius: 0 0 15px 15px;">
                    <button type="button" class="btn btn-light px-4 mr-2" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success px-4 font-weight-bold shadow-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
    @endforeach

    <!-- Modal Add Unit -->
    <div class="modal fade" id="addUnitModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="{{ route('units.store') }}" method="POST" class="modal-content border-0 shadow-xl"
                style="border-radius: 15px; background: #fff;">
                @csrf
                <div class="modal-header border-bottom-0 pt-4 px-4 bg-white" style="border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title font-weight-bold text-dark"><i class="fas fa-plus-circle mr-2 text-success"></i> Tambah Unit Kerja</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold text-dark">Kode Unit</label>
                                <input type="text" name="kode" class="form-control shadow-sm" placeholder="AUTO">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="font-weight-bold text-dark">Nama Unit <span class="text-danger">*</span></label>
                                <input type="text" name="nama_unit" class="form-control shadow-sm" required
                                    placeholder="Contoh: Fakultas Tarbiyah">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold text-dark">Jenis Unit <span class="text-danger">*</span></label>
                        <select name="unit_type_id" class="form-control shadow-sm" required>
                            <option value="">-- Pilih Jenis Unit --</option>
                            @foreach($unitTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->nama_jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark">Pimpinan</label>
                        <input type="text" name="pimpinan" class="form-control shadow-sm" placeholder="Nama Pimpinan Unit">
                    </div>
                </div>
                <div class="modal-footer border-top-0 pb-4 px-4 bg-white" style="border-radius: 0 0 15px 15px;">
                    <button type="button" class="btn btn-light px-4 mr-2" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success px-4 font-weight-bold shadow-sm">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>