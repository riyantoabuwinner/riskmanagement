<x-app-layout>
    @section('page-title', 'Update Sistem')
    @section('breadcrumb')
        <li class="breadcrumb-item active">Update Sistem</li>
    @endsection

    <div class="row">
        <div class="col-md-12">
            <!-- Header Section -->
            <div class="card mb-4 border-0 shadow-sm" style="background: linear-gradient(135deg, #1e293b 0%, #334155 100%);">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="text-white font-weight-bold mb-1">
                                <i class="fas fa-sync-alt mr-2"></i> Update & Pemeliharaan Sistem
                            </h3>
                            <p class="text-light opacity-75 mb-0">Kelola pembaruan kode aplikasi langsung dari repositori GitHub.</p>
                        </div>
                            <div class="d-flex">
                                <form action="{{ route('system-update.check') }}" method="POST" class="mr-2" id="checkForm" onsubmit="return startCheck()">
                                    @csrf
                                    <button type="submit" class="btn btn-light shadow-sm px-4" id="btnCheck">
                                        <i class="fas fa-search mr-1"></i> Cek Versi Baru
                                    </button>
                                </form>
                                
                                @if($hasUpdates)
                                    @if($isDirty)
                                        <button class="btn btn-warning shadow-sm px-4" disabled title="Commit atau Stash perubahan lokal terlebih dahulu">
                                            <i class="fas fa-exclamation-triangle mr-1"></i> Perlu Clean Up
                                        </button>
                                    @else
                                        <form action="{{ route('system-update.update') }}" method="POST" id="updateForm" onsubmit="return startUpdate()">
                                            @csrf
                                            <button type="submit" class="btn btn-success shadow-sm px-4 btn-lg font-weight-bold" id="btnUpdateNow">
                                                <i class="fas fa-cloud-upload-alt mr-1"></i> Update ke Server Live
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <button class="btn btn-secondary shadow-sm px-4" disabled title="Sistem sudah dalam versi terbaru">
                                        <i class="fas fa-check-circle mr-1"></i> Sistem Terupdate
                                    </button>
                                @endif
                            </div>
                    </div>
                </div>
            </div>

            <script>
                function startUpdate() {
                    if(confirm('Apakah Anda yakin ingin melakukan update ke server live sekarang?')) {
                        const btn = document.getElementById('btnUpdateNow');
                        btn.disabled = true;
                        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Sedang Mengupdate...';
                        return true;
                    }
                    return false;
                }
                function startCheck() {
                    const btn = document.getElementById('btnCheck');
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fas fa-sync fa-spin mr-1"></i> Mengecek...';
                    return true;
                }
            </script>

            <div class="row">
                <!-- Left Column: Status & Log -->
                <div class="col-lg-7">
                    <!-- Status Card -->
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3">
                            <h6 class="text-uppercase font-weight-bold text-muted mb-0" style="font-size: 0.75rem; letter-spacing: 1px;">
                                <i class="fas fa-server mr-1"></i> Lingkungan & Branch
                            </h6>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    @if($isDirty)
                                        <div class="bg-danger-light p-3 rounded-circle text-danger">
                                            <i class="fas fa-tools fa-2x"></i>
                                        </div>
                                    @elseif($hasUpdates)
                                        <div class="bg-warning-light p-3 rounded-circle text-warning">
                                            <i class="fas fa-exclamation-circle fa-2x"></i>
                                        </div>
                                    @else
                                        <div class="bg-success-light p-3 rounded-circle text-success">
                                            <i class="fas fa-check-circle fa-2x"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Current Branch</small>
                                            <span class="badge badge-info px-2 py-1">{{ $status['branch'] }}</span>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Last Commit Hash</small>
                                            <code class="text-dark font-weight-bold">{{ $status['hash'] }}</code>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted d-block">Remote URL</small>
                                            <code class="text-xs {{ $isSsh ? 'text-warning' : 'text-success' }}" title="{{ $remoteUrl }}">{{ Str::limit($remoteUrl, 25) }}</code>
                                            @if($isSsh)
                                                <i class="fas fa-exclamation-triangle text-warning ml-1" title="Menggunakan SSH. Pastikan key tersedia untuk user web server."></i>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @if(isset($checkError) && $checkError)
                                        <div class="mt-3 p-2 bg-danger-pale rounded border border-danger-light">
                                            <p class="text-danger mb-0 font-weight-bold" style="font-size: 0.85rem;">
                                                <i class="fas fa-plug-circle-xmark mr-1"></i> Gagal Koneksi ke GitHub
                                                <small class="d-block font-weight-normal mt-1">
                                                    {{ $checkError }}
                                                </small>
                                            </p>
                                            @if($isSsh)
                                                <div class="mt-2 text-xs text-muted">
                                                    <strong>Tips:</strong> Masalah <code>Permission Denied (publickey)</code> biasanya karena web server tidak punya akses ke SSH key. 
                                                    Disarankan beralih ke HTTPS: <code>git remote set-url origin {{ str_replace(['git@github.com:', '.git'], ['https://github.com/', '.git'], $remoteUrl) }}</code>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    @if($isDirty)
                                        <div class="mt-3 p-2 bg-danger-pale rounded border border-danger-light">
                                            <p class="text-danger mb-0 font-weight-bold" style="font-size: 0.85rem;">
                                                <i class="fas fa-exclamation-triangle mr-1"></i> Terdeteksi perubahan lokal yang belum di-commit.
                                                <small class="d-block font-weight-normal mt-1">Sistem tidak dapat melakukan update otomatis jika ada file yang dimodifikasi secara manual. Silakan commit atau buang perubahan tersebut melalui terminal.</small>
                                            </p>
                                        </div>
                                    @elseif($hasUpdates)
                                        <div class="mt-3 p-2 bg-warning-pale rounded border border-warning-light">
                                            <p class="text-warning mb-0 font-weight-bold" style="font-size: 0.85rem;">
                                                <i class="fas fa-info-circle mr-1"></i> Tersedia pembaharuan di repositori GitHub (Remote: {{ substr($remoteHash, 0, 7) }}). Silakan klik tombol "Perbarui Sekarang".
                                            </p>
                                        </div>
                                    @else
                                        <div class="mt-3 p-2 bg-success-pale rounded border border-success-light">
                                            <p class="text-success mb-0 font-weight-bold" style="font-size: 0.85rem;">
                                                <i class="fas fa-check-double mr-1"></i> Sistem sudah sinkron dengan repositori (Up to Date).
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Change History -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                            <h6 class="text-uppercase font-weight-bold text-muted mb-0" style="font-size: 0.75rem; letter-spacing: 1px;">
                                <i class="fas fa-history mr-1"></i> Riwayat Perubahan (Git Log)
                            </h6>
                        </div>
                        <div class="card-body p-0">
                            <div class="bg-dark p-3 m-3 rounded shadow-inner" style="background: #0f172a !important;">
                                <pre class="text-success mb-0 font-mono" style="font-size: 0.75rem; line-height: 1.6; white-space: pre-wrap;">{{ $log }}</pre>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Console Output -->
                <div class="col-lg-5">
                    <div class="card h-100 border-0 shadow-sm" style="min-height: 400px;">
                        <div class="card-header bg-white border-0 py-3">
                            <h6 class="text-uppercase font-weight-bold text-muted mb-0" style="font-size: 0.75rem; letter-spacing: 1px;">
                                <i class="fas fa-terminal mr-1"></i> Konsol Output Eksekusi
                            </h6>
                        </div>
                        <div class="card-body d-flex flex-column pt-0">
                            <div class="flex-grow-1 bg-dark rounded p-3 shadow-inner overflow-auto" style="background: #111827 !important; border: 1px solid #374151;">
                                <div class="text-success font-mono" style="font-size: 0.75rem; line-height: 1.5;">
                                    @if(session('update_output'))
                                        <pre class="text-light mb-0" style="white-space: pre-wrap;">{{ session('update_output') }}</pre>
                                        <div class="mt-2 text-success font-weight-bold">--- PROSES SELESAI ---</div>
                                    @else
                                        <div class="text-muted italic">Menunggu eksekusi...</div>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-3 p-3 bg-light rounded text-xs text-muted">
                                <i class="fas fa-info-circle mr-1"></i> Output ini menampilkan log teknis dari proses <code>git pull</code> dan pembersihan cache. 
                                <span class="text-danger font-weight-bold">Catatan:</span> Database migration tidak dijalankan otomatis dan harus dilakukan manual jika diperlukan.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <style>
        .font-mono { font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace !important; }
        .bg-warning-light { background: rgba(245, 158, 11, 0.1); }
        .bg-success-light { background: rgba(16, 185, 129, 0.1); }
        .bg-danger-light { background: rgba(239, 68, 68, 0.1); }
        .bg-warning-pale { background: #fffbeb; }
        .bg-success-pale { background: #f0fdf4; }
        .bg-danger-pale { background: #fef2f2; }
        .border-warning-light { border-color: #fde68a !important; }
        .border-success-light { border-color: #bbf7d0 !important; }
        .border-danger-light { border-color: #fecaca !important; }
        .shadow-inner { box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.2); }
        .opacity-75 { opacity: 0.75; }
        .text-xs { font-size: 0.75rem; }
    </style>
    @endpush
</x-app-layout>
