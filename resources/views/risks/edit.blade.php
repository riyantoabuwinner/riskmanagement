<x-app-layout>
    @section('title', 'Edit Risiko')
    @section('page-title', 'Edit Identifikasi Risiko')
    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('risks.index') }}">Risk Register</a></li>
        <li class="breadcrumb-item active">Edit Risiko</li>
    @endsection

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card card-outline card-success shadow-sm border-0">
                <div class="card-header d-flex align-items-center bg-white py-3">
                    <i class="fas fa-edit mr-2 text-success"></i>
                    <h3 class="card-title mb-0 font-weight-bold" style="color: var(--green-dark);">Form Edit Identifikasi Risiko</h3>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('risks.update', $risk) }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-dark">Unit Kerja <span class="text-danger">*</span></label>
                                    <div class="form-control" style="background:#f8fafc; border-color:#e2e8f0; color:#475569; font-weight:600;">
                                        <i class="fas fa-building mr-2 text-muted"></i>
                                        {{ $risk->unit->nama_unit ?? 'N/A' }}
                                    </div>
                                    <input type="hidden" name="unit_id" value="{{ $risk->unit_id }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kategori_id" class="font-weight-bold text-dark">Kategori Risiko <span class="text-danger">*</span></label>
                                    <select id="kategori_id" name="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('kategori_id', $risk->kategori_id) == $category->id ? 'selected' : '' }}>
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
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold text-dark"><i class="fas fa-bullseye mr-1 text-success"></i> Indikator Kinerja terkait</label>
                                    <select name="misi_universitas[]" class="form-control select2 @error('misi_universitas') is-invalid @enderror" multiple data-placeholder="-- Pilih Satu atau Lebih Indikator Kinerja --">
                                        @foreach($indicators as $type => $group)
                                            <optgroup label="{{ $type }}">
                                                @foreach($group as $indicator)
                                                    @php 
                                                        $val = $indicator->code . ' - ' . $indicator->name; 
                                                        $currentValues = old('misi_universitas', $risk->misi_universitas ?? []);
                                                    @endphp
                                                    <option value="{{ $val }}" {{ is_array($currentValues) && in_array($val, $currentValues) ? 'selected' : '' }}>
                                                        {{ $indicator->code }} - {{ $indicator->name }}
                                                    </option>
                                                    @foreach($indicator->children as $child)
                                                        @php 
                                                            $cval = $child->code . ' - ' . $child->name; 
                                                        @endphp
                                                        <option value="{{ $cval }}" {{ is_array($currentValues) && in_array($cval, $currentValues) ? 'selected' : '' }}>
                                                            &nbsp;&nbsp;↳ {{ $child->code }} - {{ $child->name }}
                                                        </option>
                                                    @endforeach
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                    @error('misi_universitas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-4">
                                    <label class="font-weight-bold text-dark"><i class="fas fa-bullseye mr-1 text-danger"></i> Sasaran Strategis Unit <span class="text-danger">*</span></label>
                                    <textarea name="sasaran_strategis" class="form-control @error('sasaran_strategis') is-invalid @enderror" rows="2" required>{{ old('sasaran_strategis', $risk->sasaran_strategis) }}</textarea>
                                    @error('sasaran_strategis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="nama_risiko" class="font-weight-bold text-dark"><i class="fas fa-exclamation-triangle mr-1 text-warning"></i> Pernyataan Risiko (Risk Statement) <span class="text-danger">*</span></label>
                            <input type="text" id="nama_risiko" name="nama_risiko" value="{{ old('nama_risiko', $risk->nama_risiko) }}"
                                   class="form-control @error('nama_risiko') is-invalid @enderror"
                                   placeholder="Contoh: Kegagalan sistem KRS online" required>
                            @error('nama_risiko')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">Gunakan format: [Kejadian] karena [Penyebab] dan mengakibatkan [Dampak]</small>
                        </div>

                        <div class="form-group mb-4">
                            <label for="deskripsi" class="font-weight-bold text-dark">Deskripsi Risiko</label>
                            <textarea id="deskripsi" name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="3"
                                      placeholder="Jelaskan detail risiko...">{{ old('deskripsi', $risk->deskripsi) }}</textarea>
                            @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="penyebab" class="font-weight-bold text-dark">Penyebab (Root Cause)</label>
                                    <textarea id="penyebab" name="penyebab" class="form-control @error('penyebab') is-invalid @enderror" rows="3"
                                              placeholder="Pemicu terjadinya risiko...">{{ old('penyebab', $risk->penyebab) }}</textarea>
                                    @error('penyebab')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dampak" class="font-weight-bold text-dark">Dampak (Consequences)</label>
                                    <textarea id="dampak" name="dampak" class="form-control @error('dampak') is-invalid @enderror" rows="3"
                                              placeholder="Akibat jika risiko terjadi...">{{ old('dampak', $risk->dampak) }}</textarea>
                                    @error('dampak')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="probabilitas" class="font-weight-bold text-dark">Probabilitas (1-5) <span class="text-danger">*</span></label>
                                    <select id="probabilitas" name="probabilitas" class="form-control scoring-input @error('probabilitas') is-invalid @enderror" required>
                                        @for($i=1; $i<=5; $i++)
                                        <option value="{{ $i }}" {{ old('probabilitas', $risk->probabilitas) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="level_dampak" class="font-weight-bold text-dark">Level Dampak (1-5) <span class="text-danger">*</span></label>
                                    <select id="level_dampak" name="level_dampak" class="form-control scoring-input @error('level_dampak') is-invalid @enderror" required>
                                        @for($i=1; $i<=5; $i++)
                                        <option value="{{ $i }}" {{ old('level_dampak', $risk->level_dampak) == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 mb-4 rounded border-left shadow-sm bg-white" id="score-preview-box" style="border-left: 5px solid var(--green-main);">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h6 class="text-muted text-uppercase small font-weight-bold">Estimasi Skor Risiko (Inherent)</h6>
                                    <div class="d-flex align-items-center">
                                        <span class="display-4 font-weight-bold mr-3" id="score-value">{{ $risk->skor_risiko }}</span>
                                        <span class="badge badge-success px-3 py-2 text-uppercase" id="level-label" style="font-size: 1rem; letter-spacing: 1px;">{{ $risk->level_risiko }}</span>
                                    </div>
                                </div>
                                <div class="col-md-4 text-right">
                                    <i class="fas fa-calculator fa-4x opacity-10" style="color: var(--green-dark);"></i>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pemilik_risiko" class="font-weight-bold text-dark">Pemilik Risiko</label>
                                    <input type="text" name="pemilik_risiko" id="pemilik_risiko" value="{{ old('pemilik_risiko', $risk->pemilik_risiko) }}" class="form-control" placeholder="Jabatan/Unit">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_identifikasi" class="font-weight-bold text-dark">Tanggal Identifikasi</label>
                                    <input type="date" name="tanggal_identifikasi" id="tanggal_identifikasi" value="{{ old('tanggal_identifikasi', $risk->tanggal_identifikasi ? \Carbon\Carbon::parse($risk->tanggal_identifikasi)->format('Y-m-d') : '') }}" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                            <a href="{{ route('risks.show', $risk) }}" class="btn btn-light px-4 shadow-sm">
                                <i class="fas fa-times mr-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success px-5 font-weight-bold shadow-sm">
                                <i class="fas fa-save mr-1"></i> Simpan Perubahan
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
