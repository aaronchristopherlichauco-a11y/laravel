<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — EduTrack</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Merriweather:wght@700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary:       #1a6b3c;
            --primary-dark:  #114d2b;
            --primary-light: #28a164;
            --accent:        #4caf78;
            --accent-soft:   #e8f5ee;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f0f5f2;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* ── Split layout ───────────────────────────── */
        .auth-wrapper {
            display: flex;
            width: 100%;
            max-width: 960px;
            min-height: 580px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0,0,0,.12);
            margin: 20px;
        }

        /* Left panel */
        .auth-panel-left {
            width: 40%;
            background: linear-gradient(160deg, #0f3d22 0%, #1a6b3c 60%, #28a164 100%);
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .auth-panel-left::before {
            content: '';
            position: absolute;
            top: -80px; right: -80px;
            width: 250px; height: 250px;
            border-radius: 50%;
            background: rgba(255,255,255,.05);
        }

        .auth-panel-left::after {
            content: '';
            position: absolute;
            bottom: -60px; left: -60px;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: rgba(255,255,255,.04);
        }

        .auth-logo {
            width: 56px; height: 56px;
            background: rgba(255,255,255,.15);
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.6rem; color: #fff;
            margin-bottom: 24px;
            backdrop-filter: blur(8px);
        }

        .auth-panel-left h2 {
            font-family: 'Merriweather', serif;
            color: #fff;
            font-size: 1.8rem;
            margin-bottom: 12px;
            line-height: 1.3;
        }

        .auth-panel-left p {
            color: rgba(255,255,255,.7);
            font-size: .88rem;
            line-height: 1.6;
        }

        .auth-features {
            margin-top: 32px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .auth-feature-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255,255,255,.85);
            font-size: .82rem;
        }

        .auth-feature-item i {
            width: 28px; height: 28px;
            background: rgba(255,255,255,.12);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: .9rem;
            flex-shrink: 0;
        }

        /* Right panel */
        .auth-panel-right {
            flex: 1;
            background: #fff;
            padding: 48px 44px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow-y: auto;
        }

        .auth-panel-right h3 {
            font-weight: 800;
            font-size: 1.5rem;
            color: #1f2937;
            margin-bottom: 6px;
        }

        .auth-panel-right .subtitle {
            color: #6b7280;
            font-size: .875rem;
            margin-bottom: 28px;
        }

        .form-control {
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 11px 14px;
            font-size: .875rem;
            transition: border-color .2s, box-shadow .2s;
        }

        .form-control:focus {
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(40,161,100,.12);
        }

        .input-group-text {
            background: #f9fafb;
            border: 1.5px solid #e5e7eb;
            color: #9ca3af;
        }

        .form-label {
            font-weight: 600;
            font-size: .83rem;
            color: #374151;
            margin-bottom: 6px;
        }

        .btn-primary {
            background: var(--primary);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 700;
            font-size: .9rem;
            letter-spacing: .3px;
            transition: background .2s, transform .15s;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .auth-link {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        .auth-link:hover { color: var(--primary-dark); }

        .invalid-feedback { font-size: .78rem; }

        /* Toast */
        #toast-container {
            position: fixed;
            bottom: 24px; right: 24px;
            z-index: 9999;
        }

        .toast-custom {
            min-width: 280px;
            padding: 14px 18px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: .875rem;
            font-weight: 500;
            box-shadow: 0 8px 30px rgba(0,0,0,.15);
            animation: slideIn .35s cubic-bezier(.34,1.56,.64,1);
        }

        .toast-custom.success { background: var(--primary); color: #fff; }
        .toast-custom.error   { background: #dc3545; color: #fff; }

        @keyframes slideIn {
            from { transform: translateX(120%); opacity: 0; }
            to   { transform: translateX(0); opacity: 1; }
        }

        @media (max-width: 640px) {
            .auth-panel-left { display: none; }
            .auth-panel-right { padding: 36px 28px; }
            .auth-wrapper { max-width: 100%; margin: 0; border-radius: 0; min-height: 100vh; }
        }
    </style>
</head>
<body>

<div class="auth-wrapper">
    <!-- Left decorative panel -->
    <div class="auth-panel-left">
        <div class="auth-logo"><i class="bi bi-mortarboard-fill"></i></div>
        <h2>EduTrack Academic System</h2>
        <p>Manage your class schedules, track records, and stay organized throughout the semester.</p>
        <div class="auth-features">
            <div class="auth-feature-item">
                <i class="bi bi-calendar3-week-fill"></i>
                <span>Weekly Class Schedule</span>
            </div>
            <div class="auth-feature-item">
                <i class="bi bi-people-fill"></i>
                <span>User Management</span>
            </div>
            <div class="auth-feature-item">
                <i class="bi bi-bar-chart-fill"></i>
                <span>Visual Dashboard Reports</span>
            </div>
            <div class="auth-feature-item">
                <i class="bi bi-shield-check-fill"></i>
                <span>Secure & Reliable</span>
            </div>
        </div>
    </div>

    <!-- Right form panel -->
    <div class="auth-panel-right">
        @yield('content')
    </div>
</div>

<div id="toast-container"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function showToast(message, type = 'success') {
        const c = document.getElementById('toast-container');
        const t = document.createElement('div');
        t.className = `toast-custom ${type}`;
        t.innerHTML = `<i class="bi bi-${type === 'success' ? 'check-circle-fill' : 'x-circle-fill'}"></i><span>${message}</span>`;
        c.appendChild(t);
        setTimeout(() => { t.style.animation = 'none'; t.style.opacity = '0'; setTimeout(() => t.remove(), 300); }, 4000);
    }

    @if(session('toast_success'))
        showToast(@json(session('toast_success')), 'success');
    @endif
</script>
</body>
</html>
