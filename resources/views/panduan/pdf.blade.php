<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Panduan Penggunaan Risk Management</title>
    <style>
        @page {
            margin: 2.5cm 2cm;
        }
        body {
            font-family: "Helvetica", "Arial", sans-serif;
            color: #333;
            line-height: 1.6;
            font-size: 11pt;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #047857;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #047857;
            font-size: 24pt;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }
        .header p {
            margin: 0;
            font-size: 14pt;
            color: #555;
        }
        h2 {
            color: #064e3b;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            margin-top: 30px;
            font-size: 14pt;
        }
        h3 {
            color: #059669;
            font-size: 12pt;
            margin-top: 20px;
        }
        p {
            margin-bottom: 10px;
            text-align: justify;
        }
        ul, ol {
            margin-bottom: 15px;
            padding-left: 20px;
        }
        li {
            margin-bottom: 5px;
        }
        .screenshot {
            max-width: 100%;
            height: auto;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            margin-top: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .img-container {
            text-align: center;
        }
        .img-caption {
            font-size: 9pt;
            color: #6b7280;
            font-style: italic;
            margin-bottom: 20px;
        }
        /* Page break classes */
        .page-break {
            page-break-after: always;
        }
        .footer {
            position: fixed;
            bottom: -1.5cm;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9pt;
            color: #777;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }
        .footer .page-number:after { content: counter(page); }
    </style>
</head>
<body>

    <div class="footer">
        RiskManagement — UIN Siber Syekh Nurjati Cirebon | Halaman <span class="page-number"></span>
    </div>

    <!-- Halaman Utama / Sampul -->
    <div class="header" style="margin-top: 5cm; border-bottom: none;">
        <h1>BUKU PANDUAN PENGGUNAAN</h1>
        <p>Sistem Manajemen Risiko</p>
        <p style="font-size: 12pt; margin-top: 15px;">UIN Siber Syekh Nurjati Cirebon<br>Berbasis ISO 31000:2018</p>
    </div>

    <div class="img-container" style="margin-top: 40px;">
        @if(file_exists(public_path('images/guide_landing.png')))
            <img src="{{ public_path('images/guide_landing.png') }}" class="screenshot" alt="Landing Page">
        @endif
    </div>

    <div class="page-break"></div>

    <h2>1. Pendahuluan</h2>
    <p>Selamat datang di Sistem Manajemen Risiko UIN Siber Syekh Nurjati Cirebon. Sistem ini dirancang untuk memfasilitasi pelaksanaan manajemen risiko di lingkungan kampus sesuai dengan kerangka kerja (framework) dan standar internasional ISO 31000:2018.</p>
    <p>Aplikasi ini memungkinkan identifikasi, analisis, evaluasi, serta pemantauan risiko (monitoring) secara terintegrasi dan real-time menggunakan antarmuka yang modern, termasuk visualisasi Heatmap 5x5.</p>

    <h2>2. Hak Akses dan Peran (Role)</h2>
    <p>Sistem ini menggunakan Role-Based Access Control (RBAC) di mana fitur yang tersedia bergantung pada peran akun Anda:</p>
    <ul>
        <li><strong>Super Admin:</strong> Mengelola seluruh akses sistem, user, data master, dan konfigurasi.</li>
        <li><strong>Risk Manager / Admin:</strong> Memimpin proses manajemen risiko, menyetujui evaluasi, mengatur struktur, dan menghasilkan laporan keseluruhan.</li>
        <li><strong>Risk Officer:</strong> Melakukan evaluasi mendalam, menyusun rencana mitigasi, dan mengawasi jalannya proses pengendalian risiko.</li>
        <li><strong>Risk Owner:</strong> Pihak di masing-unit kerja yang mengidentifikasi risiko awal dan mengelola status mitigasinya.</li>
    </ul>

    <h2>3. Pendaftaran Akun dan Pengajuan Hak Akses</h2>
    <h3>3.1. Cara Daftar Akun Baru</h3>
    <p>Bagi pengguna yang belum memiliki akun, silakan mendaftar terlebih dahulu:</p>
    <ol>
        <li>Di halaman utama aplikasi, klik tombol <strong>"Daftar"</strong>.</li>
        <li>Isi formulir pendaftaran dengan Nama Lengkap, Email institusi (contoh: <em>nama@uinsc.ac.id</em>), dan buat Password yang aman (minimal 8 karakter).</li>
        <li>Centang persetujuan Syarat & Ketentuan, lalu klik <strong>"Buat Akun Sekarang"</strong>.</li>
    </ol>

    <h3>3.2. Pengajuan Role (Hak Akses)</h3>
    <p>Setelah mendaftar atau saat login pertama kali bagi akun baru, Anda akan otomatis diarahkan ke halaman <strong>Pengajuan Akses Sistem</strong>:</p>
    <ol>
        <li>Pilih peran/role yang sesuai dengan tugas Anda (Risk Manager, Risk Officer, atau Risk Owner).</li>
        <li>Isi <strong>Jabatan / Posisi</strong> Anda secara detail (contoh: Kepala Biro Keuangan).</li>
        <li>Pilih <strong>Unit / Fakultas</strong> tempat Anda bertugas dari daftar yang tersedia.</li>
        <li>(Opsional) Sertakan unggahan file <strong>Surat Keputusan (SK)</strong> dalam format PDF/JPG.</li>
        <li>Klik tombol <strong>"Ajukan Persetujuan"</strong>. Akun Anda akan berstatus "Menunggu Review" hingga disetujui oleh Super Admin.</li>
    </ol>

    <h2>4. Manajemen Role (Khusus Super Admin)</h2>
    <p>Bagi pengguna berstatus Super Admin, Anda memiliki tugas untuk memvalidasi dan menerima pengajuan role dari dosen/staf baru:</p>
    <ol>
        <li>Masuk ke menu <strong>Pengajuan Role</strong> pada navigasi utama.</li>
        <li>Anda akan melihat daftar antrean pengajuan akun baru yang berstatus <em>Pending</em>.</li>
        <li>Periksa kesesuaian data (jabatan, unit, dan dokumen SK jika ada).</li>
        <li>Klik tombol <strong>"Setujui"</strong> untuk meresmikan akun tersebut sesuai role yang diminta.</li>
        <li>Atau, klik tombol <strong>"Tolak"</strong> dan wajib sertakan alasan penolakan agar pengguna bisa memperbaiki pengajuannya.</li>
    </ol>

    <div class="page-break"></div>

    <h2>5. Login dan Dashboard Aplikasi</h2>
    <h3>5.1. Cara Login</h3>
    <ol>
        <li>Di halaman utama, klik tombol <strong>"Masuk"</strong>.</li>
        <li>Masukkan Alamat Email dan Password yang telah terdaftar.</li>
        <li>Klik tombol "Masuk" untuk diarahkan otomatis ke Dashboard.</li>
    </ol>

    <h3>5.2. Memahami Dashboard Utama</h3>
    <p>Setelah login dan diberikan role akses, Anda akan melihat tampilan dashboard. Dashboard menampilkan statistik risiko, heatmap (peta panas) risiko organisasi, dan ringkasan distribusi risiko aktif.</p>
    
    <div class="img-container">
        @if(file_exists(public_path('images/guide_dashboard.png')))
            <img src="{{ public_path('images/guide_dashboard.png') }}" class="screenshot" alt="Dashboard Aplikasi">
            <div class="img-caption">Gambar 1: Tampilan Utama Dashboard Aplikasi beserta Risk Heatmap 5x5.</div>
        @endif
    </div>

    <div class="page-break"></div>

    <h2>6. Modul Manajemen Risiko (Alur Kerja)</h2>
    <p>Aplikasi ini memiliki beberapa tahapan dalam proses Enterprise Risk Management (ERM) sesuai ISO 31000:2018. Berikut ini adalah langkah-langkah praktis penerapannya di dalam sistem.</p>

    <h3>6.1. Identifikasi Risiko (Risk Register)</h3>
    <p>Pemilik Risiko (Risk Owner) mendaftarkan kemungkinan risiko yang ada di unit kerjanya.</p>
    <ol>
        <li>Pilih menu <strong>Identifikasi Risiko</strong> pada panel navigasi di sebelah kiri.</li>
        <li>Klik tombol <strong>"Tambah Risiko"</strong> berwarna hijau untuk mendaftarkan risiko baru.</li>
        <li>Isi formulir dengan lengkap: Nama Misi Universitas yang terkait, Sasaran Strategis unit, Pernyataan Risiko secara rinci, dan Akar Penyebab risiko tersebut.</li>
        <li>Pilih Unit Kerja dan Kategori Risiko Anda.</li>
        <li>Simpan data (Klik Submit). Risiko tersebut akan muncul pada daftar register risiko.</li>
    </ol>

    <div class="img-container">
        @if(file_exists(public_path('images/guide_risk_register.png')))
            <img src="{{ public_path('images/guide_risk_register.png') }}" class="screenshot" alt="Identifikasi Risiko">
            <div class="img-caption">Gambar 2: Tampilan Halaman Identifikasi Risiko (Risk Register).</div>
        @endif
    </div>

    <h3>6.2. Analisis & Evaluasi Risiko (Risk Analysis)</h3>
    <p>Setelah risiko didaftarkan, Risk Officer melakukan asesmen / penilaian terhadap masing-masing risiko.</p>
    <ol>
        <li>Arahkan ke menu <strong>Analisis Risiko</strong>.</li>
        <li>Pilih risiko yang status pencatatannya telah disetujui atau masih dalam draft (sesuai tahap peninjauan).</li>
        <li>Tentukan nilai <em>Likelihood</em> (Skala Kemungkinan 1-5) dan <em>Impact</em> (Skala Dampak 1-5).</li>
        <li>Sistem secara otomatis akan menghitung dan memetakan Level Risiko Inherent Anda ke dalam Heatmap 5x5 (Rendah, Sedang, Tinggi, Ekstrem).</li>
    </ol>

    <div class="img-container">
        @if(file_exists(public_path('images/guide_analisis.png')))
            <img src="{{ public_path('images/guide_analisis.png') }}" class="screenshot" alt="Analisis Risiko">
            <div class="img-caption">Gambar 3: Halaman Analisis Risiko dan Evaluasi Matriks.</div>
        @endif
    </div>

    <div class="page-break"></div>

    <h3>6.3. Mitigasi Risiko</h3>
    <p>Langkah-langkah strategis untuk menekan nilai tingkat kemungkinan atau dampak dampak risiko yang dievaluasi.</p>
    <ol>
        <li>Masuk ke dalam menu <strong>Mitigasi Risiko</strong>.</li>
        <li>Pilih risiko yang sedang aktif, kemudian klik <strong>"Tambah Rencana Mitigasi"</strong>.</li>
        <li>Tetapkan Strategi Penanganan (misalnya: Menghindari, Mengurangi/Mitigasi, Menerima, atau Transfer/Membagi).</li>
        <li>Tentukan Penanggung Jawab dari langkah mitigasi tersebut.</li>
        <li>Atur Tanggal Mulai dan Tanggal Selesai (Target Timeline).</li>
        <li>Cantumkan estimasi Anggaran / Biaya Mitigasi apabila diperlukan, lalu simpan.</li>
    </ol>

    <div class="img-container">
        @if(file_exists(public_path('images/guide_mitigasi.png')))
            <img src="{{ public_path('images/guide_mitigasi.png') }}" class="screenshot" alt="Mitigasi Risiko">
            <div class="img-caption">Gambar 4: Manajamen Rencana Mitigasi Risiko.</div>
        @endif
    </div>

    <h3>6.4. Monitoring Risiko (Pemantauan Profil)</h3>
    <p>Pemantauan adalah tahap penjaminan agar mitigasi risiko berjalan efektif, serta mengecek tingkat Residual Risk (Risiko yang Tertinggal).</p>
    <ul>
        <li>Di menu <strong>Monitoring Risiko</strong>, Anda dapat melihat tingkat ketercapaian dari mitigasi (Presentase Progress secara berkala).</li>
        <li>Update progres implementasi mitigasi pada waktu tinjauan triwulanan atau bulanan.</li>
        <li>Data monitoring ini akan dirangkum dalam laporan profil risiko akhir tahun.</li>
    </ul>

    <h2>7. Modul Laporan Risiko (Reporting)</h2>
    <p>Sistem ini dirancang memudahkan pimpinan dan tim manajemen risiko dalam memantau data secara menyeluruh melalui modul <strong>Laporan Risiko</strong>.</p>
    <ol>
        <li>Akses menu <strong>Laporan Risiko</strong> melalui navigasi.</li>
        <li>Gunakan alat penyaring (Filter) untuk menentukan rentang tanggal laporan, status, serta filter spesifik per Unit/Fakultas yang ingin diperiksa.</li>
        <li>Klik tombol <strong>"Lihat Laporan"</strong> untuk menampilkan rincian data di layar.</li>
        <li>Pilih opsi Export PDF (mengunduh PDF siap cetak dengan logo resmi) atau Export Excel (untuk olah perhitungan data manual).</li>
    </ol>

    <h2>8. Early Warning System (Sistem Peringatan Dini / Notifikasi)</h2>
    <p>Aplikasi ini memiliki fitur cerdas berwujud notifikasi lonceng (Early Warning System) di bagian kanan atas layar Anda.</p>
    <ul>
        <li>Sistem akan mendeteksi dan secara otomatis memperingatkan Anda tentang <strong>batas waktu (deadline) rencana mitigasi</strong> yang dalam waktu dekat akan segera berakhir.</li>
        <li>Saat pengelola menyetujui, menolak, atau memberi ulasan pada data risiko Anda, informasi ini akan seketika muncul di dalam menu notifikasi tersebut.</li>
        <li>Sebagai Super Admin / Admin utama, Anda juga akan langsung diberi tahu setiap kali ada pengguna baru yang melakukan pengajuan hak akses (Role Request) agar dapat dieksekusi dengan cepat.</li>
    </ul>

    <h2>9. Kendala Teknis Ditemukan?</h2>
    <p>Aplikasi telah berupaya dirancang semudah mungkin. Namun jika menghadapi *error* fungsi sistem, jangan ragu melapor ke Administrator Sistem Utama melalui layanan Tiket IT yang dikelola universitas atau kontak bagian Pusat Data Universitas ISO.</p>

    <div style="margin-top: 50px; text-align: center; color: #777;">
        <p><em>— Selesai —</em><br>Terima kasih telah menggunakan sistem ini.</p>
    </div>

</body>
</html>
