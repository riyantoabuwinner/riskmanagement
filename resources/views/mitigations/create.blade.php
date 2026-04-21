<x-app-layout>
    @section('title', 'Tambah Mitigasi')
    @section('page-title', 'Tambah Rencana Perlakuan Risiko')
    @section('breadcrumb')
        <li class="breadcrumb-item"><a href="{{ route('risks.index') }}">Risk Register</a></li>
        <li class="breadcrumb-item"><a href="{{ route('risks.show', $risk) }}">Detail Risiko</a></li>
        <li class="breadcrumb-item active">Tambah Mitigasi</li>
    @endsection

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card card-outline card-success shadow-sm">
                <div class="card-header bg-white py-3">
                    <h3 class="card-title font-weight-bold" style="color: var(--green-dark);">
                        <i class="fas fa-shield-alt mr-2"></i> Rencana Mitigasi Baru
                    </h3>
                </div>
                <div class="card-body p-4">
                    <!-- Ringkasan Risiko -->
                    <div class="alert alert-light border mb-4 shadow-sm" style="border-left: 4px solid var(--green-main) !important; background: #fdfdfd;">
                        <h6 class="text-xs text-uppercase font-weight-bold text-muted mb-1">Menanggapi Risiko:</h6>
                        <h5 class="font-weight-bold mb-0 text-dark">{{ $risk->nama_risiko }}</h5>
                        <div class="mt-2 small text-muted">
                            <span class="mr-3"><i class="fas fa-chart-line mr-1"></i> Skor: <strong>{{ $risk->skor_risiko }}</strong></span>
                            <span><i class="fas fa-exclamation-circle mr-1"></i> Level: <strong class="text-{{ $risk->level_color }}">{{ $risk->level_risiko }}</strong></span>
                        </div>
                    </div>

                    <form action="{{ route('mitigations.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="risk_id" value="{{ $risk->id }}">

                        <div class="form-group mb-4">
                            <label for="strategi" class="font-weight-bold"><i class="fas fa-chess mr-1 text-info"></i> Strategi Penanganan <span class="text-danger">*</span></label>
                            <select name="strategi" id="strategi" class="form-control select2 @error('strategi') is-invalid @enderror" required>
                                <option value="">-- Pilih Strategi --</option>
                                <option value="Hindari" {{ old('strategi') == 'Hindari' ? 'selected' : '' }}>Menghindari (Avoid) - Menghentikan aktivitas penyebab risiko</option>
                                <option value="Mitigasi" {{ old('strategi') == 'Mitigasi' ? 'selected' : '' }}>Mengurangi/Mitigasi (Reduce) - Menurunkan probabilitas/dampak</option>
                                <option value="Transfer" {{ old('strategi') == 'Transfer' ? 'selected' : '' }}>Transfer/Membagi (Share) - Melibatkan pihak ketiga/asuransi</option>
                                <option value="Terima" {{ old('strategi') == 'Terima' ? 'selected' : '' }}>Menerima (Accept) - Menanggung risiko dengan kontrol yang ada</option>
                            </select>
                            @error('strategi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="rencana_aksi" class="font-weight-bold"><i class="fas fa-tasks mr-1 text-success"></i> Rencana Aksi Mitigasi <span class="text-danger">*</span></label>
                            <textarea name="rencana_aksi" id="rencana_aksi" class="form-control @error('rencana_aksi') is-invalid @enderror" rows="4" 
                                      placeholder="Penerapan langkah-langkah strategis untuk menekan nilai tingkat kemungkinan atau dampak risiko..." required>{{ old('rencana_aksi') }}</textarea>
                            @error('rencana_aksi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-group mb-4">
                                    <label for="penanggung_jawab" class="font-weight-bold"><i class="fas fa-user-tie mr-1 text-primary"></i> Penanggung Jawab (PIC) <span class="text-danger">*</span></label>
                                    <input type="text" name="penanggung_jawab" id="penanggung_jawab" value="{{ old('penanggung_jawab') }}" 
                                           class="form-control @error('penanggung_jawab') is-invalid @enderror" placeholder="Contoh: Manajer Unit Kerja / Ka. Divisi / Penanggung Jawab Terkait" required>
                                    @error('penanggung_jawab')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_mulai" class="font-weight-bold"><i class="far fa-calendar-plus mr-1 text-muted"></i> Tanggal Mulai <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai', date('Y-m-d')) }}" 
                                           class="form-control @error('tanggal_mulai') is-invalid @enderror" required>
                                    @error('tanggal_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="target_waktu" class="font-weight-bold"><i class="far fa-calendar-check mr-1 text-muted"></i> Target Selesai <span class="text-danger">*</span></label>
                                    <input type="date" name="target_waktu" id="target_waktu" value="{{ old('target_waktu', date('Y-m-d', strtotime('+1 month'))) }}" 
                                           class="form-control @error('target_waktu') is-invalid @enderror" required>
                                    @error('target_waktu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="anggaran" class="font-weight-bold"><i class="fas fa-coins mr-1 text-warning"></i> Estimasi Anggaran / Biaya Mitigasi (Opsional)</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-light border-right-0">Rp</span>
                                        </div>
                                        <input type="number" name="anggaran" id="anggaran" value="{{ old('anggaran', 0) }}" 
                                               class="form-control border-left-0 @error('anggaran') is-invalid @enderror" placeholder="0">
                                    </div>
                                    <small class="text-muted">Kosongkan atau biarkan 0 jika tidak memerlukan anggaran tambahan.</small>
                                    @error('anggaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                            <a href="{{ route('risks.show', $risk) }}" class="btn btn-light px-4">
                                <i class="fas fa-times mr-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success px-5 font-weight-bold shadow-sm">
                                <i class="fas fa-save mr-1"></i> Simpan Rencana
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
