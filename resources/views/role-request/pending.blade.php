<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Persetujuan — RiskManagement</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #064e3b 0%, #065f46 40%, #047857 100%);
            min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px;
        }
        .card {
            background: #fff; border-radius: 24px; padding: 48px 44px;
            max-width: 560px; width: 100%; text-align: center;
            box-shadow: 0 20px 60px rgba(4,120,87,0.2);
        }
        .pulse-ring {
            width: 90px; height: 90px; border-radius: 50%;
            background: linear-gradient(135deg, #d97706, #fbbf24);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 24px;
            position: relative;
            animation: pulse 2s infinite;
        }
        .pulse-ring::before {
            content: ''; position: absolute; inset: -8px; border-radius: 50%;
            border: 3px solid rgba(217,119,6,0.3); animation: ping 2s infinite;
        }
        @keyframes pulse { 0%,100%{transform:scale(1)} 50%{transform:scale(1.05)} }
        @keyframes ping { 0%{transform:scale(1);opacity:1} 100%{transform:scale(1.5);opacity:0} }
        .pulse-ring i { font-size: 2rem; color: #fff; }

        h1 { font-size: 1.5rem; font-weight: 800; color: #111827; margin-bottom: 8px; }
        .subtitle { color: #6b7280; font-size: 0.9rem; line-height: 1.6; margin-bottom: 28px; }

        .info-box {
            background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 14px;
            padding: 20px; margin-bottom: 24px; text-align: left;
        }
        .info-row { display: flex; justify-content: space-between; align-items: center; padding: 6px 0; }
        .info-row:not(:last-child) { border-bottom: 1px solid #d1fae5; }
        .info-label { font-size: 0.8rem; color: #6b7280; font-weight: 500; }
        .info-value { font-size: 0.85rem; color: #111827; font-weight: 600; }
        .badge-pending {
            background: #fef3c7; color: #92400e; border-radius: 50px;
            padding: 3px 12px; font-size: 0.75rem; font-weight: 700;
        }

        .steps { display: flex; gap: 0; margin-bottom: 28px; }
        .step { flex: 1; text-align: center; position: relative; }
        .step::after {
            content: ''; position: absolute; top: 14px; left: 50%; width: 100%; height: 2px;
            background: #e5e7eb; z-index: 0;
        }
        .step:last-child::after { display: none; }
        .step-dot {
            width: 28px; height: 28px; border-radius: 50%; margin: 0 auto 6px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.7rem; font-weight: 700; position: relative; z-index: 1;
        }
        .step-dot.done { background: #10b981; color: #fff; }
        .step-dot.active { background: #d97706; color: #fff; animation: pulse 2s infinite; }
        .step-dot.wait { background: #e5e7eb; color: #9ca3af; }
        .step-label { font-size: 0.7rem; color: #6b7280; }
        .step-dot.done + .step-label { color: #10b981; font-weight: 600; }
        .step-dot.active + .step-label { color: #d97706; font-weight: 600; }

        .btn-group { display: flex; gap: 12px; justify-content: center; }
        .btn-refresh {
            display: flex; align-items: center; gap: 6px;
            background: linear-gradient(135deg, #064e3b, #10b981);
            color: #fff; border: none; border-radius: 10px;
            padding: 11px 22px; font-family: 'Inter', sans-serif;
            font-size: 0.88rem; font-weight: 600; cursor: pointer;
            text-decoration: none; transition: all 0.2s;
        }
        .btn-refresh:hover { transform: translateY(-1px); opacity: 0.9; }
        .btn-logout {
            display: flex; align-items: center; gap: 6px;
            background: none; border: 1.5px solid #d1d5db; border-radius: 10px;
            padding: 11px 22px; font-family: 'Inter', sans-serif;
            font-size: 0.88rem; font-weight: 600; color: #6b7280; cursor: pointer;
            transition: all 0.2s;
        }
        .btn-logout:hover { border-color: #9ca3af; color: #374151; }
    </style>
</head>
<body>
<div class="card">
    <div class="pulse-ring">
        <i class="fas fa-hourglass-half"></i>
    </div>

    <h1>Pengajuan Sedang Diproses</h1>
    <p class="subtitle">
        Pengajuan role Anda telah diterima dan sedang menunggu review dari administrator.
        Anda akan mendapat akses setelah disetujui.
    </p>

    <!-- Info Pengajuan -->
    <div class="info-box">
        <div class="info-row">
            <span class="info-label"><i class="fas fa-user-tag" style="margin-right:4px;color:#047857;"></i> Role Diajukan</span>
            <span class="info-value">{{ $existingRequest->requested_role }}</span>
        </div>
        <div class="info-row">
            <span class="info-label"><i class="fas fa-id-badge" style="margin-right:4px;color:#047857;"></i> Jabatan</span>
            <span class="info-value">{{ $existingRequest->position }}</span>
        </div>
        <div class="info-row">
            <span class="info-label"><i class="fas fa-building" style="margin-right:4px;color:#047857;"></i> Unit/Fakultas</span>
            <span class="info-value">{{ $existingRequest->unit?->name ?? '—' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label"><i class="fas fa-calendar" style="margin-right:4px;color:#047857;"></i> Tanggal Pengajuan</span>
            <span class="info-value">{{ $existingRequest->created_at->format('d M Y, H:i') }}</span>
        </div>
        <div class="info-row">
            <span class="info-label"><i class="fas fa-circle-dot" style="margin-right:4px;color:#047857;"></i> Status</span>
            <span class="badge-pending"><i class="fas fa-clock" style="margin-right:4px;"></i>Menunggu Review</span>
        </div>
    </div>

    <!-- Steps -->
    <div class="steps">
        <div class="step">
            <div class="step-dot done"><i class="fas fa-check" style="font-size:0.65rem;"></i></div>
            <div class="step-label">Pengajuan Dikirim</div>
        </div>
        <div class="step">
            <div class="step-dot active"><i class="fas fa-search" style="font-size:0.65rem;"></i></div>
            <div class="step-label">Review Admin</div>
        </div>
        <div class="step">
            <div class="step-dot wait">3</div>
            <div class="step-label">Akses Diberikan</div>
        </div>
    </div>

    <div class="btn-group">
        <a href="{{ route('role-request.create') }}" class="btn-refresh">
            <i class="fas fa-sync-alt"></i> Cek Status
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </button>
        </form>
    </div>
</div>
</body>
</html>
