<x-app-layout>
    @section('title', 'Jenis Unit')
    @section('page-title', 'Jenis Unit')

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold" style="color: var(--green-dark);"><i class="fas fa-layer-group mr-2"></i> Jenis Unit Kerja</h5>
                    <button type="button" class="btn btn-success btn-sm shadow-sm" data-toggle="modal" data-target="#addTypeModal">
                        <i class="fas fa-plus mr-1"></i> Tambah Jenis
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr class="text-xs text-uppercase text-muted">
                                    <th class="px-4">Nama Jenis</th>
                                    <th>Deskripsi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($types as $type)
                                <tr>
                                    <td class="px-4 font-weight-bold">{{ $type->nama_jenis }}</td>
                                    <td class="text-muted">{{ $type->deskripsi ?? '-' }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-light text-primary shadow-sm" data-toggle="modal" data-target="#editTypeModal{{ $type->id }}"><i class="fas fa-edit"></i></button>
                                        <form action="{{ route('unit-types.destroy', $type) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light text-danger shadow-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus jenis unit ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">Belum ada data jenis unit.</td>
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
    @foreach($types as $type)
    <div class="modal fade" id="editTypeModal{{ $type->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="{{ route('unit-types.update', $type) }}" method="POST" class="modal-content border-0 shadow-xl" style="border-radius: 15px; background: #fff;">
                @csrf
                @method('PUT')
                <div class="modal-header border-bottom-0 pt-4 px-4 bg-white" style="border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title font-weight-bold text-dark"><i class="fas fa-edit mr-2 text-primary"></i> Edit Jenis Unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark mb-2">Nama Jenis <span class="text-danger">*</span></label>
                        <input type="text" name="nama_jenis" class="form-control form-control-lg shadow-sm" value="{{ $type->nama_jenis }}" required style="font-size: 1rem;">
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark mb-2">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control shadow-sm" rows="4" style="font-size: 0.9rem;">{{ $type->deskripsi }}</textarea>
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

    <!-- Modal Add Type -->
    <div class="modal fade" id="addTypeModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="{{ route('unit-types.store') }}" method="POST" class="modal-content border-0 shadow-xl" style="border-radius: 15px; background: #fff;">
                @csrf
                <div class="modal-header border-bottom-0 pt-4 px-4 bg-white" style="border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title font-weight-bold text-dark"><i class="fas fa-plus-circle mr-2 text-success"></i> Tambah Jenis Unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-4">
                    <div class="form-group mb-3">
                        <label class="font-weight-bold text-dark mb-2">Nama Jenis <span class="text-danger">*</span></label>
                        <input type="text" name="nama_jenis" class="form-control form-control-lg shadow-sm" required placeholder="Contoh: Fakultas, Lembaga, Pusat" style="font-size: 1rem;">
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark mb-2">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control shadow-sm" rows="4" placeholder="Keterangan singkat jenis unit" style="font-size: 0.9rem;"></textarea>
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
