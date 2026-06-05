<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'EduTrack') — EduTrack</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Merriweather:wght@700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary:       #1a6b3c;
            --primary-dark:  #114d2b;
            --primary-light: #28a164;
            --accent:        #4caf78;
            --accent-soft:   #e8f5ee;
            --sidebar-bg:    #0f3d22;
            --sidebar-text:  #c8e6d2;
            --sidebar-hover: #1a6b3c;
            --white:         #ffffff;
            --gray-50:       #f9fafb;
            --gray-100:      #f0f2f1;
            --gray-200:      #e2e8e4;
            --gray-500:      #6b7c74;
            --gray-700:      #374845;
            --danger:        #dc3545;
            --warning:       #e9a825;
            --info:          #0d9488;
            --font-main:     'Plus Jakarta Sans', sans-serif;
        }

        * { box-sizing: border-box; }

        body {
            font-family: var(--font-main);
            background: var(--gray-50);
            color: var(--gray-700);
            margin: 0;
        }

        /* ── Sidebar ───────────────────────────────────────────── */
        #sidebar {
            position: fixed;
            top: 0; left: 0;
            width: 260px;
            height: 100vh;
            background: var(--sidebar-bg);
            display: flex;
            flex-direction: column;
            z-index: 1000;
            transition: transform .3s ease;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 24px 22px 20px;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }

        .sidebar-brand .brand-logo {
            width: 42px; height: 42px;
            background: linear-gradient(135deg, var(--primary-light), var(--accent));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; color: #fff;
            margin-bottom: 10px;
        }

        .sidebar-brand h5 {
            font-family: 'Merriweather', serif;
            color: #fff;
            font-size: 1.1rem;
            margin: 0;
            letter-spacing: .3px;
        }

        .sidebar-brand small {
            color: var(--sidebar-text);
            font-size: .72rem;
            opacity: .75;
        }

        .sidebar-nav { padding: 16px 12px; flex: 1; }

        .nav-section-label {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: rgba(200,230,210,.4);
            padding: 12px 10px 6px;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 14px;
            border-radius: 10px;
            color: var(--sidebar-text);
            font-size: .875rem;
            font-weight: 500;
            text-decoration: none;
            transition: background .2s, color .2s;
            margin-bottom: 3px;
        }

        .sidebar-nav .nav-link i { font-size: 1.05rem; width: 20px; text-align: center; }

        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            background: var(--sidebar-hover);
            color: #fff;
        }

        .sidebar-nav .nav-link.active { font-weight: 600; }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,.08);
        }

        .sidebar-user {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px;
            border-radius: 10px;
            background: rgba(255,255,255,.06);
            margin-bottom: 8px;
        }

        .sidebar-user-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: var(--primary-light);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: .85rem;
            overflow: hidden; flex-shrink: 0;
        }

        .sidebar-user-avatar img { width: 100%; height: 100%; object-fit: cover; }

        .sidebar-user-info .name {
            font-size: .8rem; font-weight: 600; color: #fff;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 155px;
        }

        .sidebar-user-info .role {
            font-size: .68rem; color: var(--sidebar-text); opacity: .7;
        }

        /* ── Main wrapper ──────────────────────────────────────── */
        #main-wrapper {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin .3s ease;
        }

        /* ── Top navbar ────────────────────────────────────────── */
        #topnav {
            background: #fff;
            border-bottom: 1px solid var(--gray-200);
            padding: 12px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky; top: 0; z-index: 900;
        }

        .topnav-title {
            font-size: 1rem;
            font-weight: 700;
            color: var(--gray-700);
        }

        .topnav-title span { color: var(--primary); }

        .btn-sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.3rem;
            color: var(--gray-700);
            cursor: pointer;
            padding: 4px 8px;
        }

        /* ── Page content ──────────────────────────────────────── */
        #page-content {
            padding: 28px;
            flex: 1;
        }

        /* ── Cards ─────────────────────────────────────────────── */
        .card {
            border: 1px solid var(--gray-200);
            border-radius: 14px;
            box-shadow: 0 1px 4px rgba(0,0,0,.04);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid var(--gray-200);
            border-radius: 14px 14px 0 0 !important;
            padding: 16px 20px;
            font-weight: 600;
        }

        /* ── Stat cards ────────────────────────────────────────── */
        .stat-card {
            border-radius: 14px;
            padding: 22px 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            background: #fff;
            border: 1px solid var(--gray-200);
            box-shadow: 0 1px 4px rgba(0,0,0,.04);
            transition: box-shadow .2s, transform .2s;
        }

        .stat-card:hover { box-shadow: 0 4px 16px rgba(0,0,0,.08); transform: translateY(-2px); }

        .stat-icon {
            width: 54px; height: 54px;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .stat-icon.green  { background: var(--accent-soft); color: var(--primary); }
        .stat-icon.teal   { background: #e0f7f5; color: var(--info); }
        .stat-icon.amber  { background: #fef3c7; color: var(--warning); }
        .stat-icon.blue   { background: #dbeafe; color: #1d4ed8; }

        .stat-value { font-size: 1.8rem; font-weight: 800; color: var(--gray-700); line-height: 1; }
        .stat-label { font-size: .8rem; color: var(--gray-500); margin-top: 3px; }

        /* ── Buttons ───────────────────────────────────────────── */
        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
            font-weight: 600;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            border-color: var(--primary);
        }

        /* ── Tables ────────────────────────────────────────────── */
        .table thead th {
            background: var(--gray-50);
            font-size: .78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--gray-500);
            border-bottom: 2px solid var(--gray-200);
            padding: 12px 16px;
        }

        .table tbody td {
            padding: 12px 16px;
            vertical-align: middle;
            font-size: .875rem;
        }

        .table tbody tr:hover { background: var(--accent-soft); }

        /* ── Badge ─────────────────────────────────────────────── */
        .badge-day {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: .72rem;
            font-weight: 600;
        }

        /* ── Form controls ─────────────────────────────────────── */
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 .2rem rgba(40,161,100,.15);
        }

        .form-label { font-weight: 600; font-size: .85rem; color: var(--gray-700); }

        /* ── Color swatch picker ───────────────────────────────── */
        .color-swatch {
            display: inline-block;
            width: 28px; height: 28px;
            border-radius: 50%;
            cursor: pointer;
            border: 3px solid transparent;
            transition: transform .15s, border-color .15s;
        }

        .color-swatch.selected { border-color: var(--gray-700); transform: scale(1.2); }

        /* ── Toast ─────────────────────────────────────────────── */
        #toast-container {
            position: fixed;
            bottom: 24px; right: 24px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .toast-custom {
            min-width: 300px;
            max-width: 380px;
            padding: 14px 18px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: .875rem;
            font-weight: 500;
            box-shadow: 0 8px 30px rgba(0,0,0,.15);
            animation: slideIn .35s cubic-bezier(.34,1.56,.64,1);
        }

        .toast-custom.success { background: var(--primary); color: #fff; }
        .toast-custom.error   { background: var(--danger);  color: #fff; }

        .toast-custom i { font-size: 1.2rem; }

        @keyframes slideIn {
            from { transform: translateX(120%); opacity: 0; }
            to   { transform: translateX(0);    opacity: 1; }
        }

        @keyframes slideOut {
            to { transform: translateX(120%); opacity: 0; }
        }

        /* ── Page header ───────────────────────────────────────── */
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .page-header h1 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--gray-700);
            margin: 0;
        }

        .page-header .breadcrumb {
            font-size: .78rem;
            margin: 0;
        }

        /* ── Avatar ────────────────────────────────────────────── */
        .avatar-circle {
            width: 100px; height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--gray-200);
        }

        .avatar-initial {
            width: 100px; height: 100px;
            border-radius: 50%;
            background: var(--primary);
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: 2.5rem;
            font-weight: 700;
            border: 4px solid var(--gray-200);
        }

        /* ── Responsive ────────────────────────────────────────── */
        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #main-wrapper { margin-left: 0; }
            .btn-sidebar-toggle { display: block; }
            #page-content { padding: 16px; }
        }

        /* ── Scrollbar ─────────────────────────────────────────── */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--gray-200); border-radius: 3px; }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<aside id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-logo"><i class="bi bi-mortarboard-fill"></i></div>
        <h5>EduTrack</h5>
        <small>Academic Management System</small>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Main</div>

        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i> Dashboard
        </a>

        <div class="nav-section-label">Management</div>

        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i> Users
        </a>

        <a href="{{ route('schedules.index') }}" class="nav-link {{ request()->routeIs('schedules.*') ? 'active' : '' }}">
            <i class="bi bi-calendar3"></i> Class Schedule
        </a>

        <div class="nav-section-label">Account</div>

        <a href="{{ route('profile.show') }}" class="nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> My Profile
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                @if(Auth::user()->avatar)
                    <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar">
                @else
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                @endif
            </div>
            <div class="sidebar-user-info">
                <div class="name">{{ Auth::user()->name }}</div>
                <div class="role">{{ Auth::user()->email }}</div>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link w-100 border-0 text-start" style="background:none;">
                <i class="bi bi-box-arrow-left"></i> Logout
            </button>
        </form>
    </div>
</aside>

<!-- OVERLAY for mobile -->
<div id="sidebar-overlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.4);z-index:999;"
     onclick="toggleSidebar()"></div>

<!-- MAIN WRAPPER -->
<div id="main-wrapper">

    <!-- TOP NAV -->
    <nav id="topnav">
        <div class="d-flex align-items-center gap-3">
            <button class="btn-sidebar-toggle" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>
            <div>
                <div class="topnav-title">@yield('page-title', 'Dashboard')</div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" style="color:var(--primary);">Home</a></li>
                        @yield('breadcrumb')
                    </ol>
                </nav>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <span class="d-none d-md-block text-muted" style="font-size:.8rem;">
                <i class="bi bi-clock me-1"></i>
                <span id="live-clock"></span>
            </span>
            <a href="{{ route('profile.show') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                <div class="sidebar-user-avatar" style="width:34px;height:34px;font-size:.75rem;background:var(--primary);">
                    @if(Auth::user()->avatar)
                        <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="">
                    @else
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    @endif
                </div>
                <span style="font-size:.85rem;font-weight:600;color:var(--gray-700);" class="d-none d-lg-block">
                    {{ Auth::user()->name }}
                </span>
            </a>
        </div>
    </nav>

    <!-- PAGE CONTENT -->
    <main id="page-content">
        @yield('content')
    </main>
</div>

<!-- TOAST CONTAINER -->
<div id="toast-container"></div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>

<script>
    // Live clock
    function updateClock() {
        const now = new Date();
        document.getElementById('live-clock').textContent =
            now.toLocaleTimeString('en-PH', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }
    setInterval(updateClock, 1000);
    updateClock();

    // Sidebar toggle
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        sidebar.classList.toggle('show');
        overlay.style.display = sidebar.classList.contains('show') ? 'block' : 'none';
    }

    // Toast function
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = `toast-custom ${type}`;
        toast.innerHTML = `<i class="bi bi-${type === 'success' ? 'check-circle-fill' : 'x-circle-fill'}"></i><span>${message}</span>`;
        container.appendChild(toast);
        setTimeout(() => {
            toast.style.animation = 'slideOut .35s forwards';
            setTimeout(() => toast.remove(), 350);
        }, 4000);
    }

    // Fire session toasts
    @if(session('toast_success'))
        showToast(@json(session('toast_success')), 'success');
    @endif
    @if(session('toast_error'))
        showToast(@json(session('toast_error')), 'error');
    @endif
</script>

@stack('scripts')
</body>
</html>
