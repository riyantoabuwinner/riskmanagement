<!DOCTYPE html>
<html lang="id" id="htmlRoot">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RiskManagement — Sistem Manajemen Risiko UIN Siber Syekh Nurjati Cirebon</title>
    <meta name="description" content="Platform manajemen risiko terintegrasi berbasis ISO 31000:2018 untuk UIN Siber Syekh Nurjati Cirebon. Kelola risiko secara proaktif dengan ERM Framework.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --g1: #022c22; --g2: #064e3b; --g3: #047857;
            --g4: #059669; --g5: #10b981; --g6: #34d399;
            --accent: #6ee7b7; --gold: #f59e0b;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', sans-serif; background: #fff; color: #111827; overflow-x: hidden; }

        /* ── Navbar ── */
        .navbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            padding: 0 40px;
            height: 68px;
            display: flex; align-items: center; justify-content: space-between;
            background: rgba(2, 44, 34, 0.92);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255,255,255,0.08);
            transition: all 0.3s;
        }
        .navbar.scrolled {
            background: rgba(2, 44, 34, 0.98);
            box-shadow: 0 4px 24px rgba(0,0,0,0.3);
        }
        .nav-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .nav-logo-icon {
            width: 38px; height: 38px; border-radius: 10px;
            background: linear-gradient(135deg, var(--g5), var(--accent));
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1.1rem;
            box-shadow: 0 4px 12px rgba(16,185,129,0.4);
        }
        .nav-logo-text { font-size: 1.2rem; font-weight: 800; color: #fff; }
        .nav-logo-text span { color: var(--accent); }
        .nav-links { display: flex; align-items: center; gap: 8px; }
        .nav-link-item {
            color: rgba(255,255,255,0.8); text-decoration: none;
            padding: 8px 16px; border-radius: 8px; font-size: 0.88rem; font-weight: 500;
            transition: all 0.2s;
        }
        .nav-link-item:hover { color: #fff; background: rgba(255,255,255,0.1); }
        .nav-btn {
            padding: 9px 22px; border-radius: 10px; font-size: 0.88rem; font-weight: 700;
            text-decoration: none; transition: all 0.25s; cursor: pointer; border: none;
        }
        .nav-btn-outline {
            color: rgba(255,255,255,0.9);
            border: 1.5px solid rgba(255,255,255,0.3);
            background: transparent;
        }
        .nav-btn-outline:hover { border-color: var(--accent); color: var(--accent); }
        .nav-btn-solid {
            background: linear-gradient(135deg, var(--g5), var(--accent));
            color: #fff;
            box-shadow: 0 4px 14px rgba(16,185,129,0.4);
        }
        .nav-btn-solid:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(16,185,129,0.5); }

        /* ── Hero ── */
        .hero {
            min-height: 100vh;
            background: linear-gradient(145deg, var(--g1) 0%, var(--g2) 35%, var(--g3) 65%, #065f46 100%);
            display: flex; align-items: center; justify-content: center;
            position: relative; overflow: hidden; padding: 100px 40px 60px;
        }
        /* Decorative orbs */
        .hero::before {
            content: ''; position: absolute;
            width: 600px; height: 600px; border-radius: 50%;
            background: radial-gradient(circle, rgba(16,185,129,0.15) 0%, transparent 70%);
            top: -100px; right: -100px; pointer-events: none;
        }
        .hero::after {
            content: ''; position: absolute;
            width: 400px; height: 400px; border-radius: 50%;
            background: radial-gradient(circle, rgba(110,231,183,0.1) 0%, transparent 70%);
            bottom: -50px; left: -50px; pointer-events: none;
        }
        /* Animated grid */
        .hero-grid {
            position: absolute; inset: 0;
            background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            pointer-events: none;
        }

        .hero-content {
            position: relative; z-index: 1;
            max-width: 1200px; width: 100%;
            display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 8px;
            background: rgba(16,185,129,0.15);
            border: 1px solid rgba(110,231,183,0.3);
            border-radius: 50px; padding: 6px 16px;
            color: var(--accent); font-size: 0.8rem; font-weight: 600;
            margin-bottom: 24px;
        }
        .hero-badge i { font-size: 0.75rem; }
        .hero-title {
            font-size: 3.2rem; font-weight: 900; color: #fff;
            line-height: 1.1; margin-bottom: 20px;
        }
        .hero-title .highlight {
            background: linear-gradient(135deg, var(--accent), var(--gold));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-desc {
            font-size: 1rem; color: rgba(255,255,255,0.75);
            line-height: 1.7; margin-bottom: 36px; max-width: 480px;
        }
        .hero-cta { display: flex; gap: 14px; flex-wrap: wrap; }
        .btn-hero-primary {
            padding: 14px 32px; border-radius: 12px;
            background: linear-gradient(135deg, var(--g5), var(--accent));
            color: #fff; font-weight: 700; font-size: 0.95rem;
            text-decoration: none; border: none; cursor: pointer;
            box-shadow: 0 6px 24px rgba(16,185,129,0.4);
            transition: all 0.25s; display: flex; align-items: center; gap: 8px;
        }
        .btn-hero-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(16,185,129,0.5); }
        .btn-hero-secondary {
            padding: 14px 32px; border-radius: 12px;
            border: 1.5px solid rgba(255,255,255,0.3);
            color: rgba(255,255,255,0.9); font-weight: 600; font-size: 0.95rem;
            text-decoration: none; background: transparent;
            transition: all 0.25s; display: flex; align-items: center; gap: 8px;
        }
        .btn-hero-secondary:hover { border-color: var(--accent); color: var(--accent); background: rgba(16,185,129,0.08); }

        .hero-stats {
            display: flex; gap: 28px; margin-top: 44px; flex-wrap: wrap;
        }
        .hero-stat { text-align: left; }
        .hero-stat .num { font-size: 1.8rem; font-weight: 900; color: #fff; }
        .hero-stat .lbl { font-size: 0.78rem; color: rgba(255,255,255,0.55); margin-top: 2px; }
        .hero-stat .num span { color: var(--accent); }

        /* Hero Visual */
        .hero-visual { position: relative; }
        .hero-card-main {
            background: rgba(255,255,255,0.07);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 20px; padding: 28px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .hero-card-title {
            font-size: 0.78rem; font-weight: 700; color: rgba(255,255,255,0.5);
            text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px;
        }
        /* Mini heatmap */
        .mini-heatmap { display: grid; grid-template-columns: repeat(5,1fr); gap: 5px; margin-bottom: 20px; }
        .hm-cell {
            aspect-ratio: 1; border-radius: 5px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.65rem; font-weight: 700; color: rgba(255,255,255,0.9);
        }
        .hm-low { background: rgba(16,185,129,0.7); }
        .hm-med { background: rgba(251,191,36,0.75); }
        .hm-high { background: rgba(249,115,22,0.8); }
        .hm-ext { background: rgba(239,68,68,0.85); }
        /* Risk items */
        .risk-item {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .risk-item:last-child { border-bottom: none; }
        .risk-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
        .risk-name { font-size: 0.82rem; color: rgba(255,255,255,0.8); flex: 1; }
        .risk-badge {
            font-size: 0.68rem; font-weight: 700; padding: 3px 8px; border-radius: 20px;
        }
        /* Floating cards */
        .hero-visual {
            position: relative;
            padding: 50px 30px;
        }
        .float-card {
            position: absolute;
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.18);
            border-radius: 14px; padding: 14px 18px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.25);
            z-index: 2;
        }
        .float-card-1 { top: 10px; right: 0px; }
        .float-card-2 { bottom: 10px; left: 0px; }
        .float-num { font-size: 1.4rem; font-weight: 900; color: #fff; }
        .float-lbl { font-size: 0.7rem; color: rgba(255,255,255,0.6); }
        .float-trend { font-size: 0.72rem; color: var(--accent); font-weight: 600; margin-top: 2px; }

        /* ── Features Section ── */
        .section { padding: 90px 40px; }
        .section-center { text-align: center; max-width: 600px; margin: 0 auto 60px; }
        .section-badge {
            display: inline-block; background: #d1fae5; color: var(--g3);
            border-radius: 50px; padding: 5px 16px; font-size: 0.78rem; font-weight: 700;
            margin-bottom: 16px; letter-spacing: 0.5px;
        }
        .section-title { font-size: 2.2rem; font-weight: 800; color: #111827; margin-bottom: 14px; line-height: 1.2; }
        .section-desc { color: #6b7280; font-size: 0.95rem; line-height: 1.7; }

        .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; max-width: 1100px; margin: 0 auto; }
        .feature-card {
            background: #fff; border: 1px solid #e5e7eb; border-radius: 16px;
            padding: 28px; transition: all 0.3s;
            position: relative; overflow: hidden;
        }
        .feature-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--g5), var(--accent));
            transform: scaleX(0); transform-origin: left; transition: transform 0.3s;
        }
        .feature-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(4,120,87,0.12); border-color: #d1fae5; }
        .feature-card:hover::before { transform: scaleX(1); }
        .feature-icon {
            width: 52px; height: 52px; border-radius: 14px;
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            display: flex; align-items: center; justify-content: center;
            color: var(--g3); font-size: 1.3rem; margin-bottom: 18px;
        }
        .feature-title { font-size: 1rem; font-weight: 700; color: #111827; margin-bottom: 10px; }
        .feature-desc { font-size: 0.85rem; color: #6b7280; line-height: 1.6; }

        /* ── Process Section ── */
        .process-section {
            background: linear-gradient(145deg, var(--g1), var(--g2));
            padding: 90px 40px; position: relative; overflow: hidden;
        }
        .process-section::before {
            content: ''; position: absolute; inset: 0;
            background-image: linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 50px 50px;
        }
        .process-section .section-title { color: #fff; }
        .process-section .section-desc { color: rgba(255,255,255,0.65); }
        .process-section .section-badge { background: rgba(16,185,129,0.2); color: var(--accent); }
        .steps-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; max-width: 1100px; margin: 0 auto; position: relative; z-index: 1; }
        .step-card {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px; padding: 28px 22px; text-align: center;
            transition: all 0.3s;
        }
        .step-card:hover { background: rgba(255,255,255,0.12); transform: translateY(-4px); }
        .step-num {
            width: 44px; height: 44px; border-radius: 50%;
            background: linear-gradient(135deg, var(--g5), var(--accent));
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 800; font-size: 1rem;
            margin: 0 auto 16px;
        }
        .step-title { font-size: 0.95rem; font-weight: 700; color: #fff; margin-bottom: 10px; }
        .step-desc { font-size: 0.82rem; color: rgba(255,255,255,0.6); line-height: 1.6; }

        /* ── Stats Banner ── */
        .stats-banner {
            background: #f0fdf4; padding: 60px 40px;
            border-top: 1px solid #d1fae5; border-bottom: 1px solid #d1fae5;
        }
        .stats-row { display: flex; justify-content: center; gap: 60px; flex-wrap: wrap; max-width: 900px; margin: 0 auto; }
        .stat-item { text-align: center; }
        .stat-item .big-num { font-size: 2.8rem; font-weight: 900; color: var(--g3); line-height: 1; }
        .stat-item .big-lbl { font-size: 0.85rem; color: #6b7280; margin-top: 6px; }

        /* ── Roles Section ── */
        .roles-section { padding: 90px 40px; background: #fff; }
        .roles-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; max-width: 1000px; margin: 0 auto; }
        .role-card {
            border: 1px solid #e5e7eb; border-radius: 16px; padding: 28px;
            text-align: center; transition: all 0.3s;
        }
        .role-card:hover { border-color: var(--g5); box-shadow: 0 8px 24px rgba(4,120,87,0.1); }
        .role-icon {
            width: 60px; height: 60px; border-radius: 50%;
            background: linear-gradient(135deg, var(--g2), var(--g5));
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 1.4rem; margin: 0 auto 16px;
        }
        .role-name { font-size: 1rem; font-weight: 700; color: #111827; margin-bottom: 8px; }
        .role-desc { font-size: 0.83rem; color: #6b7280; line-height: 1.6; }
        .role-perms { margin-top: 16px; display: flex; flex-direction: column; gap: 6px; }
        .role-perm {
            display: flex; align-items: center; gap: 8px;
            font-size: 0.8rem; color: #374151;
        }
        .role-perm i { color: var(--g5); font-size: 0.75rem; }

        /* ── CTA Section ── */
        .cta-section {
            padding: 90px 40px; text-align: center;
            background: linear-gradient(145deg, var(--g2), var(--g3));
            position: relative; overflow: hidden;
        }
        .cta-section::before {
            content: ''; position: absolute; inset: 0;
            background-image: radial-gradient(circle at 30% 50%, rgba(255,255,255,0.05) 0%, transparent 60%),
                              radial-gradient(circle at 70% 50%, rgba(255,255,255,0.05) 0%, transparent 60%);
        }
        .cta-title { font-size: 2.4rem; font-weight: 900; color: #fff; margin-bottom: 16px; position: relative; z-index: 1; }
        .cta-desc { color: rgba(255,255,255,0.75); font-size: 1rem; margin-bottom: 36px; position: relative; z-index: 1; }
        .cta-btns { display: flex; gap: 16px; justify-content: center; flex-wrap: wrap; position: relative; z-index: 1; }
        .btn-cta-white {
            padding: 14px 36px; border-radius: 12px;
            background: #fff; color: var(--g2);
            font-weight: 800; font-size: 0.95rem; text-decoration: none;
            box-shadow: 0 6px 20px rgba(0,0,0,0.2); transition: all 0.25s;
            display: flex; align-items: center; gap: 8px;
        }
        .btn-cta-white:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(0,0,0,0.25); }
        .btn-cta-outline {
            padding: 14px 36px; border-radius: 12px;
            border: 2px solid rgba(255,255,255,0.4); color: #fff;
            font-weight: 700; font-size: 0.95rem; text-decoration: none;
            transition: all 0.25s; display: flex; align-items: center; gap: 8px;
        }
        .btn-cta-outline:hover { border-color: #fff; background: rgba(255,255,255,0.1); }

        /* ── Footer ── */
        footer {
            background: var(--g1); color: rgba(255,255,255,0.6);
            padding: 40px; text-align: center; font-size: 0.85rem;
        }
        footer .footer-logo { font-size: 1.2rem; font-weight: 800; color: #fff; margin-bottom: 8px; }
        footer .footer-logo span { color: var(--accent); }
        footer a { color: var(--accent); text-decoration: none; }

        /* ── Scroll animations ── */
        .fade-up { opacity: 0; transform: translateY(30px); transition: all 0.6s ease; }
        .fade-up.visible { opacity: 1; transform: translateY(0); }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .hero-content { grid-template-columns: 1fr; }
            .hero-visual { display: none; }
            .features-grid, .steps-grid, .roles-grid { grid-template-columns: 1fr; }
            .hero-title { font-size: 2.2rem; }
            .navbar { padding: 0 20px; }
            .nav-links { display: none; }
        }

        /* ── Navbar icon buttons ── */
        .navbar-icon-btn {
            background: none;
            border: 1.5px solid rgba(255,255,255,0.3);
            border-radius: 8px;
            width: 36px; height: 36px;
            display: flex; align-items: center; justify-content: center;
            color: rgba(255,255,255,0.9);
            cursor: pointer;
            transition: all 0.2s;
        }
        .navbar-icon-btn:hover {
            border-color: var(--accent);
            color: var(--accent);
            background: rgba(16,185,129,0.1);
        }
        
        .custom-dropdown { position: relative; }
        .custom-dropdown-menu {
            display: none; position: absolute; right: 0; top: 100%; margin-top: 8px;
            background: #fff; box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            border-radius: 12px; min-width: 160px; padding: 8px; z-index: 1000;
        }
        .custom-dropdown-menu.show { display: block; }
        .custom-dropdown-item {
            display: flex; align-items: center; padding: 8px 12px; border-radius: 8px;
            color: #374151; text-decoration: none; font-size: 0.9rem; transition: background 0.2s;
        }
        .custom-dropdown-item:hover { background: #f3f4f6; }
        .custom-dropdown-header { font-size: 0.75rem; color: #9ca3af; padding-bottom: 8px; text-transform: uppercase; letter-spacing: 1px; font-weight: 700; margin-left: 12px; margin-top: 4px; }

        /* ── Dark Mode ── */
        [data-theme="dark"] body { background: #0f172a; color: #e2e8f0; }
        [data-theme="dark"] .navbar {
            background: rgba(15, 23, 42, 0.92);
            border-bottom-color: rgba(255,255,255,0.05);
        }
        [data-theme="dark"] .navbar.scrolled {
            background: rgba(15, 23, 42, 0.98);
        }
        [data-theme="dark"] .section-title { color: #f8fafc; }
        [data-theme="dark"] .section-desc, [data-theme="dark"] .feature-desc, [data-theme="dark"] .role-desc { color: #94a3b8; }
        [data-theme="dark"] .feature-card, [data-theme="dark"] .role-card { background: #1e293b; border-color: #334155; }
        [data-theme="dark"] .feature-title, [data-theme="dark"] .role-name { color: #f8fafc; }
        [data-theme="dark"] .stats-banner { background: #0f172a; border-color: #334155; }
        [data-theme="dark"] .stat-item .big-lbl { color: #94a3b8; }
        [data-theme="dark"] .roles-section { background: #0f172a; }
        [data-theme="dark"] .role-perm { color: #cbd5e1; }
        [data-theme="dark"] .custom-dropdown-menu { background: #1e293b; border: 1px solid #334155; }
        [data-theme="dark"] .custom-dropdown-item { color: #cbd5e1; }
        [data-theme="dark"] .custom-dropdown-item:hover { background: #263548; }

        /* ── Google Translate Hiding ── */
        .goog-te-banner-frame.skiptranslate, .goog-te-gadget-icon { display: none !important; }
        body { top: 0px !important; }
        .goog-te-gadget { color: transparent !important; font-size: 0 !important; }
        .goog-te-gadget .goog-te-combo { display: none !important; }
        #google_translate_element { display: none !important; }
        .skiptranslate iframe { display: none !important; }
        .goog-te-menu-value { display: none !important; }
        .goog-te-menu-frame { box-shadow: 0 8px 24px rgba(0,0,0,0.12) !important; border: none !important; border-radius: 12px !important; }
    </style>
</head>
<body>
    <!-- ── Navbar ── -->
    <nav class="navbar" id="navbar">
        <a href="/" class="nav-logo">
            @php $logoPath = public_path('images/logo.png'); $logoPathJpg = public_path('images/logo.jpg'); $logoPathSvg = public_path('images/logo.svg'); @endphp
            @if(file_exists($logoPath) || file_exists($logoPathJpg) || file_exists($logoPathSvg))
                <img src="{{ asset(file_exists($logoPath) ? 'images/logo.png' : (file_exists($logoPathJpg) ? 'images/logo.jpg' : 'images/logo.svg')) }}" alt="Logo" style="width:38px;height:38px;object-fit:contain;border-radius:10px;">
            @else
                <div class="nav-logo-icon"><i class="fas fa-shield-alt"></i></div>
            @endif
            <div class="nav-logo-text">Risk<span>Management</span></div>
        </a>
        <div class="nav-links">
            <div class="custom-dropdown" id="aboutDropdown">
                <a href="javascript:void(0);" class="nav-link-item" onclick="toggleDropdown('aboutMenu')">
                    Tentang Kami <i class="fas fa-chevron-down ml-1" style="font-size:0.7rem; opacity:0.7;"></i>
                </a>
                <div class="custom-dropdown-menu" id="aboutMenu" style="left:0; right:auto;">
                    <a href="#about-app" class="custom-dropdown-item">
                        <i class="fas fa-info-circle mr-2" style="color:var(--g4);"></i> Tentang App
                    </a>
                    <a href="#workflow" class="custom-dropdown-item">
                        <i class="fas fa-project-diagram mr-2" style="color:var(--g4);"></i> Alur Kerja
                    </a>
                </div>
            </div>
            <a href="#features" class="nav-link-item">Fitur</a>
            <a href="#process" class="nav-link-item">Proses</a>
            <a href="#roles" class="nav-link-item">Peran</a>
        </div>
        <div style="display:flex;gap:10px;align-items:center;">
            <!-- Language Dropdown -->
            <div class="custom-dropdown" id="langDropdown">
                <button class="navbar-icon-btn" onclick="toggleDropdown('langMenu')" title="Pilih Bahasa" id="langBtn" style="width: auto; padding: 0 10px; gap: 6px;">
                    <i class="fas fa-language" style="font-size:1.1rem;"></i>
                    <span id="currentLangText" style="font-size: 0.85rem; font-weight: 600;">Indonesia</span>
                </button>
                <div class="custom-dropdown-menu" id="langMenu">
                    <div class="custom-dropdown-header">Pilih Bahasa</div>
                    <a href="javascript:void(0);" onclick="changeLanguage('id')" class="custom-dropdown-item">
                        <span style="font-size:1.2rem;margin-right:12px;">🇮🇩</span> Indonesia
                    </a>
                    <a href="javascript:void(0);" onclick="changeLanguage('en')" class="custom-dropdown-item">
                        <span style="font-size:1.2rem;margin-right:12px;">🇺🇸</span> English
                    </a>
                    <a href="javascript:void(0);" onclick="changeLanguage('ar')" class="custom-dropdown-item">
                        <span style="font-size:1.2rem;margin-right:12px;">🇸🇦</span> العربية (Arabic)
                    </a>
                    <div id="google_translate_element" style="display:none;"></div>
                </div>
            </div>
            <!-- Dark Mode Toggle -->
            <button class="navbar-icon-btn" onclick="toggleDarkMode()" title="Toggle Dark/Light Mode" id="themeBtn">
                <i class="fas fa-moon" id="themeIcon" style="font-size:0.85rem;"></i>
            </button>
            <!-- Fullscreen Button -->
            <button class="navbar-icon-btn" onclick="toggleFullscreen()" title="Fullscreen" id="fsBtn">
                <i class="fas fa-expand" id="fsIcon" style="font-size:0.85rem;"></i>
            </button>

            <!-- Divider -->
            <div style="width:1px; height:24px; background:rgba(255,255,255,0.2); margin:0 4px;"></div>

            @auth
                <a href="{{ route('dashboard') }}" class="nav-btn nav-btn-solid">
                    <i class="fas fa-tachometer-alt" style="margin-right:6px;"></i> Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="nav-btn nav-btn-outline">Masuk</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="nav-btn nav-btn-solid">Daftar</a>
                @endif
            @endauth
        </div>
    </nav>

    <!-- ── Hero ── -->
    <section class="hero">
        <div class="hero-grid"></div>
        <div class="hero-content">
            <!-- Left: Text -->
            <div>
                <div class="hero-badge">
                    <i class="fas fa-certificate"></i>
                    ISO 31000:2018 Compliant · ERM Framework
                </div>
                <h1 class="hero-title">
                    Kelola Risiko<br>
                    <span class="highlight">Secara Proaktif</span><br>
                    & Terstruktur
                </h1>
                <p class="hero-desc">
                    Platform manajemen risiko terintegrasi untuk UIN Siber Syekh Nurjati Cirebon.
                    Identifikasi, analisis, dan mitigasi risiko dengan visualisasi heatmap real-time
                    berbasis standar internasional ISO 31000:2018.
                </p>
                <div class="hero-cta">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-hero-primary">
                            <i class="fas fa-tachometer-alt"></i> Buka Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-hero-primary">
                            <i class="fas fa-sign-in-alt"></i> Mulai Sekarang
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-hero-secondary">
                                <i class="fas fa-user-plus"></i> Buat Akun
                            </a>
                        @endif
                    @endauth
                </div>
                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="num"><span>5</span>×<span>5</span></div>
                        <div class="lbl">Risk Matrix</div>
                    </div>
                    <div class="hero-stat">
                        <div class="num"><span>4</span></div>
                        <div class="lbl">Level Risiko</div>
                    </div>
                    <div class="hero-stat">
                        <div class="num"><span>ISO</span></div>
                        <div class="lbl">31000:2018</div>
                    </div>
                    <div class="hero-stat">
                        <div class="num"><span>ERM</span></div>
                        <div class="lbl">Framework</div>
                    </div>
                </div>
            </div>

            <!-- Right: Visual Card -->
            <div class="hero-visual">
                <!-- Float card top-right -->
                <div class="float-card float-card-1">
                    <div class="float-num">24</div>
                    <div class="float-lbl">Risiko Aktif</div>
                    <div class="float-trend"><i class="fas fa-arrow-down"></i> -12% bulan ini</div>
                </div>

                <!-- Main card -->
                <div class="hero-card-main" style="position:relative;z-index:1;">
                    <div class="hero-card-title">Risk Heatmap — Real Time</div>
                    <div class="mini-heatmap">
                        <div class="hm-cell hm-med">4</div><div class="hm-cell hm-high">8</div><div class="hm-cell hm-ext">12</div><div class="hm-cell hm-ext">16</div><div class="hm-cell hm-ext">20</div>
                        <div class="hm-cell hm-low">3</div><div class="hm-cell hm-med">6</div><div class="hm-cell hm-high">9</div><div class="hm-cell hm-ext">12</div><div class="hm-cell hm-ext">15</div>
                        <div class="hm-cell hm-low">2</div><div class="hm-cell hm-low">4</div><div class="hm-cell hm-med">6</div><div class="hm-cell hm-high">8</div><div class="hm-cell hm-ext">10</div>
                        <div class="hm-cell hm-low">1</div><div class="hm-cell hm-low">2</div><div class="hm-cell hm-low">3</div><div class="hm-cell hm-med">4</div><div class="hm-cell hm-med">5</div>
                        <div class="hm-cell hm-low" style="opacity:0.5;">—</div><div class="hm-cell hm-low">1</div><div class="hm-cell hm-low">2</div><div class="hm-cell hm-low">3</div><div class="hm-cell hm-low">4</div>
                    </div>
                    <div class="hero-card-title" style="margin-top:4px;">Risiko Terbaru</div>
                    <div class="risk-item">
                        <div class="risk-dot" style="background:#ef4444;"></div>
                        <div class="risk-name">Risiko Keamanan Siber</div>
                        <span class="risk-badge" style="background:#fef2f2;color:#ef4444;">Ekstrem</span>
                    </div>
                    <div class="risk-item">
                        <div class="risk-dot" style="background:#f97316;"></div>
                        <div class="risk-name">Risiko Keuangan BLU</div>
                        <span class="risk-badge" style="background:#fff7ed;color:#f97316;">Tinggi</span>
                    </div>
                    <div class="risk-item">
                        <div class="risk-dot" style="background:#fbbf24;"></div>
                        <div class="risk-name">Risiko Kepatuhan</div>
                        <span class="risk-badge" style="background:#fffbeb;color:#d97706;">Sedang</span>
                    </div>
                    <div class="risk-item">
                        <div class="risk-dot" style="background:#10b981;"></div>
                        <div class="risk-name">Risiko Operasional</div>
                        <span class="risk-badge" style="background:#f0fdf4;color:#059669;">Rendah</span>
                    </div>
                </div>

                <!-- Float card bottom-left -->
                <div class="float-card float-card-2">
                    <div class="float-num" style="color:var(--accent);">87%</div>
                    <div class="float-lbl">Mitigasi Selesai</div>
                    <div class="float-trend"><i class="fas fa-arrow-up"></i> +5% minggu ini</div>
                </div>
            </div>
        </div>
    </section>

    </section>
    
    <!-- ── Detailed About Section ── -->
    <section class="section" id="about-app" style="background:#f9fafb;">
        <div class="section-center fade-up">
            <div class="section-badge">TENTANG APLIKASI</div>
            <h2 class="section-title">Solusi Strategis untuk Pengendalian Risiko</h2>
            <p class="section-desc">RiskManagement App dirancang sebagai platform pusat kendali risiko untuk memastikan keberlanjutan dan akuntabilitas institusi.</p>
        </div>
        <div class="container" style="max-width:1100px; margin:0 auto;">
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:40px; align-items:center;">
                <div class="fade-up">
                    <h3 style="font-size:1.5rem; font-weight:800; color:var(--g1); margin-bottom:20px;">Identitas & Tujuan</h3>
                    <p style="color:#4b5563; line-height:1.7; margin-bottom:20px;">
                        <strong>RiskManagement UINSSC</strong> adalah sistem informasi manajemen risiko yang diintegrasikan ke dalam proses bisnis universitas untuk mengidentifikasi potensi hambatan dalam pencapaian tujuan strategis.
                    </p>
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                        <div style="background:#fff; padding:20px; border-radius:12px; border:1px solid #e5e7eb;">
                            <div style="color:var(--g4); font-weight:700; margin-bottom:8px;"><i class="fas fa-bullseye mr-2"></i> Fungsi</div>
                            <small style="color:#6b7280;">Mengautomasi pemantauan risiko dan menyederhanakan pelaporan mitigasi secara berjenjang.</small>
                        </div>
                        <div style="background:#fff; padding:20px; border-radius:12px; border:1px solid #e5e7eb;">
                            <div style="color:var(--g4); font-weight:700; margin-bottom:8px;"><i class="fas fa-rocket mr-2"></i> Manfaat</div>
                            <small style="color:#6b7280;">Meningkatkan transparansi, mempercepat pengambilan keputusan, dan melindungi aset negara.</small>
                        </div>
                    </div>
                </div>
                <div class="fade-up" style="background:linear-gradient(135deg, var(--g1), var(--g3)); padding:40px; border-radius:24px; color:#fff; position:relative; overflow:hidden;">
                    <i class="fas fa-gavel" style="position:absolute; top:-20px; right:-20px; font-size:12rem; opacity:0.05;"></i>
                    <h3 style="font-size:1.4rem; font-weight:800; margin-bottom:15px;"><i class="fas fa-balance-scale mr-2 text-accent"></i> Regulasi & Standar</h3>
                    <ul style="list-style:none; padding:0;">
                        <li style="margin-bottom:12px; display:flex; gap:12px;">
                            <i class="fas fa-check-circle text-accent" style="margin-top:4px;"></i>
                            <span><strong>ISO 31000:2018</strong> — Standar Internasional Manajemen Risiko.</span>
                        </li>
                        <li style="margin-bottom:12px; display:flex; gap:12px;">
                            <i class="fas fa-check-circle text-accent" style="margin-top:4px;"></i>
                            <span><strong>PP No. 60 Tahun 2008</strong> — Sistem Pengendalian Intern Pemerintah (SPIP).</span>
                        </li>
                        <li style="display:flex; gap:12px;">
                            <i class="fas fa-check-circle text-accent" style="margin-top:4px;"></i>
                            <span><strong>PMK No. 191/PMK.09/2008</strong> — Manajemen Risiko di Lingkungan Kementerian Keuangan/BLU.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ── Detailed Workflow Section ── -->
    <section class="section" id="workflow">
        <div class="section-center fade-up">
            <div class="section-badge">ALUR KERJA ROLE</div>
            <h2 class="section-title">Bagaimana Kami Bekerja Bersama?</h2>
            <p class="section-desc">Setiap peran memiliki kontribusi krusial dalam rantai manajemen risiko untuk memastikan ekosistem yang aman.</p>
        </div>
        <div class="container" style="max-width:1100px; margin:0 auto;">
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px, 1fr)); gap:24px;">
                <!-- Workflow Card 1 -->
                <div class="feature-card fade-up" style="border-top:4px solid var(--gold);">
                    <div class="feature-title"><i class="fas fa-user-edit mr-2 text-warning"></i> Risk Owner</div>
                    <p style="font-size:0.75rem; color:#6b7280; margin-bottom:15px;">Input data primer risiko dari unit kerja masing-masing.</p>
                    <div style="font-size:0.8rem; border-left:2px solid #fde68a; padding-left:12px;">
                        <div style="margin-bottom:8px;">1. Identifikasi Risiko Baru</div>
                        <div style="margin-bottom:8px;">2. Update Progress Mitigasi</div>
                        <div>3. Lihat Laporan Unit</div>
                    </div>
                </div>
                <!-- Workflow Card 2 -->
                <div class="feature-card fade-up" style="border-top:4px solid var(--g4);">
                    <div class="feature-title"><i class="fas fa-microscope mr-2 text-success"></i> Risk Officer</div>
                    <p style="font-size:0.75rem; color:#6b7280; margin-bottom:15px;">Melakukan verifikasi teknis dan analisis mendalam.</p>
                    <div style="font-size:0.8rem; border-left:2px solid #a7f3d0; padding-left:12px;">
                        <div style="margin-bottom:8px;">1. Analisis Likelihood & Impact</div>
                        <div style="margin-bottom:8px;">2. Verifikasi Rencana Mitigasi</div>
                        <div>3. Evaluasi Keefektifan Kontrol</div>
                    </div>
                </div>
                <!-- Workflow Card 3 -->
                <div class="feature-card fade-up" style="border-top:4px solid var(--g2);">
                    <div class="feature-title"><i class="fas fa-user-shield mr-2 text-primary"></i> Risk Manager</div>
                    <p style="font-size:0.75rem; color:#6b7280; margin-bottom:15px;">Validasi akhir dan pelaporan ke pimpinan universitas.</p>
                    <div style="font-size:0.8rem; border-left:2px solid #6ee7b7; padding-left:12px;">
                        <div style="margin-bottom:8px;">1. Approval Analisis Risiko</div>
                        <div style="margin-bottom:8px;">2. Penetapan Prioritas Mitigasi</div>
                        <div>3. Generate Laporan Eksekutif</div>
                    </div>
                </div>
                <!-- Workflow Card 4 -->
                <div class="feature-card fade-up" style="border-top:4px solid #1e293b;">
                    <div class="feature-title"><i class="fas fa-tools mr-2 text-dark"></i> Super Admin</div>
                    <p style="font-size:0.75rem; color:#6b7280; margin-bottom:15px;">Penjaga stabilitas infrastruktur dan data sistem.</p>
                    <div style="font-size:0.8rem; border-left:2px solid #cbd5e1; padding-left:12px;">
                        <div style="margin-bottom:8px;">1. Manajemen User & Hak Akses</div>
                        <div style="margin-bottom:8px;">2. Konfigurasi Master Data</div>
                        <div>3. Backup & Audit Keamanan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── Stats ── -->
    <div class="stats-banner">
        <div class="stats-row">
            <div class="stat-item fade-up">
                <div class="big-num">ISO</div>
                <div class="big-lbl">31000:2018 Standard</div>
            </div>
            <div class="stat-item fade-up">
                <div class="big-num">5×5</div>
                <div class="big-lbl">Risk Matrix</div>
            </div>
            <div class="stat-item fade-up">
                <div class="big-num">4</div>
                <div class="big-lbl">Kategori Risiko</div>
            </div>
            <div class="stat-item fade-up">
                <div class="big-num">ERM</div>
                <div class="big-lbl">Enterprise Risk Mgmt</div>
            </div>
        </div>
    </div>

    <!-- ── Process ── -->
    <section class="process-section" id="process">
        <div class="section-center fade-up">
            <div class="section-badge">ALUR KERJA</div>
            <h2 class="section-title">Siklus ERM yang Terstruktur</h2>
            <p class="section-desc" style="color:rgba(255,255,255,0.65);">Mengikuti siklus manajemen risiko ISO 31000:2018 yang komprehensif dan terstandarisasi.</p>
        </div>
        <div class="steps-grid">
            <div class="step-card fade-up">
                <div class="step-num">1</div>
                <div class="step-title">Identifikasi Risiko</div>
                <div class="step-desc">Risk Owner mengidentifikasi dan mendaftarkan risiko berdasarkan konteks unit kerja masing-masing.</div>
            </div>
            <div class="step-card fade-up">
                <div class="step-num">2</div>
                <div class="step-title">Analisis & Evaluasi</div>
                <div class="step-desc">Risk Officer menganalisis likelihood dan impact, menentukan risk level pada matriks 5×5.</div>
            </div>
            <div class="step-card fade-up">
                <div class="step-num">3</div>
                <div class="step-title">Rencana Mitigasi</div>
                <div class="step-desc">Tim menyusun rencana mitigasi terstruktur dengan target, timeline, dan penanggung jawab yang jelas.</div>
            </div>
            <div class="step-card fade-up">
                <div class="step-num">4</div>
                <div class="step-title">Monitoring & Review</div>
                <div class="step-desc">Risk Manager memantau implementasi mitigasi dan melaporkan perkembangan kepada manajemen.</div>
            </div>
        </div>
    </section>

    <!-- ── Roles ── -->
    <section class="roles-section" id="roles">
        <div class="section-center fade-up">
            <div class="section-badge">PERAN PENGGUNA</div>
            <h2 class="section-title">Struktur Peran yang Jelas</h2>
            <p class="section-desc">Setiap pengguna memiliki peran dan tanggung jawab yang terdefinisi dengan baik dalam ekosistem manajemen risiko.</p>
        </div>
        <div class="roles-grid">
            <div class="role-card fade-up">
                <div class="role-icon"><i class="fas fa-crown"></i></div>
                <div class="role-name">Risk Manager</div>
                <div class="role-desc">Memimpin proses manajemen risiko institusi dan bertanggung jawab kepada pimpinan.</div>
                <div class="role-perms">
                    <div class="role-perm"><i class="fas fa-check"></i> Akses semua modul</div>
                    <div class="role-perm"><i class="fas fa-check"></i> Approve evaluasi risiko</div>
                    <div class="role-perm"><i class="fas fa-check"></i> Generate laporan eksekutif</div>
                </div>
            </div>
            <div class="role-card fade-up">
                <div class="role-icon"><i class="fas fa-user-tie"></i></div>
                <div class="role-name">Risk Officer</div>
                <div class="role-desc">Melakukan analisis dan evaluasi risiko, serta mengkoordinasikan proses mitigasi.</div>
                <div class="role-perms">
                    <div class="role-perm"><i class="fas fa-check"></i> Analisis & evaluasi risiko</div>
                    <div class="role-perm"><i class="fas fa-check"></i> Kelola rencana mitigasi</div>
                    <div class="role-perm"><i class="fas fa-check"></i> Monitor progress mitigasi</div>
                </div>
            </div>
            <div class="role-card fade-up">
                <div class="role-icon"><i class="fas fa-user"></i></div>
                <div class="role-name">Risk Owner</div>
                <div class="role-desc">Pemilik risiko di unit kerja yang bertanggung jawab mengidentifikasi dan melaporkan risiko.</div>
                <div class="role-perms">
                    <div class="role-perm"><i class="fas fa-check"></i> Input risiko unit kerja</div>
                    <div class="role-perm"><i class="fas fa-check"></i> Update status mitigasi</div>
                    <div class="role-perm"><i class="fas fa-check"></i> Lihat dashboard unit</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── CTA ── -->
    <section class="cta-section">
        <h2 class="cta-title">Siap Memulai?</h2>
        <p class="cta-desc">Bergabunglah dan kelola risiko institusi Anda secara lebih proaktif dan terstruktur.</p>
        <div class="cta-btns">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-cta-white">
                    <i class="fas fa-tachometer-alt"></i> Buka Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn-cta-white">
                    <i class="fas fa-sign-in-alt"></i> Masuk Sekarang
                </a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-cta-outline">
                        <i class="fas fa-user-plus"></i> Buat Akun Baru
                    </a>
                @endif
            @endauth
        </div>
    </section>

    <!-- ── Footer ── -->
    <footer>
        <div class="footer-logo">Risk<span>Management</span></div>
        <p>Sistem Manajemen Risiko — PUSTIKOM UIN Siber Syekh Nurjati Cirebon</p>
        <p style="margin-top:8px;">&copy; {{ date('Y') }} · Berbasis <a href="#">ISO 31000:2018</a> · ERM Framework</p>
    </footer>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', () => {
            document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 50);
        });

        // Fade-up animations
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    setTimeout(() => entry.target.classList.add('visible'), i * 80);
                }
            });
        }, { threshold: 0.1 });
        document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));

        // Setup dropdown toggle
        function toggleDropdown(id) {
            const menu = document.getElementById(id);
            menu.classList.toggle('show');
        }
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.custom-dropdown')) {
                document.querySelectorAll('.custom-dropdown-menu').forEach(menu => menu.classList.remove('show'));
            }
        });

        // ── Dark Mode ──
        (function() {
            const saved = localStorage.getItem('riskguard-theme') || 'light';
            document.getElementById('htmlRoot').setAttribute('data-theme', saved);
            updateThemeIcon(saved);
        })();

        function toggleDarkMode() {
            const html = document.getElementById('htmlRoot');
            const current = html.getAttribute('data-theme') || 'light';
            const next = current === 'light' ? 'dark' : 'light';
            html.setAttribute('data-theme', next);
            localStorage.setItem('riskguard-theme', next);
            updateThemeIcon(next);
        }

        function updateThemeIcon(theme) {
            const icon = document.getElementById('themeIcon');
            const btn = document.getElementById('themeBtn');
            if (!icon) return;
            if (theme === 'dark') {
                icon.className = 'fas fa-sun';
                icon.style.color = '#fbbf24';
                if (btn) btn.title = 'Switch to Light Mode';
            } else {
                icon.className = 'fas fa-moon';
                icon.style.color = '';
                if (btn) btn.title = 'Switch to Dark Mode';
            }
        }

        // ── Fullscreen ──
        function toggleFullscreen() {
            const icon = document.getElementById('fsIcon');
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().then(() => {
                    if (icon) icon.className = 'fas fa-compress';
                }).catch(() => {});
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen().then(() => {
                        if (icon) icon.className = 'fas fa-expand';
                    }).catch(() => {});
                }
            }
        }

        document.addEventListener('fullscreenchange', function() {
            const icon = document.getElementById('fsIcon');
            if (!icon) return;
            icon.className = document.fullscreenElement ? 'fas fa-compress' : 'fas fa-expand';
        });

        // ── Google Translate ──
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'id',
                includedLanguages: 'id,en,ar',
                autoDisplay: false
            }, 'google_translate_element');
        }

        function changeLanguage(langCode) {
            let select = document.querySelector('.goog-te-combo');
            let textMap = { 'id': 'Indonesia', 'en': 'Inggris', 'ar': 'Arab' };
            let langName = textMap[langCode] || langCode.toUpperCase();

            if (select) {
                select.value = langCode;
                select.dispatchEvent(new Event('change'));
                
                let currentLangText = document.getElementById('currentLangText');
                if (currentLangText) currentLangText.innerText = langName;
                
                document.querySelectorAll('.custom-dropdown-menu').forEach(menu => menu.classList.remove('show'));
            } else {
                setTimeout(() => {
                    let innerSelect = document.querySelector('.goog-te-combo');
                    if (innerSelect) {
                        innerSelect.value = langCode;
                        innerSelect.dispatchEvent(new Event('change'));
                        
                        let innerLangText = document.getElementById('currentLangText');
                        if (innerLangText) innerLangText.innerText = langName;
                        
                        document.querySelectorAll('.custom-dropdown-menu').forEach(menu => menu.classList.remove('show'));
                    }
                }, 1000);
            }
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    @include('partials.accessibility')
</body>
</html>
