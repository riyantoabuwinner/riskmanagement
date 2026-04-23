<x-app-layout>
    @section('title', 'Manajemen Unit Kerja')
    @section('page-title', 'Manajemen Unit Kerja')

    <div class="row">
        <div class="col-12">
            <form id="bulk-delete-form" action="{{ route('units.bulk-delete') }}" method="POST">
                @csrf
                <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 font-weight-bold" style="color: var(--green-dark);"><i
                                    class="fas fa-building mr-2"></i> Daftar Unit Kerja</h5>
                        </div>
                        <div class="d-flex" style="gap: 8px;">
                            <button type="button" id="bulk-delete-btn" class="btn btn-danger btn-sm shadow-sm d-none" onclick="confirmBulkDelete()">
                                <i class="fas fa-trash mr-1"></i> Hapus Terpilih (<span id="selected-count">0</span>)
                            </button>
                            <button type="button" class="btn btn-outline-success btn-sm shadow-sm" data-toggle="modal" data-target="#importExcelModal">
                                <i class="fas fa-file-import mr-1"></i> Import Excel
                            </button>
                            <button type="button" class="btn btn-success btn-sm shadow-sm" data-toggle="modal"
                                data-target="#addUnitModal">
                                <i class="fas fa-plus mr-1"></i> Tambah Unit
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
                                        <th>Nama Unit</th>
                                        <th>Jenis</th>
                                        <th>Pimpinan</th>
                                        <th class="text-center">Jumlah Risiko</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($units as $unit)
                                        <tr>
                                            <td class="px-4">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="ids[]" value="{{ $unit->id }}" class="custom-control-input row-checkbox" id="check{{ $unit->id }}">
                                                    <label class="custom-control-label" for="check{{ $unit->id }}"></label>
                                                </div>
                                            </td>
                                            <td class="font-weight-bold"><span class="badge badge-primary px-2"
                                                    style="background-color:#047857;">{{ $unit->kode ?? 'N/A' }}</span></td>
                                            <td class="font-weight-bold">{{ $unit->nama_unit }}</td>
                                            <td><span
                                                    class="badge badge-light border">{{ $unit->unitType->nama_jenis ?? 'N/A' }}</span>
                                            </td>
                                            <td>{{ $unit->pimpinan ?? '-' }}</td>
                                            <td class="text-center">
                                                <span class="badge badge-pill {{ $unit->risks_count > 0 ? 'badge-success' : 'badge-light' }} shadow-sm" style="font-size: 0.85rem; padding: 5px 12px;">
                                                    {{ $unit->risks_count }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-light text-primary shadow-sm" data-toggle="modal"
                                                    data-target="#editUnitModal{{ $unit->id }}"><i
                                                        class="fas fa-edit"></i></button>
                                                <button type="button" class="btn btn-sm btn-light text-danger shadow-sm"
                                                        onclick="confirmDelete('{{ route('units.destroy', $unit) }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-5 text-muted">Belum ada data unit kerja.</td>
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
                        @php
                            $pimpinanOptions = ['Rektor', 'Wakil Rektor', 'Kepala Biro', 'Ketua Lembaga', 'Kepala Pusat', 'Kepala UPT', 'Dekan', 'Ketua Program Studi'];
                            $isOther = !empty($unit->pimpinan) && !in_array($unit->pimpinan, $pimpinanOptions);
                        @endphp
                        <select class="form-control shadow-sm pimpinan-select" data-target="pimpinan-other-{{ $unit->id }}">
                            <option value="">-- Pilih Pimpinan --</option>
                            @foreach($pimpinanOptions as $opt)
                                <option value="{{ $opt }}" {{ $unit->pimpinan == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                            @endforeach
                            <option value="Lainnya" {{ $isOther ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        <textarea name="pimpinan" id="pimpinan-other-{{ $unit->id }}" 
                            class="form-control shadow-sm mt-2 {{ $isOther ? '' : 'd-none' }}" 
                            rows="2" placeholder="Sebutkan pimpinan lainnya...">{{ $unit->pimpinan }}</textarea>
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
                        <select class="form-control shadow-sm pimpinan-select" data-target="pimpinan-other-add">
                            <option value="">-- Pilih Pimpinan --</option>
                            <option value="Rektor">Rektor</option>
                            <option value="Wakil Rektor">Wakil Rektor</option>
                            <option value="Kepala Biro">Kepala Biro</option>
                            <option value="Ketua Lembaga">Ketua Lembaga</option>
                            <option value="Kepala Pusat">Kepala Pusat</option>
                            <option value="Kepala UPT">Kepala UPT</option>
                            <option value="Dekan">Dekan</option>
                            <option value="Ketua Program Studi">Ketua Program Studi</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        <textarea name="pimpinan" id="pimpinan-other-add" class="form-control shadow-sm mt-2 d-none" 
                            rows="2" placeholder="Sebutkan pimpinan lainnya..."></textarea>
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
            <form action="{{ route('units.import') }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-xl" style="border-radius: 15px;">
                @csrf
                <div class="modal-header border-bottom-0 pt-4 px-4">
                    <h5 class="modal-title font-weight-bold text-dark"><i class="fas fa-file-excel mr-2 text-success"></i> Import Unit Kerja</h5>
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
                        <a href="{{ route('units.template') }}" class="btn btn-link text-success font-weight-bold p-0">
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
            // Handle Pimpinan Select change
            $('.pimpinan-select').on('change', function() {
                const targetId = $(this).data('target');
                const otherInput = $('#' + targetId);
                const selectedVal = $(this).val();

                if (selectedVal === 'Lainnya') {
                    otherInput.removeClass('d-none').val('').attr('required', true).focus();
                } else {
                    otherInput.addClass('d-none').val(selectedVal).attr('required', false);
                }
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
            if (confirm('Apakah Anda yakin ingin menghapus unit kerja ini?')) {
                const form = $('#delete-form');
                form.attr('action', url);
                form.submit();
            }
        }
    </script>
    @endpush
</x-app-layout>