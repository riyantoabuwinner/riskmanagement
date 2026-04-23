<x-app-layout>
@section('title', 'Panduan Pengguna')
@section('page-title', 'Panduan Penggunaan Sistem')

@section('breadcrumb')
    <li class="breadcrumb-item active">Panduan</li>
@endsection
<div class="row">
    <div class="col-md-3">
        <div class="card card-outline card-success shadow-sm">
            <div class="card-header">
                <h3 class="card-title font-weight-bold"><i class="fas fa-list-ul mr-2"></i>Daftar Peran</h3>
            </div>
            <div class="card-body p-0">
                <ul class="nav nav-pills flex-column" id="guide-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="general-tab" data-toggle="pill" href="#general" role="tab">
                            <i class="fas fa-info-circle mr-2"></i> Umum & Profil
                        </a>
                    </li>
                    <li class="nav-item border-top">
                        <a class="nav-link" id="owner-tab" data-toggle="pill" href="#owner" role="tab">
                            <i class="fas fa-user-edit mr-2"></i> Risk Owner
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="officer-tab" data-toggle="pill" href="#officer" role="tab">
                            <i class="fas fa-user-shield mr-2"></i> Risk Officer
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="manager-tab" data-toggle="pill" href="#manager" role="tab">
                            <i class="fas fa-user-tie mr-2"></i> Risk Manager
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="admin-tab" data-toggle="pill" href="#admin" role="tab">
                            <i class="fas fa-user-cog mr-2"></i> Admin
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="superadmin-tab" data-toggle="pill" href="#superadmin" role="tab">
                            <i class="fas fa-user-secret mr-2"></i> Super Admin
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card mt-3 shadow-sm">
            <div class="card-body text-center p-3">
                <p class="text-muted small mb-3">Butuh panduan dalam format PDF?</p>
                <a href="{{ route('panduan.download') }}" class="btn btn-success btn-block btn-sm shadow-sm">
                    <i class="fas fa-file-download mr-2"></i> Unduh PDF
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <div class="tab-content card shadow-sm" id="guide-tabContent">
            {{-- Umum & Profil --}}
            <div class="tab-pane fade show active p-4" id="general" role="tabpanel">
                <div class="text-center mb-4">
                    <i class="fas fa-info-circle fa-3x text-success mb-2"></i>
                    <h4 class="font-weight-bold">Panduan Umum & Profil</h4>
                    <p class="text-muted">Langkah awal penggunaan aplikasi RiskManagement.</p>
                </div>
                <hr>
                <h5 class="font-weight-bold text-success mt-4">1. Login ke Sistem</h5>
                <p>Gunakan email dan password yang telah didaftarkan untuk masuk ke dashboard utama.</p>
                
                <h5 class="font-weight-bold text-success mt-4">2. Manajemen Profil</h5>
                <ul>
                    <li>Klik menu <strong>Profil Saya</strong> di sidebar atau dropdown navbar atas.</li>
                    <li>Anda dapat memperbarui informasi pribadi seperti Nama dan Email.</li>
                    <li>Gunakan fitur ubah password untuk menjaga keamanan akun secara berkala.</li>
                </ul>

                <h5 class="font-weight-bold text-success mt-4">3. Notifikasi</h5>
                <p>Klik ikon lonceng di bagian atas untuk melihat pemberitahuan terbaru terkait status risiko, tenggat waktu mitigasi, atau pengajuan role.</p>
            </div>

            {{-- Risk Owner --}}
            <div class="tab-pane fade p-4" id="owner" role="tabpanel">
                <div class="text-center mb-4">
                    <i class="fas fa-user-edit fa-3x text-success mb-2"></i>
                    <h4 class="font-weight-bold">Panduan Risk Owner</h4>
                    <p class="text-muted">Tugas utama: Identifikasi risiko unit kerja & Update mitigasi.</p>
                </div>
                <hr>
                <div class="timeline timeline-inverse">
                    <div>
                        <i class="fas fa-plus bg-success"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header font-weight-bold">Langkah 1: Identifikasi Risiko</h3>
                            <div class="timeline-body">
                                Buka menu <strong>Identifikasi Risiko</strong>. Klik tombol <strong>Tambah Risiko</strong> untuk memasukkan data risiko baru pada unit kerja Anda. Isi detail risiko, penyebab, dampak, dan kriteria penilaian awal.
                            </div>
                        </div>
                    </div>
                    <div>
                        <i class="fas fa-paper-plane bg-primary"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header font-weight-bold">Langkah 2: Kirim untuk Review</h3>
                            <div class="timeline-body">
                                Setelah data tersimpan, klik tombol <strong>Kirim untuk Review</strong> agar data dapat dianalisis oleh Risk Officer. Status risiko akan berubah menjadi "Draft/Review".
                            </div>
                        </div>
                    </div>
                    <div>
                        <i class="fas fa-shield-virus bg-warning"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header font-weight-bold">Langkah 3: Rencana Mitigasi</h3>
                            <div class="timeline-body">
                                Setelah risiko disetujui, buka menu <strong>Mitigasi Risiko</strong>. Tambahkan langkah-langkah penanganan (mitigasi) untuk mengurangi dampak atau kemungkinan risiko terjadi.
                            </div>
                        </div>
                    </div>
                    <div>
                        <i class="fas fa-check-double bg-info"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header font-weight-bold">Langkah 4: Update Progress Mitigasi</h3>
                            <div class="timeline-body">
                                Lakukan update berkala pada menu mitigasi untuk melaporkan perkembangan penanganan risiko hingga status menjadi "Selesai".
                            </div>
                        </div>
                    </div>
                    <div>
                        <i class="fas fa-flag-checkered bg-secondary"></i>
                    </div>
                </div>
            </div>

            {{-- Risk Officer --}}
            <div class="tab-pane fade p-4" id="officer" role="tabpanel">
                <div class="text-center mb-4">
                    <i class="fas fa-user-shield fa-3x text-primary mb-2"></i>
                    <h4 class="font-weight-bold">Panduan Risk Officer</h4>
                    <p class="text-muted">Tugas utama: Analisis, Evaluasi, dan Monitoring Risiko.</p>
                </div>
                <hr>
                <h5 class="font-weight-bold text-primary mt-4">1. Review Identifikasi Risiko</h5>
                <p>Periksa risiko yang dikirim oleh Risk Owner pada menu <strong>Identifikasi Risiko</strong>. Anda dapat memberikan masukan atau meminta perbaikan sebelum dilanjutkan ke tahap analisis.</p>

                <h5 class="font-weight-bold text-primary mt-4">2. Analisis & Evaluasi Risiko</h5>
                <p>Buka menu <strong>Analisis Risiko</strong>. Lakukan penilaian terhadap tingkat kemungkinan dan dampak risiko. Tentukan apakah risiko tersebut perlu dimitigasi atau dapat diterima.</p>

                <h5 class="font-weight-bold text-primary mt-4">3. Monitoring Efektivitas</h5>
                <p>Gunakan menu <strong>Monitoring Risiko</strong> untuk memantau apakah langkah mitigasi yang dijalankan oleh Risk Owner sudah efektif dalam menurunkan level risiko.</p>
            </div>

            {{-- Risk Manager --}}
            <div class="tab-pane fade p-4" id="manager" role="tabpanel">
                <div class="text-center mb-4">
                    <i class="fas fa-user-tie fa-3x text-warning mb-2"></i>
                    <h4 class="font-weight-bold">Panduan Risk Manager</h4>
                    <p class="text-muted">Tugas utama: Persetujuan Akhir dan Pengawasan Strategis.</p>
                </div>
                <hr>
                <h5 class="font-weight-bold text-warning mt-4">1. Persetujuan Risiko & Evaluasi</h5>
                <p>Melakukan validasi akhir terhadap hasil analisis yang dilakukan oleh Risk Officer. Risiko baru dapat dianggap sah setelah mendapatkan <strong>Approval</strong> dari Risk Manager.</p>

                <h5 class="font-weight-bold text-warning mt-4">2. Pemantauan Dashboard Eksekutif</h5>
                <p>Gunakan <strong>BLU Dashboard</strong> untuk melihat sebaran risiko secara keseluruhan di universitas, tren risiko, dan status mitigasi secara real-time.</p>

                <h5 class="font-weight-bold text-warning mt-4">3. Laporan Risiko</h5>
                <p>Akses menu <strong>Laporan Risiko</strong> untuk mengekspor data dalam format PDF atau Excel sebagai bahan laporan pimpinan.</p>
            </div>

            {{-- Admin --}}
            <div class="tab-pane fade p-4" id="admin" role="tabpanel">
                <div class="text-center mb-4">
                    <i class="fas fa-user-cog fa-3x text-secondary mb-2"></i>
                    <h4 class="font-weight-bold">Panduan Admin</h4>
                    <p class="text-muted">Tugas utama: Pengelolaan Data Master.</p>
                </div>
                <hr>
                <h5 class="font-weight-bold text-secondary mt-4">1. Pengelolaan Unit Kerja</h5>
                <p>Menambah, mengubah, atau menghapus data <strong>Unit Kerja</strong> dan <strong>Jenis Unit</strong> untuk memastikan struktur organisasi selalu update.</p>

                <h5 class="font-weight-bold text-secondary mt-4">2. Kategori & Indikator</h5>
                <p>Mengelola <strong>Kategori Risiko</strong> dan <strong>Indikator Kinerja</strong> yang menjadi acuan penilaian risiko bagi pengguna lain.</p>

                <h5 class="font-weight-bold text-secondary mt-4">3. Manajemen User (Terbatas)</h5>
                <p>Membantu dalam verifikasi data user dan koordinasi pengajuan role ke Super Admin.</p>
            </div>

            {{-- Super Admin --}}
            <div class="tab-pane fade p-4" id="superadmin" role="tabpanel">
                <div class="text-center mb-4">
                    <i class="fas fa-user-secret fa-3x text-dark mb-2"></i>
                    <h4 class="font-weight-bold">Panduan Super Admin</h4>
                    <p class="text-muted">Tugas utama: Keamanan, User, dan Maintenance Sistem.</p>
                </div>
                <hr>
                <h5 class="font-weight-bold text-dark mt-4">1. Manajemen User & Role</h5>
                <p>Akses penuh pada menu <strong>Manajemen User</strong>. Memberikan role (Super Admin, Admin, dll) kepada pengguna baru atau mengubah hak akses yang ada.</p>

                <h5 class="font-weight-bold text-dark mt-4">2. Pengajuan Role</h5>
                <p>Memproses permintaan role yang dikirimkan pengguna melalui menu <strong>Pengajuan Role</strong>. Anda dapat menyetujui atau menolak pengajuan tersebut.</p>

                <h5 class="font-weight-bold text-dark mt-4">3. Audit Log & Backup</h5>
                <ul>
                    <li><strong>Audit Log:</strong> Memantau setiap aktivitas yang dilakukan user di dalam sistem untuk keperluan keamanan.</li>
                    <li><strong>Backup Data:</strong> Melakukan pencadangan database secara berkala melalui menu Backup Data untuk mencegah kehilangan data.</li>
                </ul>
            </div>
        </div>
    </div>
</div>


@push('styles')
<style>
    .nav-pills .nav-link {
        border-radius: 0;
        padding: 12px 20px;
        color: #4b5563;
        font-weight: 500;
        transition: all 0.2s;
    }
    .nav-pills .nav-link:hover {
        background: #f3f4f6;
        color: var(--green-main);
    }
    .nav-pills .nav-link.active {
        background: linear-gradient(135deg, var(--green-main), var(--accent)) !important;
        color: #fff !important;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .timeline-item {
        box-shadow: 0 2px 8px rgba(0,0,0,0.05) !important;
        border: none !important;
        background: #fff !important;
    }
    .timeline-header {
        font-size: 1rem !important;
        color: var(--green-dark) !important;
    }
</style>
@endpush
</x-app-layout>
