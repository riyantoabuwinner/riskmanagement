<x-app-layout>
    @section('title', 'Kategori Risiko')
    @section('page-title', 'Kategori Risiko')

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 font-weight-bold" style="color: var(--green-dark);"><i class="fas fa-tags mr-2"></i>
                        Kategori Risiko</h5>
                    <button type="button" class="btn btn-success btn-sm shadow-sm" data-toggle="modal"
                        data-target="#addCategoryModal">
                        <i class="fas fa-plus mr-1"></i> Tambah Kategori
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr class="text-xs text-uppercase text-muted">
                                    <th class="px-4">Kode</th>
                                    <th>Nama Kategori</th>
                                    <th>Deskripsi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td class="px-4 font-weight-bold"><span class="badge badge-info px-2"
                                                style="background-color:#475569;">{{ $category->kode ?? 'N/A' }}</span></td>
                                        <td class="font-weight-bold">{{ $category->nama_kategori }}</td>
                                        <td class="text-muted">{{ $category->deskripsi ?? '-' }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-light text-primary shadow-sm" data-toggle="modal"
                                                data-target="#editCategoryModal{{ $category->id }}"><i
                                                    class="fas fa-edit"></i></button>
                                            <form action="{{ route('risk-categories.destroy', $category) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-light text-danger shadow-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">Belum ada data kategori risiko.
                                        </td>
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
    @foreach($categories as $category)
    <div class="modal fade" id="editCategoryModal{{ $category->id }}" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="{{ route('risk-categories.update', $category) }}" method="POST"
                class="modal-content border-0 shadow-xl" style="border-radius: 15px; background: #fff;">
                @csrf
                @method('PUT')
                <div class="modal-header border-bottom-0 pt-4 px-4 bg-white" style="border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title font-weight-bold text-dark"><i class="fas fa-edit mr-2 text-primary"></i> Edit Kategori Risiko</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold text-dark">Kode</label>
                                <input type="text" name="kode" class="form-control shadow-sm"
                                    value="{{ $category->kode }}" placeholder="AUTO">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="font-weight-bold text-dark">Nama Kategori <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="nama_kategori" class="form-control shadow-sm"
                                    value="{{ $category->nama_kategori }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control shadow-sm"
                            rows="3">{{ $category->deskripsi }}</textarea>
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

    <!-- Modal Add Category -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="{{ route('risk-categories.store') }}" method="POST" class="modal-content border-0 shadow-xl"
                style="border-radius: 15px; background: #fff;">
                @csrf
                <div class="modal-header border-bottom-0 pt-4 px-4 bg-white" style="border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title font-weight-bold text-dark"><i class="fas fa-plus-circle mr-2 text-success"></i> Tambah Kategori Risiko</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="font-weight-bold text-dark">Kode</label>
                                <input type="text" name="kode" class="form-control shadow-sm" placeholder="AUTO">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="font-weight-bold text-dark">Nama Kategori <span class="text-danger">*</span></label>
                                <input type="text" name="nama_kategori" class="form-control shadow-sm" required
                                    placeholder="Contoh: Operasional">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label class="font-weight-bold text-dark">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control shadow-sm" rows="3"
                            placeholder="Keterangan singkat kategori"></textarea>
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