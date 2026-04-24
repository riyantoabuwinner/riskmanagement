<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — RiskManagement</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --g1: #022c22; --g2: #064e3b; --g3: #047857;
            --g4: #059669; --g5: #10b981; --g6: #34d399;
            --accent: #6ee7b7;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #f0fdf4;
        }

        /* ── Left Panel (Illustration) ── */
        .left-panel {
            width: 45%;
            background: linear-gradient(145deg, var(--g1) 0%, var(--g2) 40%, var(--g3) 80%, #065f46 100%);
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 60px 50px;
            position: relative; overflow: hidden;
        }
        .left-panel::before {
            content: ''; position: absolute; inset: 0;
            background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 50px 50px;
        }
        .left-orb-1 {
            position: absolute; width: 350px; height: 350px; border-radius: 50%;
            background: radial-gradient(circle, rgba(16,185,129,0.2) 0%, transparent 70%);
            top: -80px; right: -80px; pointer-events: none;
        }
        .left-orb-2 {
            position: absolute; width: 250px; height: 250px; border-radius: 50%;
            background: radial-gradient(circle, rgba(110,231,183,0.15) 0%, transparent 70%);
            bottom: -50px; left: -50px; pointer-events: none;
        }
        .left-content { position: relative; z-index: 1; text-align: center; }
        .left-logo {
            display: flex; align-items: center; gap: 12px;
            justify-content: center; margin-bottom: 48px;
        }
        .left-logo-icon {
            width: 44px; height: 44px; border-radius: 12px;
            background: linear-gradient(135deg, var(--g5), var(--accent));
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1.2rem;
            box-shadow: 0 4px 16px rgba(16,185,129,0.4);
        }
        .left-logo-text { font-size: 1.4rem; font-weight: 800; color: #fff; }
        .left-logo-text span { color: var(--accent); }

        /* SVG Illustration area */
        .left-illustration { margin-bottom: 36px; }
        .left-title { font-size: 1.6rem; font-weight: 800; color: #fff; margin-bottom: 12px; line-height: 1.3; }
        .left-desc { font-size: 0.88rem; color: rgba(255,255,255,0.65); line-height: 1.7; max-width: 320px; }

        /* Feature pills */
        .feature-pills { display: flex; flex-direction: column; gap: 10px; margin-top: 32px; }
        .pill {
            display: flex; align-items: center; gap: 10px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 50px; padding: 8px 16px;
            color: rgba(255,255,255,0.85); font-size: 0.82rem;
        }
        .pill i { color: var(--accent); font-size: 0.8rem; }

        /* ── Right Panel (Form) ── */
        .right-panel {
            flex: 1;
            display: flex; align-items: center; justify-content: center;
            padding: 40px 50px;
            overflow-y: auto;
        }
        .form-container { width: 100%; max-width: 440px; }

        .form-header { margin-bottom: 32px; }
        .form-title { font-size: 1.8rem; font-weight: 800; color: #111827; margin-bottom: 6px; }
        .form-subtitle { font-size: 0.88rem; color: #6b7280; }

        /* Steps indicator */
        .steps-bar {
            display: flex; align-items: center; gap: 0;
            margin-bottom: 28px;
        }
        .step-dot {
            width: 28px; height: 28px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.72rem; font-weight: 700;
            transition: all 0.3s;
        }
        .step-dot.active { background: linear-gradient(135deg, var(--g5), var(--accent)); color: #fff; }
        .step-dot.done { background: #d1fae5; color: var(--g3); }
        .step-dot.pending { background: #f3f4f6; color: #9ca3af; }
        .step-line { flex: 1; height: 2px; background: #e5e7eb; margin: 0 4px; }
        .step-line.done { background: linear-gradient(90deg, var(--g5), var(--accent)); }
        .step-label { font-size: 0.68rem; color: #9ca3af; margin-top: 4px; text-align: center; }

        /* Form groups */
        .form-group { margin-bottom: 18px; }
        .form-label {
            display: block; font-size: 0.82rem; font-weight: 600;
            color: #374151; margin-bottom: 6px;
        }
        .form-label span { color: #ef4444; margin-left: 2px; }
        .input-wrapper { position: relative; }
        .input-icon {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: #9ca3af; font-size: 0.9rem; pointer-events: none;
            transition: color 0.2s;
        }
        .form-input {
            width: 100%; padding: 11px 14px 11px 40px;
            border: 1.5px solid #e5e7eb; border-radius: 10px;
            font-size: 0.88rem; font-family: 'Inter', sans-serif;
            color: #111827; background: #fff;
            transition: all 0.2s; outline: none;
        }
        .form-input:focus { border-color: var(--g5); box-shadow: 0 0 0 3px rgba(16,185,129,0.12); }
        .form-input:focus + .input-icon,
        .input-wrapper:focus-within .input-icon { color: var(--g5); }
        .form-input.error { border-color: #ef4444; }
        .form-input.success { border-color: var(--g5); }
        .input-toggle {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            color: #9ca3af; cursor: pointer; font-size: 0.9rem;
            transition: color 0.2s; background: none; border: none; padding: 4px;
        }
        .input-toggle:hover { color: var(--g5); }
        .form-error { font-size: 0.78rem; color: #ef4444; margin-top: 5px; display: flex; align-items: center; gap: 4px; }

        /* Password strength */
        .pw-strength { margin-top: 8px; }
        .pw-bars { display: flex; gap: 4px; margin-bottom: 4px; }
        .pw-bar { flex: 1; height: 3px; border-radius: 2px; background: #e5e7eb; transition: background 0.3s; }
        .pw-bar.weak { background: #ef4444; }
        .pw-bar.fair { background: #f59e0b; }
        .pw-bar.good { background: var(--g5); }
        .pw-bar.strong { background: var(--g3); }
        .pw-label { font-size: 0.72rem; color: #9ca3af; }

        /* Honeypot - hidden from humans */
        .hp-field { position: absolute; left: -9999px; top: -9999px; opacity: 0; pointer-events: none; }

        /* Terms */
        .terms-check {
            display: flex; align-items: flex-start; gap: 10px;
            margin-bottom: 20px;
        }
        .terms-check input[type="checkbox"] {
            width: 16px; height: 16px; margin-top: 2px; flex-shrink: 0;
            accent-color: var(--g5); cursor: pointer;
        }
        .terms-check label { font-size: 0.8rem; color: #6b7280; line-height: 1.5; cursor: pointer; }
        .terms-check a { color: var(--g3); text-decoration: none; font-weight: 600; }
        .terms-check a:hover { text-decoration: underline; }

        /* Submit button */
        .btn-submit {
            width: 100%; padding: 13px;
            background: linear-gradient(135deg, var(--g4), var(--g5));
            color: #fff; font-weight: 700; font-size: 0.95rem;
            border: none; border-radius: 12px; cursor: pointer;
            box-shadow: 0 4px 16px rgba(5,150,105,0.35);
            transition: all 0.25s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-submit:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(5,150,105,0.45); }
        .btn-submit:active { transform: translateY(0); }
        .btn-submit:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

        /* Login link */
        .login-link {
            text-align: center; margin-top: 20px;
            font-size: 0.85rem; color: #6b7280;
        }
        .login-link a { color: var(--g3); font-weight: 700; text-decoration: none; }
        .login-link a:hover { text-decoration: underline; }

        /* Alert */
        .alert {
            padding: 12px 16px; border-radius: 10px; margin-bottom: 20px;
            font-size: 0.83rem; display: flex; align-items: flex-start; gap: 10px;
        }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }
        .alert i { margin-top: 1px; flex-shrink: 0; }

        /* Responsive */
        @media (max-width: 768px) {
            .left-panel { display: none; }
            .right-panel { padding: 30px 24px; }
        }
    </style>
</head>
<body>
    <!-- Left Panel -->
    <div class="left-panel">
        <div class="left-orb-1"></div>
        <div class="left-orb-2"></div>
        <div class="left-content">
            <div class="left-logo">
                @php $lp = public_path('images/logo.png'); $lj = public_path('images/logo.jpg'); $ls = public_path('images/logo.svg'); @endphp
                @if(file_exists($lp) || file_exists($lj) || file_exists($ls))
                    <img src="{{ asset(file_exists($lp) ? 'images/logo.png' : (file_exists($lj) ? 'images/logo.jpg' : 'images/logo.svg')) }}" alt="Logo" style="width:44px;height:44px;object-fit:contain;border-radius:12px;">
                @else
                    <div class="left-logo-icon"><i class="fas fa-shield-alt"></i></div>
                @endif
                <div class="left-logo-text">Risk<span>Management</span></div>
            </div>

            <!-- SVG Illustration -->
            <div class="left-illustration">
                <svg width="260" height="200" viewBox="0 0 260 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <!-- Background card -->
                    <rect x="20" y="20" width="220" height="160" rx="16" fill="rgba(255,255,255,0.06)" stroke="rgba(255,255,255,0.12)" stroke-width="1"/>
                    <!-- Mini heatmap grid -->
                    <g transform="translate(35, 35)">
                        <!-- Row 5 (top) -->
                        <rect x="0"  y="0"  width="22" height="22" rx="4" fill="#fbbf24" opacity="0.8"/>
                        <rect x="26" y="0"  width="22" height="22" rx="4" fill="#f97316" opacity="0.85"/>
                        <rect x="52" y="0"  width="22" height="22" rx="4" fill="#ef4444" opacity="0.9"/>
                        <rect x="78" y="0"  width="22" height="22" rx="4" fill="#ef4444" opacity="0.9"/>
                        <rect x="104" y="0" width="22" height="22" rx="4" fill="#ef4444" opacity="0.9"/>
                        <!-- Row 4 -->
                        <rect x="0"  y="26" width="22" height="22" rx="4" fill="#10b981" opacity="0.7"/>
                        <rect x="26" y="26" width="22" height="22" rx="4" fill="#fbbf24" opacity="0.8"/>
                        <rect x="52" y="26" width="22" height="22" rx="4" fill="#f97316" opacity="0.85"/>
                        <rect x="78" y="26" width="22" height="22" rx="4" fill="#ef4444" opacity="0.9"/>
                        <rect x="104" y="26" width="22" height="22" rx="4" fill="#ef4444" opacity="0.9"/>
                        <!-- Row 3 -->
                        <rect x="0"  y="52" width="22" height="22" rx="4" fill="#10b981" opacity="0.7"/>
                        <rect x="26" y="52" width="22" height="22" rx="4" fill="#10b981" opacity="0.7"/>
                        <rect x="52" y="52" width="22" height="22" rx="4" fill="#fbbf24" opacity="0.8"/>
                        <rect x="78" y="52" width="22" height="22" rx="4" fill="#f97316" opacity="0.85"/>
                        <rect x="104" y="52" width="22" height="22" rx="4" fill="#ef4444" opacity="0.9"/>
                        <!-- Row 2 -->
                        <rect x="0"  y="78" width="22" height="22" rx="4" fill="#10b981" opacity="0.6"/>
                        <rect x="26" y="78" width="22" height="22" rx="4" fill="#10b981" opacity="0.6"/>
                        <rect x="52" y="78" width="22" height="22" rx="4" fill="#10b981" opacity="0.7"/>
                        <rect x="78" y="78" width="22" height="22" rx="4" fill="#fbbf24" opacity="0.8"/>
                        <rect x="104" y="78" width="22" height="22" rx="4" fill="#f97316" opacity="0.85"/>
                        <!-- Row 1 -->
                        <rect x="0"  y="104" width="22" height="22" rx="4" fill="#10b981" opacity="0.5"/>
                        <rect x="26" y="104" width="22" height="22" rx="4" fill="#10b981" opacity="0.5"/>
                        <rect x="52" y="104" width="22" height="22" rx="4" fill="#10b981" opacity="0.6"/>
                        <rect x="78" y="104" width="22" height="22" rx="4" fill="#10b981" opacity="0.6"/>
                        <rect x="104" y="104" width="22" height="22" rx="4" fill="#fbbf24" opacity="0.7"/>
                    </g>
                    <!-- Shield icon on right -->
                    <g transform="translate(170, 40)">
                        <circle cx="30" cy="30" r="28" fill="rgba(16,185,129,0.2)" stroke="rgba(110,231,183,0.4)" stroke-width="1.5"/>
                        <path d="M30 10 L46 17 L46 30 C46 39 38 46 30 50 C22 46 14 39 14 30 L14 17 Z" fill="rgba(16,185,129,0.5)" stroke="rgba(110,231,183,0.6)" stroke-width="1.5"/>
                        <path d="M23 30 L28 35 L37 25" stroke="#6ee7b7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                    <!-- Bar chart bottom right -->
                    <g transform="translate(170, 110)">
                        <rect x="0"  y="30" width="10" height="20" rx="3" fill="rgba(16,185,129,0.6)"/>
                        <rect x="14" y="20" width="10" height="30" rx="3" fill="rgba(16,185,129,0.7)"/>
                        <rect x="28" y="10" width="10" height="40" rx="3" fill="rgba(16,185,129,0.8)"/>
                        <rect x="42" y="15" width="10" height="35" rx="3" fill="rgba(251,191,36,0.7)"/>
                        <rect x="56" y="5"  width="10" height="45" rx="3" fill="rgba(16,185,129,0.9)"/>
                    </g>
                    <!-- Animated dot -->
                    <circle cx="130" cy="100" r="4" fill="#6ee7b7" opacity="0.8">
                        <animate attributeName="r" values="4;6;4" dur="2s" repeatCount="indefinite"/>
                        <animate attributeName="opacity" values="0.8;0.4;0.8" dur="2s" repeatCount="indefinite"/>
                    </circle>
                </svg>
            </div>

            <h2 class="left-title">Bergabung dengan<br>Platform ERM Kami</h2>
            <p class="left-desc">Daftarkan akun Anda dan mulai kelola risiko institusi secara proaktif berbasis ISO 31000:2018.</p>

            <div class="feature-pills">
                <div class="pill"><i class="fas fa-shield-alt"></i> Keamanan data terjamin</div>
                <div class="pill"><i class="fas fa-th"></i> Risk Heatmap 5×5 real-time</div>
                <div class="pill"><i class="fas fa-users-cog"></i> Multi-role access control</div>
            </div>
        </div>
    </div>

    <!-- Right Panel (Form) -->
    <div class="right-panel">
        <div class="form-container">
            <div class="form-header">
                <h1 class="form-title">Buat Akun Baru</h1>
                <p class="form-subtitle">Isi data di bawah untuk mendaftar ke sistem RiskManagement</p>
            </div>

            {{-- Error messages --}}
            @if ($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="registerForm" novalidate>
                @csrf

                {{-- ── HONEYPOT FIELDS (anti-bot) ── --}}
                {{-- Bots akan mengisi field ini, manusia tidak akan melihatnya --}}
                <div class="hp-field" aria-hidden="true" tabindex="-1">
                    <label for="website">Website (leave blank)</label>
                    <input type="text" id="website" name="website" value="" tabindex="-1" autocomplete="off">
                    <label for="phone_number">Phone (leave blank)</label>
                    <input type="text" id="phone_number" name="phone_number" value="" tabindex="-1" autocomplete="off">
                </div>

                {{-- Timestamp anti-bot: form harus diisi minimal 3 detik --}}
                <input type="hidden" name="form_timestamp" id="form_timestamp" value="{{ time() }}">

                <!-- Nama Lengkap -->
                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap <span>*</span></label>
                    <div class="input-wrapper">
                        <input
                            type="text" id="name" name="name"
                            class="form-input {{ $errors->has('name') ? 'error' : '' }}"
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap Anda"
                            required autocomplete="name" autofocus
                        >
                        <i class="fas fa-user input-icon"></i>
                    </div>
                    @error('name')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label class="form-label" for="email">Alamat Email <span>*</span></label>
                    <div class="input-wrapper">
                        <input
                            type="email" id="email" name="email"
                            class="form-input {{ $errors->has('email') ? 'error' : '' }}"
                            value="{{ old('email') }}"
                            placeholder="nama@uinsc.ac.id"
                            required autocomplete="username"
                        >
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                    @error('email')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label class="form-label" for="password">Password <span>*</span></label>
                    <div class="input-wrapper">
                        <input
                            type="password" id="password" name="password"
                            class="form-input {{ $errors->has('password') ? 'error' : '' }}"
                            placeholder="Minimal 8 karakter"
                            required autocomplete="new-password"
                            oninput="checkPasswordStrength(this.value)"
                        >
                        <i class="fas fa-lock input-icon"></i>
                        <button type="button" class="input-toggle" onclick="togglePassword('password', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <!-- Password strength indicator -->
                    <div class="pw-strength" id="pwStrength" style="display:none;">
                        <div class="pw-bars">
                            <div class="pw-bar" id="bar1"></div>
                            <div class="pw-bar" id="bar2"></div>
                            <div class="pw-bar" id="bar3"></div>
                            <div class="pw-bar" id="bar4"></div>
                        </div>
                        <div class="pw-label" id="pwLabel">Kekuatan password</div>
                    </div>
                    @error('password')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password <span>*</span></label>
                    <div class="input-wrapper">
                        <input
                            type="password" id="password_confirmation" name="password_confirmation"
                            class="form-input {{ $errors->has('password_confirmation') ? 'error' : '' }}"
                            placeholder="Ulangi password Anda"
                            required autocomplete="new-password"
                            oninput="checkPasswordMatch()"
                        >
                        <i class="fas fa-lock input-icon"></i>
                        <button type="button" class="input-toggle" onclick="togglePassword('password_confirmation', this)">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <div class="form-error" id="matchError" style="display:none;">
                        <i class="fas fa-exclamation-circle"></i> Password tidak cocok
                    </div>
                    @error('password_confirmation')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>

                <!-- Terms -->
                <div class="terms-check">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">
                        Saya menyetujui <a href="#">Syarat & Ketentuan</a> dan
                        <a href="#">Kebijakan Privasi</a> sistem RiskManagement UIN Siber Syekh Nurjati Cirebon.
                    </label>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="fas fa-user-plus"></i>
                    Buat Akun Sekarang
                </button>

                <div class="login-link">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // ── Toggle password visibility ──
        function togglePassword(fieldId, btn) {
            const input = document.getElementById(fieldId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'fas fa-eye-slash';
            } else {
                input.type = 'password';
                icon.className = 'fas fa-eye';
            }
        }

        // ── Password strength checker ──
        function checkPasswordStrength(val) {
            const strength = document.getElementById('pwStrength');
            const label = document.getElementById('pwLabel');
            const bars = [document.getElementById('bar1'), document.getElementById('bar2'),
                          document.getElementById('bar3'), document.getElementById('bar4')];

            if (!val) { strength.style.display = 'none'; return; }
            strength.style.display = 'block';

            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const levels = ['weak', 'fair', 'good', 'strong'];
            const labels = ['Lemah', 'Cukup', 'Baik', 'Kuat'];
            bars.forEach((b, i) => {
                b.className = 'pw-bar';
                if (i < score) b.classList.add(levels[score - 1]);
            });
            label.textContent = 'Kekuatan: ' + (labels[score - 1] || 'Lemah');
            label.style.color = score <= 1 ? '#ef4444' : score === 2 ? '#f59e0b' : '#10b981';
        }

        // ── Password match checker ──
        function checkPasswordMatch() {
            const pw = document.getElementById('password').value;
            const conf = document.getElementById('password_confirmation').value;
            const err = document.getElementById('matchError');
            const confInput = document.getElementById('password_confirmation');
            if (conf && pw !== conf) {
                err.style.display = 'flex';
                confInput.classList.add('error');
                confInput.classList.remove('success');
            } else if (conf && pw === conf) {
                err.style.display = 'none';
                confInput.classList.remove('error');
                confInput.classList.add('success');
            } else {
                err.style.display = 'none';
            }
        }

        // ── Anti-bot: update timestamp on first interaction ──
        let interacted = false;
        document.getElementById('registerForm').addEventListener('input', function() {
            if (!interacted) {
                interacted = true;
                // Update timestamp to current time when user starts typing
                document.getElementById('form_timestamp').value = Math.floor(Date.now() / 1000);
            }
        }, { once: true });

        // ── Form submit validation ──
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const terms = document.getElementById('terms');
            if (!terms.checked) {
                e.preventDefault();
                alert('Anda harus menyetujui Syarat & Ketentuan terlebih dahulu.');
                return;
            }
            const pw = document.getElementById('password').value;
            const conf = document.getElementById('password_confirmation').value;
            if (pw !== conf) {
                e.preventDefault();
                document.getElementById('matchError').style.display = 'flex';
                return;
            }
            // Disable button to prevent double submit
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        });
    </script>

    <!-- Accessibility Widget -->
    @include('partials.accessibility')
</body>
</html>
