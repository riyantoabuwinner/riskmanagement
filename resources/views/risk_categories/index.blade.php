<x-app-layout>
    @section('title', 'Kategori Risiko')
    @section('page-title', 'Kategori Risiko')

    <div class="row">
        <div class="col-12">
            <form id="bulk-delete-form" action="{{ route('risk-categories.bulk-delete') }}" method="POST">
                @csrf
                <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 font-weight-bold" style="color: var(--green-dark);"><i class="fas fa-tags mr-2"></i>
                                Kategori Risiko</h5>
                        </div>
                        <div class="d-flex" style="gap: 8px;">
                            <button type="button" id="bulk-delete-btn" class="btn btn-danger btn-sm shadow-sm d-none" onclick="confirmBulkDelete()">
                                <i class="fas fa-trash mr-1"></i> Hapus Terpilih (<span id="selected-count">0</span>)
                            </button>
                            <button type="button" class="btn btn-outline-success btn-sm shadow-sm" data-toggle="modal" data-target="#importExcelModal">
                                <i class="fas fa-file-import mr-1"></i> Import Excel
                            </button>
                            <button type="button" class="btn btn-success btn-sm shadow-sm" data-toggle="modal"
                                data-target="#addCategoryModal">
                                <i class="fas fa-plus mr-1"></i> Tambah Kategori
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr class="text-xs text-uppercase text-muted">
                                        <th class="px-4" style="width: 40px;">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkAll">
                                                <label class="custom-control-label" for="checkAll"></label>
                                            </div>
                                        </th>
                                        <th style="width: 100px;">Kode</th>
                                        <th>Nama Kategori</th>
                                        <th>Deskripsi</th>
                                        <th class="text-center">Jumlah Risiko</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($categories as $category)
                                        <tr>
                                            <td class="px-4">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="ids[]" value="{{ $category->id }}" class="custom-control-input row-checkbox" id="check{{ $category->id }}">
                                                    <label class="custom-control-label" for="check{{ $category->id }}"></label>
                                                </div>
                                            </td>
                                            <td class="font-weight-bold"><span class="badge badge-info px-2"
                                                    style="background-color:#475569;">{{ $category->kode ?? 'N/A' }}</span></td>
                                            <td class="font-weight-bold">{{ $category->nama_kategori }}</td>
                                            <td class="text-muted">{{ $category->deskripsi ?? '-' }}</td>
                                            <td class="text-center">
                                                <span class="badge badge-pill {{ $category->risks_count > 0 ? 'badge-primary' : 'badge-light' }} shadow-sm" style="font-size: 0.85rem; padding: 5px 12px; background-color: {{ $category->risks_count > 0 ? '#475569' : '' }}; color: {{ $category->risks_count > 0 ? '#fff' : '' }};">
                                                    {{ $category->risks_count }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-light text-primary shadow-sm" data-toggle="modal"
                                                    data-target="#editCategoryModal{{ $category->id }}"><i
                                                        class="fas fa-edit"></i></button>
                                                <button type="button" class="btn btn-sm btn-light text-danger shadow-sm" onclick="confirmDelete('{{ route('risk-categories.destroy', $category) }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">Belum ada data kategori risiko.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Hidden Delete Form -->
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

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

    <!-- Modal Import Excel -->
    <div class="modal fade" id="importExcelModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form action="{{ route('risk-categories.import') }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-xl" style="border-radius: 15px;">
                @csrf
                <div class="modal-header border-bottom-0 pt-4 px-4">
                    <h5 class="modal-title font-weight-bold text-dark"><i class="fas fa-file-excel mr-2 text-success"></i> Import Kategori Risiko</h5>
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
                        <a href="{{ route('risk-categories.template') }}" class="btn btn-link text-success font-weight-bold p-0">
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
                $('.row-checkbox').prop('checked', $(this).prop('checked'));
                updateBulkDeleteButton();
            });

            // Handle Row Checkbox change
            $('.row-checkbox').on('change', function() {
                if ($('.row-checkbox:checked').length == $('.row-checkbox').length) {
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
            if (confirm('Apakah Anda yakin ingin menghapus ' + $('.row-checkbox:checked').length + ' data terpilih?')) {
                $('#bulk-delete-form').submit();
            }
        }

        function confirmDelete(url) {
            if (confirm('Apakah Anda yakin ingin menghapus kategori risiko ini?')) {
                const form = $('#delete-form');
                form.attr('action', url);
                form.submit();
            }
        }
    </script>
    @endpush
</x-app-layout>