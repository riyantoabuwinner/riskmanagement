<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RiskManagement — Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --g1: #064e3b;
            --g2: #047857;
            --g3: #10b981;
            --g4: #34d399;
            --accent: #6ee7b7;
            --bg: #f0fdf4;
            --card-bg: #ffffff;
            --text-primary: #111827;
            --text-secondary: #6b7280;
            --input-bg: #f9fafb;
            --input-border: #d1d5db;
            --input-focus: #10b981;
            --shadow: 0 20px 60px rgba(4,120,87,0.12);
        }
        [data-theme="dark"] {
            --bg: #0a1628;
            --card-bg: #111827;
            --text-primary: #f9fafb;
            --text-secondary: #9ca3af;
            --input-bg: #1f2937;
            --input-border: #374151;
            --input-focus: #10b981;
            --shadow: 0 20px 60px rgba(0,0,0,0.5);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.3s ease;
        }

        .login-container {
            display: flex;
            width: 100%;
            max-width: 1100px;
            min-height: 600px;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: var(--shadow);
            margin: 20px;
        }

        /* ── Left: Form Panel ── */
        .form-panel {
            flex: 0 0 420px;
            background: var(--card-bg);
            padding: 48px 44px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            transition: background 0.3s ease;
        }

        .theme-toggle {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 50px;
            padding: 6px 14px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
            color: var(--text-secondary);
            transition: all 0.2s;
        }
        .theme-toggle:hover { border-color: var(--g3); color: var(--g2); }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 36px;
        }
        .logo-icon {
            width: 46px; height: 46px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--g1), var(--g3));
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1.3rem;
            box-shadow: 0 4px 12px rgba(4,120,87,0.35);
        }
        .logo-text { font-size: 1.5rem; font-weight: 800; color: var(--text-primary); }
        .logo-text span { color: var(--g3); }

        .form-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 6px;
        }
        .form-subtitle {
            font-size: 0.88rem;
            color: var(--text-secondary);
            margin-bottom: 32px;
        }

        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 7px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .input-wrapper {
            position: relative;
        }
        .input-icon {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 0.9rem;
            pointer-events: none;
        }
        .form-input {
            width: 100%;
            padding: 12px 14px 12px 40px;
            background: var(--input-bg);
            border: 1.5px solid var(--input-border);
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-size: 0.9rem;
            color: var(--text-primary);
            transition: all 0.2s;
            outline: none;
        }
        .form-input:focus {
            border-color: var(--input-focus);
            background: var(--card-bg);
            box-shadow: 0 0 0 3px rgba(16,185,129,0.12);
        }
        .form-input.is-invalid { border-color: #ef4444; }

        .toggle-password {
            position: absolute;
            right: 14px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            color: var(--text-secondary);
            cursor: pointer; font-size: 0.9rem;
            padding: 0;
        }

        .invalid-feedback {
            color: #ef4444;
            font-size: 0.78rem;
            margin-top: 5px;
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .checkbox-label {
            display: flex; align-items: center; gap: 8px;
            font-size: 0.85rem; color: var(--text-secondary);
            cursor: pointer;
        }
        .checkbox-label input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--g3);
            cursor: pointer;
        }
        .forgot-link {
            font-size: 0.85rem;
            color: var(--g2);
            text-decoration: none;
            font-weight: 500;
        }
        .forgot-link:hover { color: var(--g3); text-decoration: underline; }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, var(--g1), var(--g3));
            color: #fff;
            border: none;
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.25s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            box-shadow: 0 4px 15px rgba(4,120,87,0.35);
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(4,120,87,0.45);
        }
        .btn-login:active { transform: translateY(0); }
        
        /* Captcha Styling */
        .captcha-container {
            background: var(--input-bg);
            border: 1.5px solid var(--input-border);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s ease;
        }
        .captcha-container:focus-within {
            border-color: var(--input-focus);
            box-shadow: 0 0 0 3px rgba(16,185,129,0.1);
            background: var(--card-bg);
        }
        .captcha-challenge {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .captcha-box {
            background: linear-gradient(135deg, var(--g1), var(--g2));
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 2px;
            box-shadow: 0 4px 10px rgba(4,120,87,0.2);
            user-select: none;
        }
        .captcha-input {
            width: 80px;
            border: none;
            background: rgba(16,185,129,0.05);
            padding: 8px;
            border-radius: 6px;
            text-align: center;
            font-weight: 700;
            font-size: 1rem;
            color: var(--text-primary);
            outline: none;
            border: 1px solid transparent;
            transition: all 0.2s;
        }
        .captcha-input:focus {
            border-color: var(--g3);
            background: var(--card-bg);
        }
        .captcha-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            margin-bottom: 4px;
            display: block;
        }
        .refresh-captcha {
            color: var(--text-secondary);
            cursor: pointer;
            font-size: 0.9rem;
            transition: color 0.2s;
        }
        .refresh-captcha:hover { color: var(--g3); }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 20px;
            color: #dc2626;
            font-size: 0.85rem;
            display: flex; align-items: center; gap: 8px;
        }
        [data-theme="dark"] .alert-error { background: #1f1010; border-color: #7f1d1d; }

        .alert-info {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 20px;
            color: var(--g2);
            font-size: 0.85rem;
        }
        [data-theme="dark"] .alert-info { background: #052e16; border-color: #166534; }

        .footer-text {
            text-align: center;
            margin-top: 28px;
            font-size: 0.78rem;
            color: var(--text-secondary);
        }

        /* ── Right: Illustration Panel ── */
        .illus-panel {
            flex: 1;
            background: linear-gradient(145deg, var(--g1) 0%, #065f46 40%, var(--g2) 70%, #059669 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px;
            position: relative;
            overflow: hidden;
        }

        /* Decorative circles */
        .illus-panel::before {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            top: -100px; right: -100px;
        }
        .illus-panel::after {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            bottom: -80px; left: -80px;
        }

        .illus-content { position: relative; z-index: 1; text-align: center; }

        .illus-title {
            font-size: 1.9rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 12px;
            line-height: 1.2;
        }
        .illus-subtitle {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.75);
            margin-bottom: 40px;
            line-height: 1.6;
        }

        .illus-svg { width: 100%; max-width: 420px; }

        .stats-row {
            display: flex;
            gap: 16px;
            margin-top: 36px;
        }
        .stat-chip {
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 12px;
            padding: 12px 18px;
            text-align: center;
            flex: 1;
        }
        .stat-chip .num { font-size: 1.4rem; font-weight: 800; color: #fff; }
        .stat-chip .lbl { font-size: 0.72rem; color: rgba(255,255,255,0.7); margin-top: 2px; }

        /* Responsive */
        @media (max-width: 768px) {
            .login-container { flex-direction: column; }
            .form-panel { flex: none; padding: 36px 28px; }
            .illus-panel { display: none; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- ── Form Panel (Left) ── -->
        <div class="form-panel">
            <!-- Theme Toggle -->
            <button class="theme-toggle" onclick="toggleTheme()" id="themeBtn">
                <i class="fas fa-moon" id="themeIcon"></i>
                <span id="themeLabel">Dark</span>
            </button>

            <!-- Logo -->
            <div class="logo-area">
                @php $lp = public_path('images/logo.png'); $lj = public_path('images/logo.jpg'); $ls = public_path('images/logo.svg'); @endphp
                @if(file_exists($lp) || file_exists($lj) || file_exists($ls))
                    <img src="{{ asset(file_exists($lp) ? 'images/logo.png' : (file_exists($lj) ? 'images/logo.jpg' : 'images/logo.svg')) }}" alt="Logo" style="width:44px;height:44px;object-fit:contain;border-radius:12px;display:block;margin-bottom:10px;">
                @else
                    <div class="logo-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                @endif
                <div class="logo-text">Risk<span>Management</span></div>
            </div>

            <!-- Title -->
            <div class="form-title">Selamat Datang 👋</div>
            <div class="form-subtitle">Masuk ke Sistem Manajemen Risiko UIN Siber Syekh Nurjati Cirebon</div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert-info">
                    <i class="fas fa-info-circle mr-2"></i>{{ session('status') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="email" name="email" class="form-input @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" placeholder="email@uinssc.ac.id" required autofocus autocomplete="username">
                    </div>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" class="form-input @error('password') is-invalid @enderror"
                               placeholder="••••••••" required autocomplete="current-password">
                        <button type="button" class="toggle-password" onclick="togglePassword()" id="eyeBtn">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-options">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember" id="remember_me">
                        Ingat saya
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                    @endif
                </div>

                <!-- Modern Captcha -->
                <div class="form-group">
                    <label class="captcha-label">Verifikasi Keamanan</label>
                    <div class="captcha-container">
                        <div class="captcha-challenge">
                            <div class="captcha-box">{{ $n1 }} + {{ $n2 }}</div>
                            <span style="color: var(--text-secondary); font-weight: 500;">=</span>
                            <input type="text" name="captcha" class="captcha-input" placeholder="?" required autocomplete="off">
                        </div>
                        <a href="javascript:void(0)" onclick="window.location.reload()" class="refresh-captcha" title="Muat ulang kode">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>
                    @error('captcha')<div class="invalid-feedback" style="margin-top: -15px; margin-bottom: 15px;">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt"></i>
                    Masuk ke Sistem
                </button>
            </form>

            <div class="footer-text">
                &copy; {{ date('Y') }} UIN Siber Syekh Nurjati Cirebon &mdash; Sistem Manajemen Risiko v1.0
            </div>
        </div>

        <!-- ── Illustration Panel (Right) ── -->
        <div class="illus-panel">
            <div class="illus-content">
                <div class="illus-title">Kelola Risiko<br>Secara Proaktif</div>
                <div class="illus-subtitle">
                    Platform manajemen risiko terintegrasi berbasis<br>
                    ISO 31000:2018 untuk institusi pendidikan tinggi
                </div>

                <!-- SVG Illustration -->
                <svg class="illus-svg" viewBox="0 0 420 320" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Background glow -->
                    <ellipse cx="210" cy="160" rx="180" ry="130" fill="rgba(255,255,255,0.04)"/>

                    <!-- Risk Heatmap Matrix (5x5) -->
                    <g transform="translate(30, 40)">
                        <!-- Matrix cells -->
                        <!-- Row 5 (Likelihood=5) -->
                        <rect x="40" y="0" width="34" height="28" rx="5" fill="#fbbf24" opacity="0.85"/>
                        <rect x="78" y="0" width="34" height="28" rx="5" fill="#f97316" opacity="0.85"/>
                        <rect x="116" y="0" width="34" height="28" rx="5" fill="#ef4444" opacity="0.85"/>
                        <rect x="154" y="0" width="34" height="28" rx="5" fill="#ef4444" opacity="0.9"/>
                        <rect x="192" y="0" width="34" height="28" rx="5" fill="#dc2626" opacity="0.95"/>
                        <!-- Row 4 -->
                        <rect x="40" y="32" width="34" height="28" rx="5" fill="#84cc16" opacity="0.8"/>
                        <rect x="78" y="32" width="34" height="28" rx="5" fill="#fbbf24" opacity="0.85"/>
                        <rect x="116" y="32" width="34" height="28" rx="5" fill="#f97316" opacity="0.85"/>
                        <rect x="154" y="32" width="34" height="28" rx="5" fill="#ef4444" opacity="0.85"/>
                        <rect x="192" y="32" width="34" height="28" rx="5" fill="#ef4444" opacity="0.9"/>
                        <!-- Row 3 -->
                        <rect x="40" y="64" width="34" height="28" rx="5" fill="#34d399" opacity="0.8"/>
                        <rect x="78" y="64" width="34" height="28" rx="5" fill="#84cc16" opacity="0.8"/>
                        <rect x="116" y="64" width="34" height="28" rx="5" fill="#fbbf24" opacity="0.85"/>
                        <rect x="154" y="64" width="34" height="28" rx="5" fill="#f97316" opacity="0.85"/>
                        <rect x="192" y="64" width="34" height="28" rx="5" fill="#ef4444" opacity="0.85"/>
                        <!-- Row 2 -->
                        <rect x="40" y="96" width="34" height="28" rx="5" fill="#10b981" opacity="0.75"/>
                        <rect x="78" y="96" width="34" height="28" rx="5" fill="#34d399" opacity="0.8"/>
                        <rect x="116" y="96" width="34" height="28" rx="5" fill="#84cc16" opacity="0.8"/>
                        <rect x="154" y="96" width="34" height="28" rx="5" fill="#fbbf24" opacity="0.85"/>
                        <rect x="192" y="96" width="34" height="28" rx="5" fill="#f97316" opacity="0.85"/>
                        <!-- Row 1 -->
                        <rect x="40" y="128" width="34" height="28" rx="5" fill="#10b981" opacity="0.7"/>
                        <rect x="78" y="128" width="34" height="28" rx="5" fill="#10b981" opacity="0.75"/>
                        <rect x="116" y="128" width="34" height="28" rx="5" fill="#34d399" opacity="0.8"/>
                        <rect x="154" y="128" width="34" height="28" rx="5" fill="#84cc16" opacity="0.8"/>
                        <rect x="192" y="128" width="34" height="28" rx="5" fill="#fbbf24" opacity="0.85"/>

                        <!-- Axis labels -->
                        <text x="20" y="18" fill="rgba(255,255,255,0.6)" font-size="9" font-family="Inter" text-anchor="middle">5</text>
                        <text x="20" y="50" fill="rgba(255,255,255,0.6)" font-size="9" font-family="Inter" text-anchor="middle">4</text>
                        <text x="20" y="82" fill="rgba(255,255,255,0.6)" font-size="9" font-family="Inter" text-anchor="middle">3</text>
                        <text x="20" y="114" fill="rgba(255,255,255,0.6)" font-size="9" font-family="Inter" text-anchor="middle">2</text>
                        <text x="20" y="146" fill="rgba(255,255,255,0.6)" font-size="9" font-family="Inter" text-anchor="middle">1</text>

                        <text x="57" y="172" fill="rgba(255,255,255,0.6)" font-size="9" font-family="Inter" text-anchor="middle">1</text>
                        <text x="95" y="172" fill="rgba(255,255,255,0.6)" font-size="9" font-family="Inter" text-anchor="middle">2</text>
                        <text x="133" y="172" fill="rgba(255,255,255,0.6)" font-size="9" font-family="Inter" text-anchor="middle">3</text>
                        <text x="171" y="172" fill="rgba(255,255,255,0.6)" font-size="9" font-family="Inter" text-anchor="middle">4</text>
                        <text x="209" y="172" fill="rgba(255,255,255,0.6)" font-size="9" font-family="Inter" text-anchor="middle">5</text>

                        <text x="113" y="190" fill="rgba(255,255,255,0.5)" font-size="9" font-family="Inter" text-anchor="middle" font-weight="600">IMPACT →</text>

                        <!-- Axis label vertical -->
                        <text x="-75" y="14" fill="rgba(255,255,255,0.5)" font-size="9" font-family="Inter" text-anchor="middle" font-weight="600" transform="rotate(-90, 5, 80)">LIKELIHOOD ↑</text>

                        <!-- Risk dot indicators -->
                        <circle cx="209" cy="14" r="5" fill="#fff" opacity="0.9"/>
                        <text x="209" y="18" fill="#dc2626" font-size="7" font-family="Inter" text-anchor="middle" font-weight="800">3</text>
                        <circle cx="171" cy="46" r="5" fill="#fff" opacity="0.9"/>
                        <text x="171" y="50" fill="#ef4444" font-size="7" font-family="Inter" text-anchor="middle" font-weight="800">2</text>
                        <circle cx="133" cy="78" r="5" fill="#fff" opacity="0.9"/>
                        <text x="133" y="82" fill="#f97316" font-size="7" font-family="Inter" text-anchor="middle" font-weight="800">5</text>
                    </g>

                    <!-- Shield Icon -->
                    <g transform="translate(280, 30)">
                        <circle cx="50" cy="50" r="42" fill="rgba(255,255,255,0.1)" stroke="rgba(255,255,255,0.2)" stroke-width="1.5"/>
                        <path d="M50 18 L72 28 L72 50 C72 64 62 76 50 80 C38 76 28 64 28 50 L28 28 Z"
                              fill="rgba(255,255,255,0.15)" stroke="rgba(255,255,255,0.4)" stroke-width="1.5"/>
                        <path d="M42 50 L47 55 L60 42" stroke="#6ee7b7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>

                    <!-- Bar Chart -->
                    <g transform="translate(280, 140)">
                        <rect x="0" y="60" width="18" height="40" rx="4" fill="rgba(16,185,129,0.5)"/>
                        <rect x="24" y="40" width="18" height="60" rx="4" fill="rgba(16,185,129,0.65)"/>
                        <rect x="48" y="20" width="18" height="80" rx="4" fill="rgba(16,185,129,0.8)"/>
                        <rect x="72" y="30" width="18" height="70" rx="4" fill="rgba(251,191,36,0.75)"/>
                        <rect x="96" y="10" width="18" height="90" rx="4" fill="rgba(239,68,68,0.7)"/>
                        <!-- Trend line -->
                        <polyline points="9,60 33,40 57,20 81,30 105,10"
                                  stroke="#6ee7b7" stroke-width="2" fill="none" stroke-dasharray="4,3"/>
                        <circle cx="9" cy="60" r="3" fill="#6ee7b7"/>
                        <circle cx="33" cy="40" r="3" fill="#6ee7b7"/>
                        <circle cx="57" cy="20" r="3" fill="#6ee7b7"/>
                        <circle cx="81" cy="30" r="3" fill="#fbbf24"/>
                        <circle cx="105" cy="10" r="3" fill="#ef4444"/>
                    </g>

                    <!-- Connecting nodes -->
                    <g transform="translate(0, 220)" opacity="0.6">
                        <circle cx="60" cy="50" r="22" fill="rgba(255,255,255,0.08)" stroke="rgba(255,255,255,0.2)" stroke-width="1"/>
                        <text x="60" y="46" fill="rgba(255,255,255,0.8)" font-size="8" font-family="Inter" text-anchor="middle">Strategis</text>
                        <text x="60" y="57" fill="rgba(255,255,255,0.8)" font-size="8" font-family="Inter" text-anchor="middle">Risk</text>

                        <circle cx="160" cy="50" r="22" fill="rgba(255,255,255,0.08)" stroke="rgba(255,255,255,0.2)" stroke-width="1"/>
                        <text x="160" y="46" fill="rgba(255,255,255,0.8)" font-size="8" font-family="Inter" text-anchor="middle">Keuangan</text>
                        <text x="160" y="57" fill="rgba(255,255,255,0.8)" font-size="8" font-family="Inter" text-anchor="middle">Risk</text>

                        <circle cx="260" cy="50" r="22" fill="rgba(255,255,255,0.08)" stroke="rgba(255,255,255,0.2)" stroke-width="1"/>
                        <text x="260" y="46" fill="rgba(255,255,255,0.8)" font-size="8" font-family="Inter" text-anchor="middle">Operasional</text>
                        <text x="260" y="57" fill="rgba(255,255,255,0.8)" font-size="8" font-family="Inter" text-anchor="middle">Risk</text>

                        <circle cx="360" cy="50" r="22" fill="rgba(255,255,255,0.08)" stroke="rgba(255,255,255,0.2)" stroke-width="1"/>
                        <text x="360" y="46" fill="rgba(255,255,255,0.8)" font-size="8" font-family="Inter" text-anchor="middle">Kepatuhan</text>
                        <text x="360" y="57" fill="rgba(255,255,255,0.8)" font-size="8" font-family="Inter" text-anchor="middle">Risk</text>

                        <!-- Lines connecting nodes -->
                        <line x1="82" y1="50" x2="138" y2="50" stroke="rgba(255,255,255,0.2)" stroke-width="1" stroke-dasharray="3,3"/>
                        <line x1="182" y1="50" x2="238" y2="50" stroke="rgba(255,255,255,0.2)" stroke-width="1" stroke-dasharray="3,3"/>
                        <line x1="282" y1="50" x2="338" y2="50" stroke="rgba(255,255,255,0.2)" stroke-width="1" stroke-dasharray="3,3"/>
                    </g>

                    <!-- ISO Badge -->
                    <g transform="translate(340, 230)">
                        <rect x="0" y="0" width="70" height="28" rx="14" fill="rgba(255,255,255,0.12)" stroke="rgba(255,255,255,0.25)" stroke-width="1"/>
                        <text x="35" y="18" fill="rgba(255,255,255,0.85)" font-size="9" font-family="Inter" text-anchor="middle" font-weight="700">ISO 31000</text>
                    </g>
                </svg>

                <!-- Stats -->
                <div class="stats-row">
                    <div class="stat-chip">
                        <div class="num">ISO</div>
                        <div class="lbl">31000:2018</div>
                    </div>
                    <div class="stat-chip">
                        <div class="num">ERM</div>
                        <div class="lbl">Framework</div>
                    </div>
                    <div class="stat-chip">
                        <div class="num">5×5</div>
                        <div class="lbl">Risk Matrix</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Theme persistence
        const savedTheme = localStorage.getItem('riskguard-theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
        updateThemeUI(savedTheme);

        function toggleTheme() {
            const current = document.documentElement.getAttribute('data-theme');
            const next = current === 'light' ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('riskguard-theme', next);
            updateThemeUI(next);
        }

        function updateThemeUI(theme) {
            const icon = document.getElementById('themeIcon');
            const label = document.getElementById('themeLabel');
            if (theme === 'dark') {
                icon.className = 'fas fa-sun';
                label.textContent = 'Light';
            } else {
                icon.className = 'fas fa-moon';
                label.textContent = 'Dark';
            }
        }

        // Password toggle
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }
    </script>
</body>
</html>
