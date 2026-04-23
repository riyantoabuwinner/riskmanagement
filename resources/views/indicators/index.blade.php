<x-app-layout>
    @section('title', 'Manajemen Indikator Kinerja')
    @section('page-title', 'Indikator Kinerja')
    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="#">Data Master</a></li>
        <li class="breadcrumb-item active">Indikator Kinerja</li>
    @endsection

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Daftar Indikator Kinerja</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAdd">
                    <i class="fas fa-plus mr-1"></i> Kelola Indikator
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-tabs mb-4" id="indicatorTabs" role="tablist">
                        @foreach(['ASTA PROTAS', 'IKU PTN', 'PERKIN PENDIS', 'SDGs'] as $index => $type)
                        <li class="nav-item">
                            <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="{{ Str::slug($type) }}-tab" data-toggle="pill" href="#tab-{{ Str::slug($type) }}" role="tab">
                                {{ $type }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    
                    <div class="tab-content" id="indicatorTabsContent">
                        @foreach(['ASTA PROTAS', 'IKU PTN', 'PERKIN PENDIS', 'SDGs'] as $index => $type)
                        <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="tab-{{ Str::slug($type) }}" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    <h5 class="mb-0 font-weight-bold text-uppercase">{{ $type }}</h5>
                                    <small class="text-muted">Periode: {{ $type }} (2026)</small>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 15%">KODE</th>
                                            <th>NAMA INDIKATOR</th>
                                            <th class="text-center" style="width: 120px">JUMLAH RISIKO</th>
                                            <th style="width: 150px" class="text-center">AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($indicators[$type] as $indicator)
                                            {{-- Parent Row --}}
                                            <tr>
                                                <td class="font-weight-bold">{{ $indicator->code }}</td>
                                                <td class="font-weight-bold">{{ $indicator->name }}</td>
                                                <td class="text-center">
                                                    <span class="badge badge-pill {{ $indicator->risks_count > 0 ? 'badge-success' : 'badge-light' }} shadow-sm" style="font-size: 0.8rem; padding: 4px 10px;">
                                                        {{ $indicator->risks_count }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm btn-outline-primary mr-1 btn-edit" 
                                                            data-id="{{ $indicator->id }}" 
                                                            data-code="{{ $indicator->code }}" 
                                                            data-name="{{ $indicator->name }}" 
                                                            data-type="{{ $indicator->type }}"
                                                            data-period="{{ $indicator->period }}"
                                                            data-parent="">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-success mr-1 btn-add-sub"
                                                            data-parent-id="{{ $indicator->id }}"
                                                            data-type="{{ $indicator->type }}">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                        <form action="{{ route('performance-indicators.destroy', $indicator->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus indikator ini? Menghapus parent akan menghapus semua sub-indikator.')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            {{-- Children Rows --}}
                                            @foreach($indicator->children as $child)
                                            <tr class="bg-light">
                                                <td style="padding-left: 2.5rem;"><i class="fas fa-level-up-alt fa-rotate-90 mr-2 text-muted"></i> {{ $child->code }}</td>
                                                <td style="padding-left: 1rem;">{{ $child->name }}</td>
                                                <td class="text-center">
                                                    <span class="badge badge-pill {{ $child->risks_count > 0 ? 'badge-info' : 'badge-light' }} border shadow-xs" style="font-size: 0.75rem; padding: 3px 8px; font-weight: 500;">
                                                        {{ $child->risks_count }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-sm text-primary mr-2 btn-edit"
                                                            data-id="{{ $child->id }}" 
                                                            data-code="{{ $child->code }}" 
                                                            data-name="{{ $child->name }}" 
                                                            data-type="{{ $child->type }}"
                                                            data-period="{{ $child->period }}"
                                                            data-parent="{{ $indicator->id }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <form action="{{ route('performance-indicators.destroy', $child->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sub-indikator ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm text-danger">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted small">Belum ada data indikator untuk kategori ini.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add -->
    <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('performance-indicators.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalTitle">Tambah Indikator Baru</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="type" id="add-type" class="form-control" required>
                                <option value="ASTA PROTAS">ASTA PROTAS</option>
                                <option value="IKU PTN">IKU PTN</option>
                                <option value="PERKIN PENDIS">PERKIN PENDIS</option>
                                <option value="SDGs">SDGs</option>
                            </select>
                        </div>
                        <div class="form-group" id="parent-group" style="display:none;">
                            <label>Parent Indicator</label>
                            <select name="parent_id" id="add-parent-id" class="form-control">
                                <option value="">Tanpa Parent</option>
                                @foreach($indicators as $type => $list)
                                    @foreach($list as $p)
                                        <option value="{{ $p->id }}" data-type="{{ $type }}">{{ $p->code }} - {{ $p->name }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kode</label>
                            <input type="text" name="code" class="form-control" placeholder="Contoh: PROTAS-1" required>
                        </div>
                        <div class="form-group">
                            <label>Nama Indikator</label>
                            <textarea name="name" class="form-control" rows="3" placeholder="Masukkan nama indikator..." required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Periode</label>
                            <input type="text" name="period" class="form-control" value="2026" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="formEdit" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Indikator</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="type" id="edit-type" class="form-control" required>
                                <option value="ASTA PROTAS">ASTA PROTAS</option>
                                <option value="IKU PTN">IKU PTN</option>
                                <option value="PERKIN PENDIS">PERKIN PENDIS</option>
                                <option value="SDGs">SDGs</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Parent Indicator</label>
                            <select name="parent_id" id="edit-parent-id" class="form-control">
                                <option value="">Tanpa Parent</option>
                                @foreach($indicators as $type => $list)
                                    @foreach($list as $p)
                                        <option value="{{ $p->id }}" data-type="{{ $type }}">{{ $p->code }} - {{ $p->name }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Kode</label>
                            <input type="text" name="code" id="edit-code" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Nama Indikator</label>
                            <textarea name="name" id="edit-name" class="form-control" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Periode</label>
                            <input type="text" name="period" id="edit-period" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Edit Button
            $('.btn-edit').click(function() {
                const id = $(this).data('id');
                const code = $(this).data('code');
                const name = $(this).data('name');
                const type = $(this).data('type');
                const period = $(this).data('period');
                const parentId = $(this).data('parent');
                
                $('#formEdit').attr('action', `/performance-indicators/${id}`);
                $('#edit-code').val(code);
                $('#edit-name').val(name);
                $('#edit-type').val(type);
                $('#edit-period').val(period);
                $('#edit-parent-id').val(parentId);
                
                $('#modalEdit').modal('show');
            });

            // Add Sub-Indicator Button
            $('.btn-add-sub').click(function() {
                const parentId = $(this).data('parent-id');
                const type = $(this).data('type');
                
                $('#addModalTitle').text('Tambah Sub-Indikator');
                $('#add-type').val(type);
                $('#add-parent-id').val(parentId);
                $('#parent-group').show();
                
                $('#modalAdd').modal('show');
            });

            // Reset Add Modal on close
            $('#modalAdd').on('hidden.bs.modal', function () {
                $('#addModalTitle').text('Tambah Indikator Baru');
                $('#parent-group').hide();
                $('#add-parent-id').val('');
            });
        });
    </script>
    @endpush

    @push('styles')
    <style>
        .nav-tabs .nav-link {
            border: none;
            color: #6b7280;
            font-weight: 600;
            padding: 12px 24px;
            border-bottom: 2px solid transparent;
            transition: all 0.2s;
        }
        .nav-tabs .nav-link:hover {
            color: var(--green-main);
            background: rgba(4, 120, 87, 0.05);
        }
        .nav-tabs .nav-link.active {
            color: var(--green-main);
            border-bottom-color: var(--green-main);
            background: none;
        }
        .table thead th {
            background: #f9fafb !important;
            color: #374151 !important;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            border-top: none !important;
        }
        [data-theme="dark"] .table thead th {
            background: #1e293b !important;
            color: #cbd5e1 !important;
        }
        .table tr.bg-light:hover {
            background-color: #f3f4f6 !important;
        }
    </style>
    @endpush
</x-app-layout>
