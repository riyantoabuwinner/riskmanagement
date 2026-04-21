# Arsitektur Konseptual Aplikasi Risk Management

Dokumen ini menjelaskan struktur fungsional dan teknis dari aplikasi Manajemen Risiko yang telah dikembangkan untuk mendukung pengelolaan risiko di tingkat Universitas (Fakultas, Prodi, Biro).

## 🔷 Modul Utama

### 1. Risk Register (Daftar Risiko)
Modul untuk identifikasi dan pencatatan risiko di setiap Unit Kerja.
- **Kategori Risiko**: Akademik, Keuangan, SDM, IT, Reputasi (Dikelola melalui Master Data Kategori).
- **Entitas**: Mendukung input data per unit (Fakultas, Prodi, Biro, dll).
- **Fitur Terkait**: Status siklus hidup risiko (Draft, Submitted, Reviewed, Rejected, Approved).

### 2. Risk Assessment (Penilaian Risiko)
Proses kuantifikasi risiko berdasarkan metodologi standar ISO 31000.
- **Likelihood (Kemungkinan)**: Skala 1 - 5.
- **Impact (Dampak)**: Skala 1 - 5.
- **Output**:
    - **Skor Risiko**: Hasil perkalian Probabilitas × Dampak.
    - **Level Risiko**: Kategorisasi skor menjadi **Low**, **Medium**, **High**, dan **Extreme**.

### 3. Risk Matrix (Heatmap)
Visualisasi sebaran risiko untuk memudahkan prioritas penanganan.
- **Grid 5x5**: Matriks interaktif yang memetakan jumlah risiko berdasarkan kombinasi probabilitas dan dampak.
- **Aesthetics**: Menggunakan pewarnaan standar (Merah untuk Extreme, Jingga untuk High, Kuning untuk Medium, Hijau untuk Low).
- **Dashboard Pimpinan**: Tampilan grafis ringkas untuk memantau profil risiko universitas secara real-time.

### 4. Mitigation Plan (Rencana Mitigasi)
Modul untuk menyusun strategi penanganan risiko.
- **Rencana Aksi**: Deskripsi langkah-langkah mitigasi.
- **PIC + Timeline**: Penunjukan Penanggung Jawab dan target waktu penyelesaian (Tanggal Mulai & Target Selesai).
- **Anggaran**: Estimasi biaya yang dibutuhkan untuk langkah mitigasi.
- **Status Progres**: Pelacakan status pelaksanaan mitigasi.

### 5. Monitoring & Review
Siklus pelacakan dan evaluasi efektivitas mitigasi.
- **Tracking Berkala**: Input progres realisasi risiko secara periodik (0% - 100%).
- **Residual Risk Assessment**: Penilaian kembali tingkat risiko setelah mitigasi dijalankan (Apresiasi Risiko).
- **Review Workflow**: Alur persetujuan bertahap dari Reviewer (SPI/Manager) hingga Pimpinan Universitas.

### 6. Reporting & Dashboard
Pusat informasi dan pelaporan untuk mendukung pengambilan keputusan.
- **Dashboard Analytics**: Grafik sebaran risiko per unit dan per kategori.
- **Audit Trail**: Pencatatan riwayat setiap perubahan status dan aktivitas pada data risiko.
- **Integrasi IKU / Renstra**: Maping risiko terhadap Indikator Kinerja Utama (IKU PTN), Asta Protas, Perkin, dan SDGs untuk menjamin keselarasan dengan visi strategis Universitas.

---

## 🛠️ Arsitektur Teknis
- **Backend Framework**: Laravel 10 (PHP 8.x)
- **Frontend**: Blade Templating + Vanilla CSS + Bootstrap 4 (AdminLTE)
- **Database**: MySQL
- **Integrasi**: Select2 (Multi-select Indikator), Chart.js (Visualisasi), Carbon (Date Management).
