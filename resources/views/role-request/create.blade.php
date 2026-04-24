<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Role — RiskManagement</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --g1: #064e3b; --g2: #047857; --g3: #10b981; --g4: #34d399;
            --gold: #d97706; --gold-light: #fbbf24;
            --bg: #f0fdf4; --white: #ffffff;
            --text: #111827; --text-muted: #6b7280;
            --border: #d1d5db; --shadow: 0 20px 60px rgba(4,120,87,0.12);
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #064e3b 0%, #065f46 40%, #047857 100%);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 24px;
        }

        .page-wrapper {
            width: 100%; max-width: 900px;
        }

        /* ── Header ── */
        .page-header {
            text-align: center;
            margin-bottom: 28px;
        }
        .page-header .logo {
            display: inline-flex; align-items: center; gap: 12px;
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 50px;
            padding: 8px 20px 8px 8px;
            margin-bottom: 20px;
        }
        .logo-img-wrap {
            width: 36px; height: 36px; border-radius: 8px;
            background: #fff; display: flex; align-items: center; justify-content: center;
            padding: 2px;
        }
        .logo-img-wrap img { width: 32px; height: 32px; object-fit: contain; }
        .logo-name { color: #fff; font-weight: 700; font-size: 0.95rem; }
        .logo-name span { color: var(--g4); }

        .page-header h1 {
            font-size: 2rem; font-weight: 800; color: #fff;
            margin-bottom: 8px; line-height: 1.2;
        }
        .page-header p { color: rgba(255,255,255,0.7); font-size: 0.95rem; }

        /* ── Alert Rejected ── */
        .alert-rejected {
            background: rgba(239,68,68,0.15);
            border: 1px solid rgba(239,68,68,0.4);
            border-radius: 14px;
            padding: 16px 20px;
            margin-bottom: 20px;
            display: flex; gap: 12px; align-items: flex-start;
        }
        .alert-rejected i { color: #f87171; font-size: 1.1rem; margin-top: 2px; flex-shrink: 0; }
        .alert-rejected strong { color: #fca5a5; display: block; margin-bottom: 4px; }
        .alert-rejected p { color: rgba(255,255,255,0.8); font-size: 0.88rem; line-height: 1.5; }

        .alert-success-msg {
            background: rgba(16,185,129,0.15);
            border: 1px solid rgba(16,185,129,0.4);
            border-radius: 14px;
            padding: 16px 20px;
            margin-bottom: 20px;
            display: flex; gap: 12px; align-items: center;
            color: #6ee7b7;
        }

        /* ── Card ── */
        .card {
            background: var(--white);
            border-radius: 24px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        /* ── Steps indicator ── */
        .steps-bar {
            background: linear-gradient(135deg, var(--g1), var(--g2));
            padding: 20px 32px;
            display: flex; align-items: center; gap: 0;
        }
        .step {
            display: flex; align-items: center; gap: 8px;
            flex: 1;
        }
        .step-num {
            width: 28px; height: 28px; border-radius: 50%;
            background: rgba(255,255,255,0.2);
            border: 2px solid rgba(255,255,255,0.4);
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.7); font-size: 0.75rem; font-weight: 700;
            flex-shrink: 0;
        }
        .step.active .step-num {
            background: var(--g4); border-color: var(--g4); color: var(--g1);
        }
        .step-label { color: rgba(255,255,255,0.6); font-size: 0.78rem; font-weight: 500; }
        .step.active .step-label { color: #fff; font-weight: 600; }
        .step-line { flex: 1; height: 1px; background: rgba(255,255,255,0.2); margin: 0 8px; }

        /* ── Form ── */
        .form-body { padding: 36px 40px; }

        .section-title {
            font-size: 1.1rem; font-weight: 700; color: var(--text);
            margin-bottom: 20px; padding-bottom: 12px;
            border-bottom: 2px solid var(--bg);
            display: flex; align-items: center; gap: 8px;
        }
        .section-title i { color: var(--g2); }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; }
        .form-grid.full { grid-template-columns: 1fr; }

        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-label {
            font-size: 0.82rem; font-weight: 600; color: var(--text);
            display: flex; align-items: center; gap: 4px;
        }
        .form-label .req { color: #ef4444; }

        .form-control {
            padding: 11px 14px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            color: var(--text);
            background: #f9fafb;
            transition: all 0.2s;
            outline: none;
        }
        .form-control:focus { border-color: var(--g3); background: #fff; box-shadow: 0 0 0 3px rgba(16,185,129,0.1); }
        .form-control.is-invalid { border-color: #ef4444; }
        .invalid-feedback { display: block !important; font-size: 0.78rem; color: #ef4444; margin-top: 4px; font-weight: 500; }

        /* ── Role Cards ── */
        .role-cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 24px; }
        .role-card {
            border: 2px solid var(--border);
            border-radius: 14px;
            padding: 18px 16px;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            background: #f9fafb;
        }
        .role-card:hover { border-color: var(--g3); background: #f0fdf4; }
        .role-card.selected { border-color: var(--g2); background: #ecfdf5; }
        .role-card input[type="radio"] { position: absolute; opacity: 0; }
        .role-icon {
            width: 44px; height: 44px; border-radius: 12px;
            background: linear-gradient(135deg, var(--g1), var(--g3));
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1.1rem; margin-bottom: 10px;
        }
        .role-card.selected .role-icon { background: linear-gradient(135deg, var(--g2), var(--g4)); }
        .role-name { font-weight: 700; font-size: 0.9rem; color: var(--text); margin-bottom: 4px; }
        .role-desc { font-size: 0.75rem; color: var(--text-muted); line-height: 1.4; }
        .role-check {
            position: absolute; top: 12px; right: 12px;
            width: 20px; height: 20px; border-radius: 50%;
            border: 2px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            transition: all 0.2s;
        }
        .role-card.selected .role-check {
            background: var(--g2); border-color: var(--g2); color: #fff;
        }
        .role-card.selected .role-check::after {
            content: '✓'; font-size: 0.7rem; font-weight: 700;
        }

        /* ── File Upload ── */
        .file-upload-area {
            border: 2px dashed var(--border);
            border-radius: 12px;
            padding: 28px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background: #f9fafb;
            position: relative;
        }
        .file-upload-area:hover, .file-upload-area.dragover {
            border-color: var(--g3); background: #f0fdf4;
        }
        .file-upload-area input[type="file"] {
            position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
        }
        .upload-icon { font-size: 2rem; color: var(--g3); margin-bottom: 10px; }
        .upload-text { font-size: 0.88rem; color: var(--text-muted); }
        .upload-text strong { color: var(--g2); }
        .upload-hint { font-size: 0.75rem; color: var(--text-muted); margin-top: 4px; }
        .file-selected {
            display: none;
            align-items: center; gap: 10px;
            background: #ecfdf5; border-radius: 8px; padding: 10px 14px; margin-top: 10px;
        }
        .file-selected i { color: var(--g2); }
        .file-selected span { font-size: 0.85rem; color: var(--g1); font-weight: 500; }

        /* ── Submit ── */
        .form-footer {
            display: flex; align-items: center; justify-content: space-between;
            padding-top: 24px; border-top: 2px solid var(--bg);
            margin-top: 8px;
        }
        .btn-logout {
            display: flex; align-items: center; gap: 6px;
            color: var(--text-muted); font-size: 0.85rem; text-decoration: none;
            padding: 8px 14px; border-radius: 8px; transition: all 0.2s;
            background: none; border: 1px solid var(--border); cursor: pointer;
            font-family: 'Inter', sans-serif;
        }
        .btn-logout:hover { background: #f3f4f6; color: var(--text); }
        .btn-submit {
            display: flex; align-items: center; gap: 8px;
            background: linear-gradient(135deg, var(--g1), var(--g3));
            color: #fff; border: none; border-radius: 12px;
            padding: 13px 28px; font-family: 'Inter', sans-serif;
            font-size: 0.95rem; font-weight: 700; cursor: pointer;
            transition: all 0.25s;
            box-shadow: 0 4px 15px rgba(4,120,87,0.35);
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(4,120,87,0.45); }
        .btn-submit:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }

        @media (max-width: 640px) {
            .form-body { padding: 24px 20px; }
            .form-grid { grid-template-columns: 1fr; }
            .role-cards { grid-template-columns: 1fr; }
            .page-header h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
<div class="page-wrapper">

    <!-- Header -->
    <div class="page-header">
        <div class="logo">
            <div class="logo-img-wrap">
                @if(file_exists(public_path('images/logo.png')))
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                @else
                    <i class="fas fa-shield-alt" style="color:#047857;font-size:1.1rem;"></i>
                @endif
            </div>
            <span class="logo-name">Risk<span>Management</span></span>
        </div>
        <h1>Pengajuan Akses Sistem</h1>
        <p>Lengkapi data berikut untuk mendapatkan akses sesuai peran Anda di UIN Siber Syekh Nurjati Cirebon</p>
    </div>

    <!-- Alert: Pengajuan Ditolak -->
    @if(isset($existingRequest) && $existingRequest && $existingRequest->isRejected())
    <div class="alert-rejected">
        <i class="fas fa-times-circle"></i>
        <div>
            <strong>Pengajuan Sebelumnya Ditolak</strong>
            <p>Alasan: {{ $existingRequest->rejection_reason }}</p>
            <p style="margin-top:4px;">Silakan perbaiki data dan ajukan kembali.</p>
        </div>
    </div>
    @endif

    @if(session('success'))
    <div class="alert-success-msg">
        <i class="fas fa-check-circle" style="font-size:1.1rem;flex-shrink:0;"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Card Form -->
    <div class="card">
        <!-- Steps -->
        <div class="steps-bar">
            <div class="step active">
                <div class="step-num">1</div>
                <span class="step-label">Isi Data Pengajuan</span>
            </div>
            <div class="step-line"></div>
            <div class="step">
                <div class="step-num">2</div>
                <span class="step-label">Review Admin</span>
            </div>
            <div class="step-line"></div>
            <div class="step">
                <div class="step-num">3</div>
                <span class="step-label">Akses Diberikan</span>
            </div>
        </div>

        <!-- Form -->
        <div class="form-body">
            <form method="POST" action="{{ route('role-request.store') }}" enctype="multipart/form-data" id="roleRequestForm">
                @csrf

                <!-- Pilih Role -->
                <div class="section-title">
                    <i class="fas fa-user-tag"></i>
                    Role yang Diajukan <span class="req" style="color:#ef4444;font-size:0.75rem;">*</span>
                </div>

                <div class="role-cards" id="roleCards">
                    @php
                        $roles = [
                            'Risk Manager' => ['icon' => 'fas fa-crown', 'desc' => 'Bertanggung jawab atas keseluruhan program manajemen risiko institusi'],
                            'Risk Officer' => ['icon' => 'fas fa-user-shield', 'desc' => 'Memantau, mengkoordinasi, dan melaporkan risiko di unit kerja'],
                            'Risk Owner'   => ['icon' => 'fas fa-tasks', 'desc' => 'Pemilik dan penanggung jawab risiko di level operasional'],
                        ];
                        $oldRole = old('requested_role', isset($existingRequest) ? $existingRequest->requested_role : '');
                    @endphp
                    @foreach($roles as $roleName => $roleData)
                    <label class="role-card {{ $oldRole === $roleName ? 'selected' : '' }}" onclick="selectRole(this, '{{ $roleName }}')">
                        <input type="radio" name="requested_role" value="{{ $roleName }}" {{ $oldRole === $roleName ? 'checked' : '' }}>
                        <div class="role-icon"><i class="{{ $roleData['icon'] }}"></i></div>
                        <div class="role-name">{{ $roleName }}</div>
                        <div class="role-desc">{{ $roleData['desc'] }}</div>
                        <div class="role-check"></div>
                    </label>
                    @endforeach
                </div>
                @error('requested_role')
                    <p class="invalid-feedback" style="margin-top:-16px;margin-bottom:16px;">{{ $message }}</p>
                @enderror

                <!-- Data Diri -->
                <div class="section-title" style="margin-top:8px;">
                    <i class="fas fa-id-card"></i>
                    Data Diri & Unit Kerja
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">
                            Nama Lengkap
                        </label>
                        <input type="text" class="form-control" value="{{ Auth::user()->name }}" disabled style="background:#f3f4f6;color:#6b7280;">
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            Email
                        </label>
                        <input type="text" class="form-control" value="{{ Auth::user()->email }}" disabled style="background:#f3f4f6;color:#6b7280;">
                    </div>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="position">
                            Jabatan / Posisi <span class="req">*</span>
                        </label>
                        <input type="text" id="position" name="position"
                               class="form-control @error('position') is-invalid @enderror"
                               placeholder="cth: Kepala Biro Keuangan, Dekan Fakultas..."
                               value="{{ old('position', isset($existingRequest) ? $existingRequest->position : '') }}"
                               required>
                        @error('position')<p class="invalid-feedback">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="unit_id">
                            Unit / Fakultas <span class="req">*</span>
                        </label>
                        <select id="unit_id" name="unit_id"
                                class="form-control @error('unit_id') is-invalid @enderror" required>
                            <option value="">-- Pilih Unit/Fakultas --</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}"
                                    {{ old('unit_id', isset($existingRequest) ? $existingRequest->unit_id : '') == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->nama_unit }}
                                </option>
                            @endforeach
                        </select>
                        @error('unit_id')<p class="invalid-feedback">{{ $message }}</p>@enderror
                    </div>
                </div>

                <!-- Upload SK -->
                <div class="section-title" style="margin-top:8px;">
                    <i class="fas fa-file-upload"></i>
                    Surat Keputusan (SK) Penunjukan
                    <span style="font-size:0.72rem;font-weight:400;color:var(--text-muted);margin-left:4px;">(opsional)</span>
                </div>

                <div class="file-upload-area" id="uploadArea">
                    <input type="file" name="sk_file" id="sk_file" accept=".pdf,.jpg,.jpeg,.png"
                           onchange="handleFileSelect(this)">
                    <div id="uploadPlaceholder">
                        <div class="upload-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                        <div class="upload-text">
                            <strong>Klik untuk upload</strong> atau drag & drop file SK
                        </div>
                        <div class="upload-hint">Format: PDF, JPG, PNG — Maks. 2MB</div>
                    </div>
                    <div class="file-selected" id="fileSelected">
                        <i class="fas fa-file-check fa-lg"></i>
                        <span id="fileName">—</span>
                    </div>
                </div>
                @error('sk_file')<p class="invalid-feedback" style="margin-top:6px;">{{ $message }}</p>@enderror

                @if(isset($existingRequest) && $existingRequest && $existingRequest->sk_file)
                <div style="margin-top:10px;display:flex;align-items:center;gap:8px;font-size:0.82rem;color:var(--text-muted);">
                    <i class="fas fa-paperclip" style="color:var(--g2);"></i>
                    File SK sebelumnya:
                    <a href="{{ $existingRequest->sk_url }}" target="_blank" style="color:var(--g2);font-weight:600;">
                        {{ $existingRequest->sk_original_name ?? 'Lihat File' }}
                    </a>
                    <span style="color:#9ca3af;">(upload baru untuk mengganti)</span>
                </div>
                @endif

                <!-- Footer -->
                <div class="form-footer">
                    <button type="button" class="btn-logout" onclick="document.getElementById('logoutForm').submit();">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </button>

                    <button type="submit" class="btn-submit" id="submitBtn">
                        <i class="fas fa-paper-plane"></i>
                        Ajukan Persetujuan
                    </button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}" id="logoutForm" style="display:none;">
                @csrf
            </form>
        </div>
    </div>

    <p style="text-align:center;color:rgba(255,255,255,0.4);font-size:0.75rem;margin-top:20px;">
        &copy; {{ date('Y') }} RiskManagement — UIN Siber Syekh Nurjati Cirebon
    </p>
</div>

<script>
    function selectRole(card, roleName) {
        document.querySelectorAll('.role-card').forEach(c => c.classList.remove('selected'));
        card.classList.add('selected');
        card.querySelector('input[type="radio"]').checked = true;
    }

    function handleFileSelect(input) {
        const file = input.files[0];
        if (file) {
            document.getElementById('uploadPlaceholder').style.display = 'none';
            const sel = document.getElementById('fileSelected');
            sel.style.display = 'flex';
            document.getElementById('fileName').textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
        }
    }

    // Drag & drop
    const area = document.getElementById('uploadArea');
    area.addEventListener('dragover', e => { e.preventDefault(); area.classList.add('dragover'); });
    area.addEventListener('dragleave', () => area.classList.remove('dragover'));
    area.addEventListener('drop', e => {
        e.preventDefault(); area.classList.remove('dragover');
        const input = document.getElementById('sk_file');
        input.files = e.dataTransfer.files;
        handleFileSelect(input);
    });

    // Disable double submit
    document.getElementById('roleRequestForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        setTimeout(() => {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengirim...';
        }, 10);
    });
</script>
</body>
</html>
