<x-app-layout>
    @section('title', 'Evaluasi & Monitoring')
    @section('page-title', 'Input Evaluasi & Monitoring Risiko')
    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('risk-evaluation.index') }}">Evaluasi</a></li>
        <li class="breadcrumb-item active">Input Monitoring</li>
    @endsection

    <div class="row justify-content-center">
        <div class="col-lg-10">
            @if($risk)
                <!-- Risk Context Card -->
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px; background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="badge badge-{{ $risk->level_color }} mb-2 px-3 py-2 text-uppercase">{{ $risk->level_risiko }}</span>
                                <h4 class="font-weight-bold text-dark mb-1">{{ $risk->nama_risiko }}</h4>
                                <p class="text-muted small mb-0"><i class="fas fa-building mr-1"></i> {{ $risk->unit->nama_unit }} | <i class="fas fa-tag mr-1"></i> {{ $risk->kategori->nama_kategori }}</p>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-muted font-weight-bold mb-1">INHERENT SCORE</div>
                                <div class="h3 font-weight-bold text-{{ $risk->level_color }} mb-0">{{ $risk->skor_risiko }}</div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-md-6 border-right">
                                <h6 class="font-weight-bold text-muted text-xs text-uppercase mb-2">Penyebab (Causa)</h6>
                                <p class="small text-dark">{{ $risk->penyebab ?? 'Tidak ada data.' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="font-weight-bold text-muted text-xs text-uppercase mb-2">Dampak (Consequence)</h6>
                                <p class="small text-dark">{{ $risk->dampak ?? 'Tidak ada data.' }}</p>
                            </div>
                        </div>

                        @php $latest = $risk->monitorings->first(); @endphp
                        @if($latest)
                            <div class="alert alert-light border-0 shadow-sm mt-3 mb-0" style="background: #ffffff; border-radius: 10px;">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 bg-info rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; opacity: 0.8;">
                                        <i class="fas fa-info-circle text-white"></i>
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-dark small">Monitoring Terakhir ({{ \Carbon\Carbon::parse($latest->tanggal_update)->format('d M Y') }})</div>
                                        <div class="text-xs text-muted">Progress: {{ $latest->progress }}% | Residual: {{ $latest->residual_score ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Monitoring Form -->
                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-header bg-white py-3 border-0">
                        <h5 class="card-title font-weight-bold mb-0 text-primary">
                            <i class="fas fa-chart-line mr-2"></i> Form Update Efektivitas Mitigasi
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('monitorings.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="risk_id" value="{{ $risk->id }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold text-dark small">Tanggal Evaluasi</label>
                                        <input type="date" name="tanggal_update" class="form-control bg-light border-0 @error('tanggal_update') is-invalid @enderror" value="{{ old('tanggal_update', date('Y-m-d')) }}" required>
                                        @error('tanggal_update') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold text-dark small">Progress Mitigasi (%)</label>
                                        <div class="input-group">
                                            <input type="number" name="progress" min="0" max="100" class="form-control bg-light border-0 @error('progress') is-invalid @enderror" value="{{ old('progress', $latest->progress ?? 0) }}" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text bg-light border-0">%</span>
                                            </div>
                                            @error('progress') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold text-dark small">Catatan Perkembangan & Efektivitas Kontrol</label>
                                        <textarea name="keterangan" class="form-control bg-light border-0 @error('keterangan') is-invalid @enderror" rows="4" placeholder="Jelaskan perkembangan mitigasi dan kendala yang dihadapi..." required>{{ old('keterangan') }}</textarea>
                                        @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3">
                                    <div class="card border-0 bg-light p-3" style="border-radius: 10px;">
                                        <h6 class="font-weight-bold text-primary mb-3 small text-uppercase">Penilaian Risiko Residual (Terkini)</h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="text-muted text-xs font-weight-bold">Probabilitas Terkini</label>
                                                    <select name="residual_probabilitas" class="form-control border-0 shadow-sm @error('residual_probabilitas') is-invalid @enderror">
                                                        <option value="">-- Tetap --</option>
                                                        @for($i=1; $i<=5; $i++)
                                                            <option value="{{ $i }}" {{ old('residual_probabilitas', $latest->residual_probabilitas ?? '') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                    @error('residual_probabilitas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="text-muted text-xs font-weight-bold">Dampak Terkini</label>
                                                    <select name="residual_impact" class="form-control border-0 shadow-sm @error('residual_impact') is-invalid @enderror">
                                                        <option value="">-- Tetap --</option>
                                                        @for($i=1; $i<=5; $i++)
                                                            <option value="{{ $i }}" {{ old('residual_impact', $latest->residual_impact ?? '') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                    @error('residual_impact') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-xs text-muted mb-0"><i class="fas fa-info-circle mr-1"></i> Skor residual akan dihitung secara otomatis berdasarkan input Anda.</p>
                                    </div>
                                </div>

                                <div class="col-md-12 mt-4 text-right">
                                    <hr>
                                    <a href="{{ route('risk-evaluation.index') }}" class="btn btn-link text-muted mr-3">Batal</a>
                                    <button type="submit" class="btn btn-primary px-5 font-weight-bold shadow-sm" style="border-radius: 8px;">
                                        <i class="fas fa-save mr-2"></i> Simpan Evaluasi
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="card shadow-sm border-0 text-center p-5" style="border-radius: 15px;">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <h5 class="font-weight-bold">Data Risiko Tidak Ditemukan</h5>
                    <p class="text-muted">Silakan pilih risiko dari halaman Analisis & Evaluasi.</p>
                    <a href="{{ route('risk-evaluation.index') }}" class="btn btn-primary mt-3">Kembali ke Evaluasi</a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
