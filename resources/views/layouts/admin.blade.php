<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    @include('partials.site-icons')
    <title>@yield('title', 'Administración') - aislagratis</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --admin-green: #1b5e20;
            --admin-green-dark: #123f1a;
            --admin-green-soft: #edf6ee;
            --admin-ink: #18231a;
            --admin-muted: #68756a;
            --admin-line: #dfe8df;
            --admin-paper: #ffffff;
            --admin-ground: #f1f5f0;
            --admin-shadow: 0 16px 40px rgba(22, 40, 28, .09);
        }
        * { box-sizing: border-box; }
        body { margin: 0; background: var(--admin-ground); color: var(--admin-ink); font: 14px/1.6 'Montserrat', sans-serif; }
        a { color: inherit; }
        .admin-topbar { background: #fff; border-bottom: 1px solid var(--admin-line); }
        .admin-topbar-inner { width: min(1500px, 100%); min-height: 76px; margin: auto; padding: 12px clamp(16px, 4vw, 56px); display: flex; align-items: center; justify-content: space-between; gap: 20px; }
        .admin-brand { display: inline-flex; align-items: center; gap: 11px; color: var(--admin-green); font-size: 1rem; font-weight: 800; letter-spacing: 1px; text-decoration: none; }
        .admin-brand-mark { width: 42px; height: 42px; display: block; object-fit: contain; border-radius: 12px; background: #fff; }
        .admin-account { display: flex; align-items: center; gap: 14px; }
        .admin-greeting { display: grid; line-height: 1.35; }
        .admin-greeting strong { font-size: .85rem; }
        .admin-greeting span { color: var(--admin-muted); font-size: .72rem; }
        .admin-logout { min-height: 40px; display: inline-flex; align-items: center; gap: 8px; border: 1px solid var(--admin-line); border-radius: 8px; padding: 0 14px; background: #fff; color: var(--admin-ink); font: inherit; font-size: .78rem; font-weight: 700; text-decoration: none; cursor: pointer; }
        .admin-logout:hover { border-color: var(--admin-green); color: var(--admin-green); }
        .admin-nav-wrap { background: #fff; border-bottom: 1px solid var(--admin-line); }
        .admin-nav { width: min(1500px, 100%); margin: auto; padding: 0 clamp(16px, 4vw, 56px); display: flex; gap: 4px; overflow-x: auto; scrollbar-width: thin; }
        .admin-nav a { flex: 0 0 auto; min-height: 48px; display: inline-flex; align-items: center; gap: 8px; padding: 0 13px; border-bottom: 2px solid transparent; color: var(--admin-muted); font-size: .76rem; font-weight: 700; text-decoration: none; white-space: nowrap; }
        .admin-nav a:hover, .admin-nav a.active { border-bottom-color: var(--admin-green); color: var(--admin-green); }
        .admin-main { width: min(1500px, 100%); margin: auto; padding: 28px clamp(16px, 4vw, 56px) 56px; }
        .admin-intro { min-height: 230px; display: grid; grid-template-columns: minmax(0, 1.15fr) minmax(300px, .85fr); margin-bottom: 26px; overflow: hidden; border-radius: 10px; background: #fff; box-shadow: var(--admin-shadow); }
        .admin-intro-copy { padding: clamp(25px, 4vw, 46px); align-self: center; }
        .admin-eyebrow { display: inline-flex; align-items: center; gap: 8px; margin-bottom: 12px; color: var(--admin-green); font-size: .7rem; font-weight: 800; letter-spacing: 1px; text-transform: uppercase; }
        .admin-intro h1 { margin: 0 0 10px; font-size: clamp(1.55rem, 2.4vw, 2.25rem); line-height: 1.2; font-weight: 800; }
        .admin-intro p { max-width: 590px; margin: 0; color: var(--admin-muted); font-size: .88rem; }
        .admin-intro-image { position: relative; min-height: 230px; background: var(--admin-green-dark); }
        .admin-intro-image img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
        .admin-intro-image::after { content: ''; position: absolute; inset: 0; background: linear-gradient(90deg, rgba(18,63,26,.05), rgba(18,63,26,.5)); }
        .admin-content { min-width: 0; }
        .admin-section-heading { display: flex; align-items: end; justify-content: space-between; gap: 16px; margin: 0 0 15px; }
        .admin-section-heading h2 { margin: 0; font-size: 1.05rem; font-weight: 800; }
        .admin-section-heading p { margin: 3px 0 0; color: var(--admin-muted); font-size: .78rem; }
        .admin-stats { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 12px; margin-bottom: 26px; }
        .admin-stat { min-height: 122px; padding: 17px; border: 1px solid var(--admin-line); border-radius: 8px; background: var(--admin-paper); }
        .admin-stat-top { display: flex; align-items: center; justify-content: space-between; gap: 8px; color: var(--admin-muted); font-size: .72rem; font-weight: 700; }
        .admin-stat-icon { width: 34px; height: 34px; display: grid; place-items: center; border-radius: 8px; background: var(--admin-green-soft); color: var(--admin-green); }
        .admin-stat-value { display: block; margin-top: 8px; font-size: 1.7rem; line-height: 1.2; font-weight: 800; }
        .admin-panel { margin-bottom: 22px; border: 1px solid var(--admin-line); border-radius: 8px; background: var(--admin-paper); overflow: hidden; }
        .admin-panel-head { min-height: 58px; display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 12px 18px; border-bottom: 1px solid var(--admin-line); }
        .admin-panel-head h2 { margin: 0; display: flex; align-items: center; gap: 9px; font-size: .9rem; font-weight: 800; }
        .admin-panel-body { padding: 18px; }
        .admin-table-wrap { overflow-x: auto; }
        .admin-table { width: 100%; border-collapse: collapse; font-size: .78rem; }
        .admin-table th { padding: 11px 14px; background: #f7faf7; color: var(--admin-muted); text-align: left; font-size: .66rem; font-weight: 800; letter-spacing: .5px; text-transform: uppercase; white-space: nowrap; }
        .admin-table td { padding: 12px 14px; border-top: 1px solid #edf1ed; vertical-align: middle; }
        .admin-table tbody tr:hover { background: #fbfdfb; }
        .admin-button { min-height: 38px; display: inline-flex; align-items: center; justify-content: center; gap: 8px; border: 1px solid var(--admin-line); border-radius: 7px; padding: 0 13px; background: #fff; color: var(--admin-ink); font: inherit; font-size: .75rem; font-weight: 700; text-decoration: none; cursor: pointer; }
        .admin-button:hover { border-color: var(--admin-green); color: var(--admin-green); }
        .admin-button-primary { border-color: var(--admin-green); background: var(--admin-green); color: #fff; }
        .admin-button-primary:hover { background: var(--admin-green-dark); color: #fff; }
        .admin-button-danger { color: #a3342d; }
        .admin-badge { display: inline-flex; align-items: center; border-radius: 20px; padding: 4px 9px; background: #edf6ee; color: var(--admin-green); font-size: .68rem; font-weight: 700; white-space: nowrap; }
        .admin-badge-neutral { background: #f0f2f0; color: #59635a; }
        .admin-badge-warning { background: #fff4dc; color: #855b06; }
        .admin-badge-danger { background: #fff0ee; color: #a3342d; }
        .admin-alert { margin: 0 0 18px; border: 1px solid var(--admin-line); border-radius: 8px; padding: 12px 15px; background: #fff; font-size: .82rem; }
        .admin-alert-success { border-color: #b9dbbd; background: #edf6ee; color: var(--admin-green-dark); }
        .admin-alert-error { border-color: #f3c5c0; background: #fff0ee; color: #a3342d; }
        .admin-form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
        .admin-field { display: grid; gap: 6px; }
        .admin-field-full { grid-column: 1 / -1; }
        .admin-field label { color: var(--admin-ink); font-size: .74rem; font-weight: 700; }
        .admin-field input, .admin-field select, .admin-field textarea { width: 100%; min-height: 42px; border: 1px solid var(--admin-line); border-radius: 7px; padding: 9px 11px; background: #fff; color: var(--admin-ink); font: inherit; font-size: .8rem; }
        .admin-field textarea { min-height: 110px; resize: vertical; }
        .admin-field input:focus, .admin-field select:focus, .admin-field textarea:focus { outline: 3px solid rgba(27,94,32,.12); border-color: var(--admin-green); }
        .admin-toolbar { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 16px; }
        .admin-filters { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; }
        .admin-filters input, .admin-filters select { min-height: 38px; border: 1px solid var(--admin-line); border-radius: 7px; padding: 0 10px; background: #fff; font: inherit; font-size: .74rem; }
        .admin-actions { display: flex; flex-wrap: wrap; align-items: center; gap: 7px; }
        .admin-empty { padding: 35px 18px; color: var(--admin-muted); text-align: center; }
        .admin-empty i { display: block; margin-bottom: 9px; color: #91a493; font-size: 1.5rem; }
        .admin-flash { margin-bottom: 18px; }
        .admin-login-link { color: var(--admin-green); font-weight: 700; }
        .admin-auth-error { color: #a3342d; font-size: .72rem; }
        .admin-check { display: inline-flex; align-items: center; gap: 7px; font-size: .78rem; }
        .admin-inline-form { display: inline-flex; align-items: center; gap: 6px; }
        .admin-inline-form select { min-height: 34px; border: 1px solid var(--admin-line); border-radius: 6px; padding: 0 8px; background: #fff; font: inherit; font-size: .7rem; }
        .admin-pager { padding: 15px 18px; border-top: 1px solid var(--admin-line); }
        @media (max-width: 1100px) { .admin-stats { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
        @media (max-width: 760px) {
            .admin-topbar-inner { min-height: 66px; }
            .admin-greeting { display: none; }
            .admin-main { padding-top: 18px; }
            .admin-intro { grid-template-columns: 1fr; }
            .admin-intro-image { min-height: 150px; grid-row: 1; }
            .admin-intro-copy { padding: 24px; }
            .admin-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 9px; }
            .admin-stat { min-height: 110px; padding: 13px; }
            .admin-stat-value { font-size: 1.45rem; }
            .admin-form-grid { grid-template-columns: 1fr; }
            .admin-field-full { grid-column: auto; }
        }
        @media (max-width: 420px) { .admin-brand { font-size: .83rem; } .admin-brand-mark { width: 36px; height: 36px; } .admin-logout { padding: 0 10px; } .admin-stats { grid-template-columns: 1fr 1fr; } }
    </style>
    @stack('styles')
</head>
<body>
    <header class="admin-topbar">
        <div class="admin-topbar-inner">
            <a class="admin-brand" href="{{ auth()->user()->isCustomer() ? route('customer.dashboard') : (auth()->user()->isTechnician() ? route('admin.appointments.index') : route('admin.dashboard')) }}">
                <img class="admin-brand-mark" src="{{ asset('icons/icon-192.png') }}?v={{ filemtime(public_path('icons/icon-192.png')) }}" alt="" aria-hidden="true" width="42" height="42">
                <span>aislagratis</span>
            </a>
            <div class="admin-account">
                <div class="admin-greeting">
                    <strong>{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</strong>
                    <span>{{ match(auth()->user()->role->value) { 'admin' => 'Administración', 'sales' => 'Equipo comercial', 'technician' => 'Equipo técnico', default => 'Área de cliente' } }}</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="admin-logout" type="submit"><i class="fa-solid fa-arrow-right-from-bracket"></i> Salir</button>
                </form>
            </div>
        </div>
    </header>
    <div class="admin-nav-wrap">
        <nav class="admin-nav" aria-label="Navegación de administración">
            @if(auth()->user()->isCustomer())
                <a href="{{ route('customer.dashboard') }}" class="{{ request()->routeIs('customer.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-chart-line"></i> Resumen</a>
                <a href="{{ route('customer.leads.index') }}" class="{{ request()->routeIs('customer.leads.*') ? 'active' : '' }}"><i class="fa-solid fa-inbox"></i> Mis solicitudes</a>
                <a href="{{ route('customer.installations.index') }}" class="{{ request()->routeIs('customer.installations.*') ? 'active' : '' }}"><i class="fa-solid fa-screwdriver-wrench"></i> Instalaciones</a>
                <a href="{{ route('customer.properties.index') }}" class="{{ request()->routeIs('customer.properties.*') ? 'active' : '' }}"><i class="fa-solid fa-house"></i> Inmuebles</a>
                <a href="{{ route('customer.reviews.index') }}" class="{{ request()->routeIs('customer.reviews.*') ? 'active' : '' }}"><i class="fa-solid fa-star"></i> Opiniones</a>
                <a href="{{ route('customer.profile.edit') }}" class="{{ request()->routeIs('customer.profile.*') ? 'active' : '' }}"><i class="fa-solid fa-user-gear"></i> Mi perfil</a>
            @else
                @unless(auth()->user()->isTechnician())<a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-chart-line"></i> Resumen</a>@endunless
                @unless(auth()->user()->isTechnician())<a href="{{ route('admin.leads.index') }}" class="{{ request()->routeIs('admin.leads.*') ? 'active' : '' }}"><i class="fa-solid fa-inbox"></i> Solicitudes</a>@endunless
                <a href="{{ route('admin.appointments.index') }}" class="{{ request()->routeIs('admin.appointments.*') ? 'active' : '' }}"><i class="fa-solid fa-calendar-check"></i> {{ auth()->user()->isTechnician() ? 'Mis citas' : 'Citas' }}</a>
                @unless(auth()->user()->isTechnician())<a href="{{ route('admin.installations.index') }}" class="{{ request()->routeIs('admin.installations.*') ? 'active' : '' }}"><i class="fa-solid fa-screwdriver-wrench"></i> Instalaciones</a>@endunless
                @if(auth()->user()->role->value === 'admin')
                    <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="fa-solid fa-users"></i> Usuarios</a>
                    <a href="{{ route('admin.services.index') }}" class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}"><i class="fa-solid fa-bolt"></i> Servicios</a>
                    <a href="{{ route('admin.coverage-areas.index') }}" class="{{ request()->routeIs('admin.coverage-areas.*') ? 'active' : '' }}"><i class="fa-solid fa-map-location-dot"></i> Cobertura</a>
                    <a href="{{ route('admin.faqs.index') }}" class="{{ request()->routeIs('admin.faqs.*') ? 'active' : '' }}"><i class="fa-solid fa-circle-question"></i> Preguntas</a>
                    <a href="{{ route('admin.partners.index') }}" class="{{ request()->routeIs('admin.partners.*') ? 'active' : '' }}"><i class="fa-solid fa-handshake"></i> Partners</a>
                    <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"><i class="fa-solid fa-chart-pie"></i> Informes</a>
                @endif
                <a href="{{ route('admin.notifications.index') }}" class="{{ request()->routeIs('admin.notifications.*') ? 'active' : '' }}"><i class="fa-solid fa-bell"></i> Avisos</a>
            @endif
        </nav>
    </div>
    <main class="admin-main">
        @if(session('success')) <div class="admin-alert admin-alert-success admin-flash" role="status">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="admin-alert admin-alert-error admin-flash" role="alert">{{ session('error') }}</div> @endif
        @if($errors->any())
            <div class="admin-alert admin-alert-error admin-flash" role="alert">
                <strong>Revisa los datos:</strong>
                <ul style="margin:6px 0 0;padding-left:20px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif
        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>