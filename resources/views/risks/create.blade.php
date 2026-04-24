<x-app-layout>
    @section('title', 'Tambah Risiko')
    @section('page-title', 'Identifikasi Risiko Baru')
    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('risks.index') }}">Risk Register</a></li>
        <li class="breadcrumb-item active">Tambah Risiko</li>
    @endsection

    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-success shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title font-weight-bold mb-0" style="color: var(--green-dark);">
                        <i class="fas fa-file-medical mr-2"></i> Identifikasi Risiko Baru
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('risks.store') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-gray-700">Unit Kerja <span class="text-danger">*</span></label>
                                    @if(auth()->user()->unit_id && !auth()->user()->hasRole('Super Admin'))
                                        <input type="hidden" name="unit_id" value="{{ auth()->user()->unit_id }}">
                                        <div class="form-control bg-light" style="border-left: 4px solid var(--green-main);">
                                            {{ auth()->user()->unit->nama_unit }}
                                        </div>
                                    @else
                                        <select name="unit_id" class="form-control select2 @error('unit_id') is-invalid @enderror" required>
                                            <option value="">-- Pilih Unit --</option>
                                            @foreach($units as $unit)
                                                <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                                    {{ $unit->nama_unit }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                    @error('unit_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-gray-700">Kategori Risiko <span class="text-danger">*</span></label>
                                    <select name="kategori_id" class="form-control select2 @error('kategori_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('kategori_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kategori_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold text-gray-700"><i class="fas fa-bullseye mr-1 text-success"></i> Indikator Kinerja terkait</label>
                                    <select name="performance_indicator_ids[]" class="form-control select2 @error('performance_indicator_ids') is-invalid @enderror" multiple data-placeholder="-- Pilih Satu atau Lebih Indikator Kinerja --">
                                        @foreach($indicators as $type => $group)
                                            <optgroup label="{{ $type }}">
                                                @foreach($group as $indicator)
                                                    <option value="{{ $indicator->id }}" {{ is_array(old('performance_indicator_ids')) && in_array($indicator->id, old('performance_indicator_ids')) ? 'selected' : '' }}>
                                                        {{ $indicator->code }} - {{ $indicator->name }}
                                                    </option>
                                                    @foreach($indicator->children as $child)
                                                        <option value="{{ $child->id }}" {{ is_array(old('performance_indicator_ids')) && in_array($child->id, old('performance_indicator_ids')) ? 'selected' : '' }}>
                                                            &nbsp;&nbsp;↳ {{ $child->code }} - {{ $child->name }}
                                                        </option>
                                                    @endforeach
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    @error('performance_indicator_ids')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-3">
                                    <label class="font-weight-bold text-gray-700"><i class="fas fa-bullseye mr-1 text-danger"></i> Sasaran Strategis Unit <span class="text-danger">*</span></label>
                                    <textarea name="sasaran_strategis" class="form-control @error('sasaran_strategis') is-invalid @enderror" rows="2" placeholder="Contoh: Meningkatnya efisiensi tata kelola administrasi keuangan fakultas..." required>{{ old('sasaran_strategis') }}</textarea>
                                    @error('sasaran_strategis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-2">
                            <label class="font-weight-bold text-gray-700"><i class="fas fa-exclamation-triangle mr-1 text-warning"></i> Pernyataan Risiko (Risk Statement) <span class="text-danger">*</span></label>
                            <input type="text" name="nama_risiko" value="{{ old('nama_risiko') }}" 
                                   class="form-control @error('nama_risiko') is-invalid @enderror" 
                                   placeholder="Contoh: Keterlambatan Pelaporan Keuangan BLU" required>
                            @error('nama_risiko')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">Gunakan format: [Kejadian] karena [Penyebab] dan mengakibatkan [Dampak]</small>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold text-gray-700">Deskripsi Detail</label>
                            <textarea name="deskripsi" class="form-control" rows="2" placeholder="Penjelasan tambahan mengenai konteks risiko...">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-gray-700">Penyebab (Root Cause)</label>
                                    <textarea name="penyebab" class="form-control" rows="3">{{ old('penyebab') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-gray-700">Dampak (Consequences)</label>
                                    <textarea name="dampak" class="form-control" rows="3">{{ old('dampak') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-gray-700">Pemilik Risiko (Risk Owner)</label>
                                    <input type="text" name="pemilik_risiko" value="{{ old('pemilik_risiko') }}" class="form-control" placeholder="Jabatan/Pihak bertanggung jawab">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-gray-700">Tanggal Identifikasi <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_identifikasi" value="{{ old('tanggal_identifikasi', date('Y-m-d')) }}" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h6 class="font-weight-bold mb-3" style="color: var(--green-mid);"><i class="fas fa-calculator mr-2"></i> Pengukuran Risiko (Skoring)</h6>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Probabilitas (1-5)</label>
                                    <select id="probabilitas" name="probabilitas" class="form-control scoring-input">
                                        <option value="1">1 - Sangat Jarang</option>
                                        <option value="2">2 - Jarang</option>
                                        <option value="3">3 - Kadang-kadang / Mungkin</option>
                                        <option value="4">4 - Sering</option>
                                        <option value="5">5 - Sangat Sering / Hampir Pasti</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Level Dampak (1-5)</label>
                                    <select id="level_dampak" name="level_dampak" class="form-control scoring-input">
                                        <option value="1">1 - Sangat Rendah / Insignificant</option>
                                        <option value="2">2 - Rendah / Minor</option>
                                        <option value="3">3 - Sedang / Moderate</option>
                                        <option value="4">4 - Tinggi / Major</option>
                                        <option value="5">5 - Sangat Tinggi / Catastrophic</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 rounded mb-4 d-flex align-items-center transition-all shadow-sm" id="score-preview-box" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <div class="mr-4">
                                <div class="text-xs text-uppercase font-weight-bold text-muted mb-1">Skor Risiko</div>
                                <div id="score-value" class="h2 mb-0 font-weight-bold" style="color: #1e293b;">1</div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="text-xs text-uppercase font-weight-bold text-muted mb-1">Level Risiko (ISO 31000)</div>
                                <div id="level-label" class="badge px-3 py-2 text-uppercase" style="font-size: 0.9rem; background: #10b981; color: #fff;">LOW SUCCESS</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('risks.index') }}" class="btn btn-light px-4">Batal</a>
                            <button type="submit" class="btn btn-success px-5 font-weight-bold shadow-sm">
                                <i class="fas fa-save mr-2"></i> Simpan Risiko (Draft)
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function updateRiskCalculation() {
            const prob = parseInt(document.getElementById('probabilitas').value) || 1;
            const impact = parseInt(document.getElementById('level_dampak').value) || 1;
            const score = prob * impact;
            
            const scoreVal = document.getElementById('score-value');
            const levelLabel = document.getElementById('level-label');
            const previewBox = document.getElementById('score-preview-box');

            scoreVal.textContent = score;

            let color = '#10b981';
            let label = 'Low';

            if (score >= 16) {
                color = '#ef4444';
                label = 'Extreme';
            } else if (score >= 11) {
                color = '#f97316';
                label = 'High';
            } else if (score >= 6) {
                color = '#f59e0b';
                label = 'Medium';
            }

            levelLabel.textContent = label;
            levelLabel.style.backgroundColor = color;
            previewBox.style.borderLeft = `5px solid ${color}`;
        }

        document.querySelectorAll('.scoring-input').forEach(el => {
            el.addEventListener('change', updateRiskCalculation);
        });

        // Init
        updateRiskCalculation();
    </script>
    @endpush
</x-app-layout>
