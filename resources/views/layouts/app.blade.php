<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="htmlRoot">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Risk Management') }} | @yield('title', 'Dashboard')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/png">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

    <style>
        :root {
            --green-dark:   #064e3b;
            --green-mid:    #065f46;
            --green-main:   #047857;
            --green-light:  #059669;
            --green-bright: #10b981;
            --green-pale:   #d1fae5;
            --accent:       #34d399;
        }

        * { font-family: 'Inter', sans-serif; }

        /* ── Sidebar ── */
        .main-sidebar {
            background: linear-gradient(180deg, var(--green-dark) 0%, var(--green-mid) 40%, var(--green-main) 100%) !important;
            box-shadow: 4px 0 20px rgba(0,0,0,0.25);
        }
        .brand-link {
            background: linear-gradient(135deg, var(--green-dark), var(--green-main)) !important;
            border-bottom: 1px solid rgba(255,255,255,0.1) !important;
            padding: 16px 20px !important;
        }
        .brand-text {
            font-weight: 800 !important;
            font-size: 1.1rem !important;
            letter-spacing: 0.5px;
            color: #fff !important;
        }
        .brand-text span { color: var(--accent) !important; }

        /* Sidebar user panel */
        .sidebar .user-panel {
            border-bottom: 1px solid rgba(255,255,255,0.1) !important;
            padding: 16px 12px !important;
        }
        .sidebar .user-panel .info a {
            color: #fff !important;
            font-weight: 600;
        }
        .sidebar .user-panel .info small { color: var(--accent) !important; }

        /* Nav items */
        .nav-sidebar .nav-item > .nav-link {
            color: rgba(255,255,255,0.8) !important;
            border-radius: 8px !important;
            margin: 2px 8px !important;
            padding: 10px 14px !important;
            transition: all 0.2s ease !important;
        }
        .nav-sidebar .nav-item > .nav-link:hover {
            background: rgba(255,255,255,0.12) !important;
            color: #fff !important;
            transform: translateX(3px);
        }
        .nav-sidebar .nav-item > .nav-link.active {
            background: linear-gradient(135deg, var(--green-bright), var(--accent)) !important;
            color: #fff !important;
            box-shadow: 0 4px 12px rgba(16,185,129,0.4) !important;
        }
        .nav-sidebar .nav-item > .nav-link .nav-icon {
            color: var(--accent) !important;
            width: 20px;
        }
        .nav-sidebar .nav-item > .nav-link.active .nav-icon { color: #fff !important; }

        /* Section headers */
        .nav-sidebar .nav-header {
            color: rgba(255,255,255,0.4) !important;
            font-size: 0.65rem !important;
            font-weight: 700 !important;
            letter-spacing: 1.5px !important;
            padding: 12px 20px 4px !important;
        }

        /* ── Navbar (top) ── */
        .main-header.navbar {
            background: #fff !important;
            border-bottom: 1px solid #e5e7eb !important;
            box-shadow: 0 1px 8px rgba(0,0,0,0.06) !important;
        }
        .navbar-nav .nav-link { color: #374151 !important; }

        /* ── Content wrapper ── */
        .content-wrapper {
            background: #f0fdf4 !important;
        }

        /* ── Content header ── */
        .content-header {
            padding: 20px 24px 0 !important;
        }
        .content-header h1 {
            font-size: 1.4rem !important;
            font-weight: 700 !important;
            color: var(--green-dark) !important;
        }
        .breadcrumb-item a { color: var(--green-main) !important; }
        .breadcrumb-item.active { color: #6b7280 !important; }

        /* ── Cards ── */
        .card {
            border: none !important;
            border-radius: 12px !important;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06) !important;
            overflow: hidden;
        }
        .card-header {
            background: #fff !important;
            border-bottom: 1px solid #e5e7eb !important;
            padding: 16px 20px !important;
            font-weight: 600 !important;
            color: var(--green-dark) !important;
        }
        .card-body { padding: 20px !important; }

        /* ── Stat cards ── */
        .info-box {
            border-radius: 12px !important;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06) !important;
            border: none !important;
            overflow: hidden;
        }
        .info-box-icon {
            border-radius: 12px 0 0 12px !important;
            width: 70px !important;
            font-size: 1.6rem !important;
        }

        /* ── Buttons ── */
        .btn-success, .btn-primary {
            background: linear-gradient(135deg, var(--green-main), var(--green-bright)) !important;
            border: none !important;
            border-radius: 8px !important;
            font-weight: 600 !important;
            box-shadow: 0 4px 12px rgba(5,150,105,0.3) !important;
            transition: all 0.2s !important;
        }
        .btn-success:hover, .btn-primary:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 6px 16px rgba(5,150,105,0.4) !important;
        }
        .btn-danger { border-radius: 8px !important; font-weight: 600 !important; }
        .btn-warning { border-radius: 8px !important; font-weight: 600 !important; }
        .btn-info { border-radius: 8px !important; font-weight: 600 !important; }
        .btn-secondary { border-radius: 8px !important; font-weight: 600 !important; }

        /* ── Tables ── */
        .table thead th {
            background: linear-gradient(135deg, var(--green-dark), var(--green-main)) !important;
            color: #fff !important;
            font-weight: 600 !important;
            font-size: 0.78rem !important;
            letter-spacing: 0.5px !important;
            border: none !important;
            padding: 12px 16px !important;
        }
        .table tbody tr:hover { background: #f0fdf4 !important; }
        .table td { vertical-align: middle !important; padding: 12px 16px !important; }

        /* ── Badges ── */
        .badge-success { background: var(--green-light) !important; }

        /* ── Forms ── */
        .form-control:focus, .custom-select:focus {
            border-color: var(--green-bright) !important;
            box-shadow: 0 0 0 3px rgba(16,185,129,0.15) !important;
        }
        .form-control, .custom-select {
            border-radius: 8px !important;
            border: 1px solid #d1d5db !important;
        }

        /* ── Footer ── */
        .main-footer {
            background: #fff !important;
            border-top: 1px solid #e5e7eb !important;
            color: #9ca3af !important;
            font-size: 0.8rem !important;
        }

        /* ── Alerts ── */
        .alert { border-radius: 10px !important; border: none !important; }
        .alert-success {
            background: var(--green-pale) !important;
            color: var(--green-dark) !important;
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: var(--green-light); border-radius: 3px; }

        /* ── Sidebar toggle ── */
        .sidebar-mini.sidebar-collapse .main-sidebar:hover { width: 250px !important; }

        /* ── Navbar icon buttons ── */
        .navbar-icon-btn {
            background: none;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            width: 36px; height: 36px;
            display: flex; align-items: center; justify-content: center;
            color: #6b7280;
            cursor: pointer;
            transition: all 0.2s;
            margin-right: 6px;
        }
        .navbar-icon-btn:hover {
            border-color: var(--green-bright);
            color: var(--green-main);
            background: var(--green-pale);
        }

        /* ── Dark Mode ── */
        [data-theme="dark"] .content-wrapper { background: #0f172a !important; }
        [data-theme="dark"] .main-header.navbar {
            background: #1e293b !important;
            border-bottom-color: #334155 !important;
        }
        [data-theme="dark"] .main-footer {
            background: #1e293b !important;
            border-top-color: #334155 !important;
            color: #64748b !important;
        }
        [data-theme="dark"] .card {
            background: #1e293b !important;
            box-shadow: 0 2px 12px rgba(0,0,0,0.3) !important;
        }
        [data-theme="dark"] .card-header {
            background: #1e293b !important;
            border-bottom-color: #334155 !important;
            color: #e2e8f0 !important;
        }
        [data-theme="dark"] .card-body { color: #cbd5e1 !important; }
        [data-theme="dark"] .info-box {
            background: #1e293b !important;
        }
        [data-theme="dark"] .info-box-content .info-box-text { color: #94a3b8 !important; }
        [data-theme="dark"] .info-box-content .info-box-number { color: #e2e8f0 !important; }
        [data-theme="dark"] .table {
            color: #cbd5e1 !important;
        }
        [data-theme="dark"] .table tbody tr { background: #1e293b !important; border-color: #334155 !important; }
        [data-theme="dark"] .table tbody tr:hover { background: #263548 !important; }
        [data-theme="dark"] .table td { border-color: #334155 !important; }
        [data-theme="dark"] .form-control, [data-theme="dark"] .custom-select {
            background: #0f172a !important;
            border-color: #334155 !important;
            color: #e2e8f0 !important;
        }
        [data-theme="dark"] .form-control:focus { border-color: var(--green-bright) !important; }
        [data-theme="dark"] .navbar-icon-btn {
            border-color: #334155;
            color: #94a3b8;
        }
        [data-theme="dark"] .navbar-icon-btn:hover {
            border-color: var(--green-bright);
            color: var(--green-bright);
            background: rgba(16,185,129,0.1);
        }
        [data-theme="dark"] .content-header h1 { color: #e2e8f0 !important; }
        [data-theme="dark"] .breadcrumb { background: transparent !important; }
        [data-theme="dark"] .breadcrumb-item.active { color: #94a3b8 !important; }
        [data-theme="dark"] .dropdown-menu {
            background: #1e293b !important;
            border-color: #334155 !important;
        }
        [data-theme="dark"] .dropdown-item { color: #cbd5e1 !important; }
        [data-theme="dark"] .dropdown-item:hover { background: #263548 !important; }
        [data-theme="dark"] .dropdown-divider { border-color: #334155 !important; }
        [data-theme="dark"] .alert-success { background: #052e16 !important; color: #6ee7b7 !important; }
        [data-theme="dark"] .alert-danger { background: #1f0a0a !important; color: #fca5a5 !important; }
        [data-theme="dark"] .alert-info { background: #0c1a2e !important; color: #7dd3fc !important; }
        [data-theme="dark"] .callout { background: #263548 !important; border-color: #334155 !important; }
        [data-theme="dark"] .progress { background: #334155 !important; }
        [data-theme="dark"] .badge-light { background: #334155 !important; color: #cbd5e1 !important; }
        [data-theme="dark"] .text-muted { color: #64748b !important; }
        [data-theme="dark"] ::-webkit-scrollbar-track { background: #0f172a; }

        /* ── Google Translate Hiding ── */
        .goog-te-banner-frame.skiptranslate, .goog-te-gadget-icon { display: none !important; }

        /* ── Print Customization ── */
        @media print {
            .main-sidebar, .main-header, .main-footer, .d-print-none, .btn, .breadcrumb {
                display: none !important;
            }
            .content-wrapper {
                margin-left: 0 !important;
                background: #fff !important;
            }
            .card {
                border: 1px solid #e2e8f0 !important;
                box-shadow: none !important;
                break-inside: avoid;
            }
            .container-fluid {
                padding: 0 !important;
            }
            body {
                background: #fff !important;
            }
        }

        body { top: 0px !important; }
        .goog-te-gadget { color: transparent !important; font-size: 0 !important; }
        .goog-te-gadget .goog-te-combo { display: none !important; }
        #google_translate_element { display: none !important; }
        .skiptranslate iframe { display: none !important; }
        .goog-te-menu-value { display: none !important; }
        .goog-te-menu-frame { box-shadow: 0 8px 24px rgba(0,0,0,0.12) !important; border: none !important; border-radius: 12px !important; }
    </style>
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini layout-fixed" id="appBody">
<div class="wrapper">
    <!-- Global Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <!-- ── Navbar ── -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                    <i class="fas fa-bars" style="color: var(--green-main);"></i>
                </a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto align-items-center">

            <!-- Language Dropdown -->
            <li class="nav-item dropdown">
                <button class="navbar-icon-btn" data-toggle="dropdown" title="Pilih Bahasa" id="langBtn" style="width: auto; padding: 0 10px; gap: 6px;">
                    <i class="fas fa-language" style="font-size:1.1rem;"></i>
                    <span id="currentLangText" style="font-size: 0.85rem; font-weight: 600;">Indonesia</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right" style="border-radius:12px; border:none; box-shadow:0 8px 24px rgba(0,0,0,0.12); min-width:160px; padding:8px;">
                    <h6 class="dropdown-header text-uppercase small pb-2" style="letter-spacing:1px; color:#9ca3af; font-weight:700;">Pilih Bahasa</h6>
                    <a href="javascript:void(0);" onclick="changeLanguage('id')" class="dropdown-item d-flex align-items-center" style="border-radius:8px; padding:8px 12px;">
                        <span class="mr-3" style="font-size:1.2rem;">🇮🇩</span> Indonesia
                    </a>
                    <a href="javascript:void(0);" onclick="changeLanguage('en')" class="dropdown-item d-flex align-items-center" style="border-radius:8px; padding:8px 12px;">
                        <span class="mr-3" style="font-size:1.2rem;">🇺🇸</span> English
                    </a>
                    <a href="javascript:void(0);" onclick="changeLanguage('ar')" class="dropdown-item d-flex align-items-center" style="border-radius:8px; padding:8px 12px;">
                        <span class="mr-3" style="font-size:1.2rem;">🇸🇦</span> العربية (Arabic)
                    </a>
                    <div id="google_translate_element" style="display:none;"></div>
                </div>
            </li>
            <!-- Dark Mode Toggle -->
            <li class="nav-item">
                <button class="navbar-icon-btn" onclick="toggleDarkMode()" title="Toggle Dark/Light Mode" id="themeBtn">
                    <i class="fas fa-moon" id="themeIcon" style="font-size:0.85rem;"></i>
                </button>
            </li>
            <!-- Fullscreen Button -->
            <li class="nav-item">
                <button class="navbar-icon-btn" onclick="toggleFullscreen()" title="Fullscreen" id="fsBtn">
                    <i class="fas fa-expand" id="fsIcon" style="font-size:0.85rem;"></i>
                </button>
            </li>
            <!-- Notifications -->
            <li class="nav-item dropdown mr-2">
                <a class="nav-link" data-toggle="dropdown" href="#" style="position: relative;">
                    <i class="far fa-bell" style="color: var(--green-main); font-size:1.1rem;"></i>
                    @if(Auth::user()->unreadNotifications->count() > 0)
                        <span class="badge badge-danger navbar-badge" style="position: absolute; top: 0; right: -2px; font-size: 0.6rem; padding: 2px 4px; border-radius: 50%;">
                            {{ Auth::user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="border-radius:12px; border:none; box-shadow:0 8px 24px rgba(0,0,0,0.12); min-width:300px; padding:0;">
                    <span class="dropdown-header font-weight-bold p-3" style="border-bottom: 1px solid #e5e7eb;">
                        {{ Auth::user()->unreadNotifications->count() }} Notifikasi Belum Dibaca
                    </span>
                    <div style="max-height: 300px; overflow-y: auto;">
                        @forelse(Auth::user()->unreadNotifications as $notification)
                            <div class="dropdown-divider m-0"></div>
                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item p-3" style="white-space: normal; background: #f0fdf4;">
                                    @if($notification->data['type'] === 'risk_status_updated')
                                        <i class="fas fa-file-signature mr-2 text-primary"></i>
                                    @elseif($notification->data['type'] === 'mitigation_deadline')
                                        <i class="fas fa-clock mr-2 text-warning"></i>
                                    @else
                                        <i class="fas fa-info-circle mr-2 text-info"></i>
                                    @endif
                                    <span class="text-sm">{{ $notification->data['message'] ?? 'Ada pemberitahuan baru' }}</span>
                                    <span class="text-muted text-xs d-block mt-1"><i class="far fa-clock mr-1"></i> {{ $notification->created_at->diffForHumans() }}</span>
                                </button>
                            </form>
                        @empty
                            <div class="dropdown-item text-center text-muted p-4">
                                Tidak ada notifikasi baru.
                            </div>
                        @endforelse
                    </div>
                    @if(Auth::user()->unreadNotifications->count() > 0)
                        <div class="dropdown-divider m-0"></div>
                        <form action="{{ route('notifications.readAll') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item dropdown-footer text-center" style="font-size: 0.85rem; font-weight: 600; color: var(--green-main); padding: 12px;">
                                Tandai Semua Telah Dibaca
                            </button>
                        </form>
                    @endif
                </div>
            </li>
            <!-- User menu -->
            <li class="nav-item dropdown">
                <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#">
                    <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,var(--green-main),var(--accent));display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.85rem;margin-right:8px;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <span class="d-none d-sm-inline" style="font-weight:600;color:#374151;font-size:0.9rem;">{{ Auth::user()->name }}</span>
                    <i class="fas fa-chevron-down ml-2" style="font-size:0.7rem;color:#9ca3af;"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right" style="border-radius:12px;border:none;box-shadow:0 8px 24px rgba(0,0,0,0.12);min-width:200px;padding:8px;">
                    <div class="px-3 py-2 mb-1">
                        <p class="mb-0" style="font-weight:700;color:#111827;font-size:0.9rem;">{{ Auth::user()->name }}</p>
                        <small style="color:#6b7280;">{{ Auth::user()->email }}</small>
                        @if(Auth::user()->roles->isNotEmpty())
                            <br><span class="badge mt-1" style="background:var(--green-pale);color:var(--green-dark);font-size:0.7rem;">{{ Auth::user()->roles->first()->name }}</span>
                        @endif
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item" style="border-radius:8px;padding:8px 12px;">
                        <i class="fas fa-user-circle mr-2" style="color:var(--green-main);"></i> Profil Saya
                    </a>
                    <a href="{{ route('panduan.index') }}" class="dropdown-item" style="border-radius:8px;padding:8px 12px;">
                        <i class="fas fa-book mr-2" style="color:var(--green-main);"></i> Panduan User
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger" style="border-radius:8px;padding:8px 12px;background:none;border:none;width:100%;text-align:left;cursor:pointer;">
                            <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    <!-- ── Sidebar ── -->
    <aside class="main-sidebar sidebar-dark-success elevation-4">
        <!-- Brand -->
        <a href="{{ route('dashboard') }}" class="brand-link" style="padding: 10px 16px; border-bottom: 1px solid rgba(255,255,255,0.08);">
            <div style="display:flex;align-items:center;gap:10px;">
                @if(file_exists(public_path('images/logo.png')))
                    <div style="width:40px;height:40px;border-radius:10px;background:#fff;display:flex;align-items:center;justify-content:center;padding:3px;box-shadow:0 2px 8px rgba(0,0,0,0.25);flex-shrink:0;">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo UINSSC" style="width:34px;height:34px;object-fit:contain;">
                    </div>
                @elseif(file_exists(public_path('images/logo.jpg')))
                    <div style="width:40px;height:40px;border-radius:10px;background:#fff;display:flex;align-items:center;justify-content:center;padding:3px;box-shadow:0 2px 8px rgba(0,0,0,0.25);flex-shrink:0;">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Logo UINSSC" style="width:34px;height:34px;object-fit:contain;">
                    </div>
                @else
                    <div style="width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,rgba(255,255,255,0.2),rgba(255,255,255,0.08));display:flex;align-items:center;justify-content:center;border:1px solid rgba(255,255,255,0.15);flex-shrink:0;">
                        <i class="fas fa-shield-alt" style="color:var(--accent);font-size:1.1rem;"></i>
                    </div>
                @endif
                <div>
                    <span class="brand-text" style="font-size:0.95rem;font-weight:800;letter-spacing:-0.3px;display:block;line-height:1.2;">Risk<span style="color:var(--accent);">Management</span></span>
                    <span style="font-size:0.62rem;color:rgba(255,255,255,0.45);font-weight:500;letter-spacing:0.2px;">UIN Siber Syekh Nurjati</span>
                </div>
            </div>
        </a>

        <!-- Sidebar content -->
        <div class="sidebar">
            <!-- User panel -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,var(--green-bright),var(--accent));display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.85rem;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                </div>
                <div class="info">
                    <a href="{{ route('profile.edit') }}" class="d-block">{{ Auth::user()->name }}</a>
                    <div class="d-flex align-items-center justify-content-between mt-1">
                        <small>
                            @if(Auth::user()->roles->isNotEmpty())
                                {{ Auth::user()->roles->first()->name }}
                            @else
                                User
                            @endif
                        </small>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-danger ml-2" title="Keluar">
                            <i class="fas fa-power-off fa-xs"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Nav Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

                    <li class="nav-header">MENU UTAMA</li>

                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    @can('manage master data')
                    <li class="nav-header">DATA MASTER</li>
                    <li class="nav-item">
                        <a href="{{ route('units.index') }}" class="nav-link {{ request()->activeMenu == 'units' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-building"></i>
                            <p>Unit Kerja</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('unit-types.index') }}" class="nav-link {{ request()->routeIs('unit-types.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-layer-group"></i>
                            <p>Jenis Unit</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('risk-categories.index') }}" class="nav-link {{ request()->routeIs('risk-categories.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>Kategori Risiko</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('performance-indicators.index') }}" class="nav-link {{ request()->routeIs('performance-indicators.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-bullseye"></i>
                            <p>Indikator Kinerja</p>
                        </a>
                    </li>
                    @endcan

                    <li class="nav-header">MANAJEMEN RISIKO</li>
                    @can('create risks')
                    <li class="nav-item">
                        <a href="{{ route('risks.index') }}" class="nav-link {{ request()->routeIs('risks.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-signature"></i>
                            <p>Identifikasi Risiko</p>
                        </a>
                    </li>
                    @endcan
                    
                    @can('view all risks')
                    <li class="nav-item">
                        <a href="{{ route('risk-evaluation.index') }}" class="nav-link {{ request()->routeIs('risk-evaluation.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-search-plus"></i>
                            <p>Analisis Risiko</p>
                        </a>
                    </li>
                    @endcan

                    @can('manage mitigations')
                    <li class="nav-item">
                        <a href="{{ route('mitigations.index') }}" class="nav-link {{ request()->routeIs('mitigations.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-shield-virus"></i>
                            <p>Mitigasi Risiko</p>
                        </a>
                    </li>
                    @endcan

                    @can('monitor risks')
                    <li class="nav-item">
                        <a href="{{ route('monitorings.index') }}" class="nav-link {{ request()->routeIs('monitorings.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-eye"></i>
                            <p>Monitoring Risiko</p>
                        </a>
                    </li>
                    @endcan

                    @can('view reports')
                    <li class="nav-header">LAPORAN & ANALISIS</li>
                    <li class="nav-item">
                        <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-pdf"></i>
                            <p>Laporan Risiko</p>
                        </a>
                    </li>
                    @endcan

                    @hasanyrole('Super Admin|Admin')
                    <li class="nav-header">SISTEM</li>
                    @can('manage users')
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Manajemen User</p>
                        </a>
                    </li>
                    @endcan
                    @role('Super Admin')
                    <li class="nav-item">
                        <a href="{{ route('role-requests.index') }}" class="nav-link {{ request()->routeIs('role-requests.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-check"></i>
                            <p>Pengajuan Role</p>
                        </a>
                    </li>
                    @endrole
                    @can('view audit logs')
                    <li class="nav-item">
                        <a href="{{ route('backups.index') }}" class="nav-link {{ request()->routeIs('backups.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-database"></i>
                            <p>Backup Data</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('audit-logs.index') }}" class="nav-link {{ request()->routeIs('audit-logs.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Audit Log</p>
                        </a>
                    </li>
                    @role('Super Admin')
                    <li class="nav-item">
                        <a href="{{ route('system-update.index') }}" class="nav-link {{ request()->routeIs('system-update.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-sync-alt"></i>
                            <p>Update Sistem</p>
                        </a>
                    </li>
                    @endrole
                    @endcan
                    @endhasanyrole

                    <li class="nav-header">AKUN</li>
                    <li class="nav-item">
                        <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-circle"></i>
                            <p>Profil Saya</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('panduan.index') }}" class="nav-link {{ request()->routeIs('panduan.index') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Panduan User</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link text-danger" onclick="document.getElementById('logout-form').submit();">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Keluar</p>
                        </a>
                    </li>

                    {{-- Extra space at bottom to prevent clipping on mobile --}}
                    <li class="nav-item pb-5"></li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- ── Content Wrapper ── -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="container-fluid">
                {{-- ── Impersonation Banner ── --}}
                @if(session()->has('impersonator_id'))
                    <div style="background:linear-gradient(135deg,#d97706,#f59e0b);color:#fff;border-radius:10px;padding:12px 20px;margin-bottom:16px;display:flex;align-items:center;justify-content:space-between;box-shadow:0 4px 12px rgba(217,119,6,0.3);">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-secret mr-3" style="font-size:1.4rem;"></i>
                            <div>
                                <div style="font-weight:700;font-size:0.95rem;">Mode Impersonasi Aktif</div>
                                <small style="opacity:0.9;">Anda sedang login sebagai <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->roles->first()->name ?? 'No Role' }}). Semua tindakan dilakukan atas nama user ini.</small>
                            </div>
                        </div>
                        <form action="{{ route('impersonation.stop') }}" method="POST" class="ml-3">
                            @csrf
                            <button type="submit" style="background:rgba(255,255,255,0.25);border:2px solid rgba(255,255,255,0.6);color:#fff;padding:6px 16px;border-radius:8px;font-weight:700;font-size:0.85rem;cursor:pointer;white-space:nowrap;transition:all 0.2s;" onmouseover="this.style.background='rgba(255,255,255,0.4)'" onmouseout="this.style.background='rgba(255,255,255,0.25)'">
                                <i class="fas fa-sign-out-alt mr-1"></i> Hentikan Impersonasi
                            </button>
                        </form>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif
                @if(session('info'))
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="fas fa-info-circle mr-2"></i> {{ session('info') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                {{ $slot }}
            </div>
        </div>
    </div>

    <!-- ── Footer ── -->
    <footer class="main-footer">
        <strong>&copy; {{ date('Y') }} <span style="color:var(--green-main);">RiskManagement</span> — PUSTIKOM UIN Siber Syekh Nurjati Cirebon.</strong>
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>

</div>

<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@stack('scripts')

<!-- Accessibility Widget -->
@include('partials.accessibility')

<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4',
            width: '100%',
            placeholder: $(this).data('placeholder') || 'Silakan pilih...',
            allowClear: true
        });
    });
</script>

<script>
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
            document.exitFullscreen().then(() => {
                if (icon) icon.className = 'fas fa-expand';
            }).catch(() => {});
        }
    }

    // Update fullscreen icon when user presses Escape
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
            
            // Mark the current active language if needed
            let currentLangText = document.getElementById('currentLangText');
            if (currentLangText) currentLangText.innerText = langName;
            console.log('Language changed to: ' + langCode);
        } else {
            // If the script hasn't loaded yet, retry once
            setTimeout(() => {
                let innerSelect = document.querySelector('.goog-te-combo');
                if (innerSelect) {
                    innerSelect.value = langCode;
                    innerSelect.dispatchEvent(new Event('change'));
                    
                    let innerLangText = document.getElementById('currentLangText');
                    if (innerLangText) innerLangText.innerText = langName;
                }
            }, 1000);
        }
    }
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>
</html>
