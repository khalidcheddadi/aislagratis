@extends('layouts.admin')
@section('title', 'Mi panel')
@section('content')
    @php
        $monthlyMaximum = max(1, (int) $monthlyLeads->max('count'));
        $statusTotal = max(1, (int) $leadStatuses->sum('total'));
    @endphp

    <div class="customer-dashboard">
        <header class="customer-dashboard-header">
            <div class="customer-dashboard-heading">
                <span class="customer-dashboard-eyebrow"><span></span> TU ESPACIO PERSONAL</span>
                <h1>Hola, {{ auth()->user()->first_name }} <span aria-hidden="true">✳</span></h1>
                <p>Consulta el avance de tus solicitudes y las mejoras de tu hogar.</p>
            </div>
            <a class="customer-dashboard-primary" href="{{ route('leads.create') }}"><i class="fa-solid fa-plus" aria-hidden="true"></i> Nueva solicitud</a>
        </header>

        <section class="customer-dashboard-summary" aria-label="Resumen de tu cuenta">
            <article class="customer-dashboard-hero">
                <img src="{{ asset('images/image12-640.webp') }}" alt="" aria-hidden="true" fetchpriority="high" decoding="async">
                <div class="customer-dashboard-hero-shade"></div>
                <div class="customer-dashboard-hero-content">
                    <span><i class="fa-solid fa-leaf" aria-hidden="true"></i> AISLAGRATIS · EFICIENCIA PARA TU HOGAR</span>
                    <h2>Más confort.<br>Menos consumo.</h2>
                    <p>Estamos contigo en cada paso de la mejora energética de tu vivienda.</p>
                    <a href="{{ route('customer.leads.index') }}">Ver mis solicitudes <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                </div>
                <span class="customer-dashboard-hero-mark" aria-hidden="true"><i class="fa-solid fa-house-circle-check"></i></span>
            </article>

            <div class="customer-dashboard-stat-grid">
                <article class="customer-dashboard-stat">
                    <span class="customer-dashboard-stat-icon is-blue"><i class="fa-solid fa-inbox" aria-hidden="true"></i></span>
                    <span class="customer-dashboard-stat-label">Solicitudes</span>
                    <strong>{{ number_format($stats['total_leads']) }}</strong>
                    <small>Enviadas por ti</small>
                </article>
                <article class="customer-dashboard-stat">
                    <span class="customer-dashboard-stat-icon is-amber"><i class="fa-regular fa-clock" aria-hidden="true"></i></span>
                    <span class="customer-dashboard-stat-label">En seguimiento</span>
                    <strong>{{ number_format($stats['pending_leads']) }}</strong>
                    <small>En revisión o contacto</small>
                </article>
                <article class="customer-dashboard-stat">
                    <span class="customer-dashboard-stat-icon is-green"><i class="fa-solid fa-house-circle-check" aria-hidden="true"></i></span>
                    <span class="customer-dashboard-stat-label">Instalaciones</span>
                    <strong>{{ number_format($stats['total_installations']) }}</strong>
                    <small>Asociadas a tu cuenta</small>
                </article>
                <article class="customer-dashboard-stat customer-dashboard-savings">
                    <span class="customer-dashboard-stat-icon is-teal"><i class="fa-solid fa-euro-sign" aria-hidden="true"></i></span>
                    <span class="customer-dashboard-stat-label">Ahorro neto</span>
                    <strong>{{ number_format($stats['total_savings'], 2, ',', '.') }}<small> €</small></strong>
                    <small>En instalaciones completadas</small>
                </article>
            </div>
        </section>

        @if($unreadNotifications->isNotEmpty())
            <section class="customer-dashboard-notices">
                <div class="customer-dashboard-section-heading">
                    <div><span class="customer-dashboard-kicker">ACTUALIZACIONES</span><h2>Novedades para ti</h2></div>
                    <span class="customer-dashboard-count">{{ $unreadNotifications->count() }} nuevas</span>
                </div>
                <div class="customer-dashboard-notice-list">
                    @foreach($unreadNotifications as $notification)
                        <article class="customer-dashboard-notice">
                            <span><i class="fa-solid fa-bell" aria-hidden="true"></i></span>
                            <div><strong>{{ $notification->data['title'] ?? 'Aviso' }}</strong><p>{{ $notification->data['message'] ?? '' }}</p></div>
                            <time>{{ $notification->created_at->format('d/m/Y') }}</time>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        <section class="customer-dashboard-analytics" aria-label="Estado de actividad">
            <article class="customer-dashboard-panel customer-dashboard-chart-panel">
                <div class="customer-dashboard-section-heading">
                    <div><span class="customer-dashboard-kicker">TU ACTIVIDAD</span><h2>Solicitudes recientes</h2></div>
                    <span class="customer-dashboard-period"><i class="fa-regular fa-calendar" aria-hidden="true"></i> Últimos 6 meses</span>
                </div>
                <div class="customer-dashboard-chart-total"><strong>{{ number_format($stats['total_leads']) }}</strong><span>solicitudes en total</span></div>
                <div class="customer-chart" role="img" aria-label="Solicitudes agrupadas por mes">
                    @foreach($monthlyLeads as $month)
                        @php
                            $barHeight = max(5, (int) round($month['count'] / $monthlyMaximum * 100));
                        @endphp
                        <div class="customer-chart-column" title="{{ $month['label'] }}: {{ $month['count'] }}">
                            <strong>{{ $month['count'] }}</strong>
                            <span class="customer-chart-bar {{ $loop->last ? 'is-current' : '' }}" style="--bar-height:{{ $barHeight }}%"></span>
                            <small>{{ $month['label'] }}</small>
                        </div>
                    @endforeach
                </div>
            </article>

            <article class="customer-dashboard-panel customer-dashboard-status-panel">
                <div class="customer-dashboard-section-heading">
                    <div><span class="customer-dashboard-kicker">SEGUIMIENTO</span><h2>Estado de tus solicitudes</h2></div>
                    <span class="customer-dashboard-panel-icon"><i class="fa-solid fa-list-check" aria-hidden="true"></i></span>
                </div>
                <div class="customer-status-list">
                    @forelse($leadStatuses as $status)
                        @php
                            $percentage = (int) round($status->total / $statusTotal * 100);
                        @endphp
                        <div class="customer-status-row">
                            <span>{{ $status->status->label() }}</span>
                            <span class="customer-status-track"><span style="width:{{ $percentage }}%"></span></span>
                            <strong>{{ number_format($status->total) }}</strong>
                        </div>
                    @empty
                        <div class="customer-dashboard-empty"><i class="fa-regular fa-folder-open" aria-hidden="true"></i><span>Aún no tienes solicitudes.</span></div>
                    @endforelse
                </div>
                <a class="customer-dashboard-text-link" href="{{ route('customer.leads.index') }}">Consultar todas <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
            </article>
        </section>

        <section class="customer-dashboard-lists" aria-label="Próximas actividades">
            <article class="customer-dashboard-panel">
                <div class="customer-dashboard-section-heading">
                    <div><span class="customer-dashboard-kicker">AGENDA</span><h2>Próximas citas</h2></div>
                    <span class="customer-dashboard-panel-icon"><i class="fa-regular fa-calendar-check" aria-hidden="true"></i></span>
                </div>
                <div class="customer-dashboard-list">
                    @forelse($upcomingAppointments as $appointment)
                        <div class="customer-list-row">
                            <span class="customer-list-icon"><i class="fa-solid fa-calendar-day" aria-hidden="true"></i></span>
                            <div><strong>{{ $appointment->appointment_date->format('d/m/Y · H:i') }}</strong><small>{{ $appointment->lead?->address ?? 'Visita técnica' }}{{ $appointment->lead?->city ? ', '.$appointment->lead->city : '' }}</small></div>
                            <span class="admin-badge">{{ $appointment->status->label() }}</span>
                        </div>
                    @empty
                        <div class="customer-dashboard-empty"><i class="fa-regular fa-calendar" aria-hidden="true"></i><span>No tienes citas próximas.</span></div>
                    @endforelse
                </div>
            </article>

            <article class="customer-dashboard-panel">
                <div class="customer-dashboard-section-heading">
                    <div><span class="customer-dashboard-kicker">TU VIVIENDA</span><h2>Instalaciones recientes</h2></div>
                    <a class="customer-dashboard-text-link" href="{{ route('customer.installations.index') }}">Ver todas <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                </div>
                <div class="customer-dashboard-list">
                    @forelse($recentInstallations as $installation)
                        <a class="customer-list-row customer-list-link" href="{{ route('customer.installations.show', $installation) }}">
                            <span class="customer-list-icon"><i class="fa-solid fa-house-circle-check" aria-hidden="true"></i></span>
                            <div><strong>{{ $installation->service?->name ?? 'Instalación energética' }}</strong><small>{{ $installation->installation_date->format('d/m/Y') }}</small></div>
                            <span class="admin-badge">{{ $installation->status->label() }}</span>
                        </a>
                    @empty
                        <div class="customer-dashboard-empty"><i class="fa-solid fa-house" aria-hidden="true"></i><span>Todavía no hay instalaciones registradas.</span></div>
                    @endforelse
                </div>
            </article>
        </section>
    </div>
@endsection

@push('styles')
    <style>
        .customer-dashboard { --customer-ink:#24302d; --customer-muted:#89938e; --customer-line:#e4eae6; --customer-accent:#487e78; --customer-soft:#eaf3f1; }
        .customer-dashboard-header { display:flex; align-items:flex-end; justify-content:space-between; gap:18px; margin:0 0 21px; }
        .customer-dashboard-eyebrow { display:flex; align-items:center; gap:8px; color:#84928c; font-size:.59rem; font-weight:800; letter-spacing:.13em; }
        .customer-dashboard-eyebrow>span { width:7px; height:7px; border-radius:50%; background:#64968c; box-shadow:0 0 0 4px rgba(100,150,140,.13); }
        .customer-dashboard-heading h1 { margin:8px 0 4px; color:var(--customer-ink); font-size:clamp(1.7rem,2.7vw,2.35rem); font-weight:700; letter-spacing:-.05em; line-height:1.15; }
        .customer-dashboard-heading h1 span { color:#80a69e; font-size:.76em; }
        .customer-dashboard-heading p { margin:0; color:var(--customer-muted); font-size:.78rem; }
        .customer-dashboard-primary { min-height:40px; display:inline-flex; align-items:center; gap:8px; border:1px solid #3c726d; border-radius:11px; padding:0 14px; background:#3c726d; color:#fff!important; font-size:.68rem; font-weight:750; text-decoration:none; box-shadow:0 5px 13px rgba(60,114,109,.15); transition:transform .16s ease,background .16s ease; }
        .customer-dashboard-primary:hover { transform:translateY(-1px); background:#315f5b; }
        .customer-dashboard-summary { display:grid; grid-template-columns:minmax(245px,.8fr) minmax(0,1.7fr); gap:14px; margin-bottom:15px; }
        .customer-dashboard-hero { position:relative; min-height:292px; overflow:hidden; border-radius:20px; background:#294944; box-shadow:0 9px 26px rgba(37,71,63,.12); }
        .customer-dashboard-hero>img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; opacity:.42; }
        .customer-dashboard-hero-shade { position:absolute; inset:0; background:linear-gradient(110deg,rgba(32,66,59,.96) 0%,rgba(38,77,69,.81) 58%,rgba(40,76,68,.25) 100%); }
        .customer-dashboard-hero-content { position:relative; z-index:1; max-width:360px; padding:25px; }
        .customer-dashboard-hero-content>span { color:#d1e4dc; font-size:.52rem; font-weight:800; letter-spacing:.1em; }
        .customer-dashboard-hero-content>span i { margin-right:4px; }
        .customer-dashboard-hero-content h2 { margin:15px 0 8px; color:#fff; font-size:clamp(1.6rem,2.3vw,2.1rem); font-weight:650; letter-spacing:-.045em; line-height:1.12; }
        .customer-dashboard-hero-content p { max-width:280px; margin:0; color:#d6e0da; font-size:.68rem; line-height:1.65; }
        .customer-dashboard-hero-content>a { display:inline-flex; align-items:center; gap:9px; margin-top:17px; color:#fff; font-size:.63rem; font-weight:750; text-decoration:none; }
        .customer-dashboard-hero-content>a:hover { color:#c6e2d4; }
        .customer-dashboard-hero-mark { position:absolute; right:22px; bottom:17px; color:rgba(255,255,255,.2); font-size:2rem; }
        .customer-dashboard-stat-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:12px; }
        .customer-dashboard-stat { position:relative; min-height:139px; display:flex; flex-direction:column; align-items:flex-start; padding:16px 17px; border:1px solid #dfe7e2; border-radius:17px; background:#fbfcf9; box-shadow:0 6px 19px rgba(35,52,43,.04); }
        .customer-dashboard-stat-icon { position:absolute; top:15px; right:15px; width:32px; height:32px; display:grid; place-items:center; border-radius:11px; font-size:.73rem; }
        .customer-dashboard-stat-icon.is-blue { background:#e9eff3; color:#628096; }.customer-dashboard-stat-icon.is-amber { background:#f6f0e2; color:#a2874e; }.customer-dashboard-stat-icon.is-green { background:#e8f0e8; color:#63836b; }.customer-dashboard-stat-icon.is-teal { background:#e5f1ef; color:#4f8780; }
        .customer-dashboard-stat-label { margin-top:2px; color:#87928b; font-size:.62rem; font-weight:650; }
        .customer-dashboard-stat>strong { margin-top:12px; color:#303a34; font-size:1.65rem; font-weight:700; letter-spacing:-.05em; line-height:1; }
        .customer-dashboard-stat>strong small { color:#72837a; font-size:.66em; font-weight:600; }
        .customer-dashboard-stat>small { margin-top:7px; color:#9aa39c; font-size:.55rem; }
        .customer-dashboard-analytics,.customer-dashboard-lists { display:grid; grid-template-columns:minmax(0,1.35fr) minmax(280px,.9fr); gap:14px; margin-top:14px; }
        .customer-dashboard-panel,.customer-dashboard-notices { min-width:0; overflow:hidden; border:1px solid #dfe7e2; border-radius:18px; background:#fbfcf9; box-shadow:0 7px 22px rgba(35,52,43,.045); }
        .customer-dashboard-panel { padding:18px 19px; }
        .customer-dashboard-section-heading { display:flex; align-items:center; justify-content:space-between; gap:12px; }
        .customer-dashboard-section-heading h2 { margin:0; color:#303a34; font-size:.86rem; font-weight:700; letter-spacing:-.02em; }
        .customer-dashboard-kicker { display:block; margin-bottom:4px; color:#98a198; font-size:.5rem; font-weight:800; letter-spacing:.12em; }
        .customer-dashboard-period,.customer-dashboard-count { display:inline-flex; align-items:center; gap:6px; min-height:27px; padding:0 9px; border-radius:9px; background:#f0f3ef; color:#818b83; font-size:.53rem; font-weight:650; white-space:nowrap; }
        .customer-dashboard-chart-total { display:flex; align-items:baseline; gap:8px; margin:15px 0 0; }
        .customer-dashboard-chart-total strong { color:#34443b; font-size:1.3rem; font-weight:700; letter-spacing:-.04em; }
        .customer-dashboard-chart-total span { color:#939c94; font-size:.57rem; }
        .customer-chart { height:158px; display:grid; grid-template-columns:repeat(6,minmax(0,1fr)); align-items:end; gap:11px; margin-top:8px; padding:5px 5px 0; }
        .customer-chart-column { height:100%; display:flex; flex-direction:column; align-items:center; justify-content:flex-end; gap:6px; color:#949c94; font-size:.55rem; }
        .customer-chart-column>strong { color:#69766d; font-size:.57rem; font-weight:650; }
        .customer-chart-bar { width:min(30px,72%); height:var(--bar-height); min-height:5px; border-radius:7px 7px 2px 2px; background:#dfe8e2; transition:height .3s ease; }
        .customer-chart-bar.is-current { background:linear-gradient(180deg,#7fa99b,#4e7b72); }
        .customer-chart-column>small { color:#8d978f; font-size:.51rem; text-transform:capitalize; }
        .customer-dashboard-panel-icon { width:31px; height:31px; display:grid; place-items:center; border-radius:10px; background:#eaf2ef; color:#5f8c7d; font-size:.73rem; }
        .customer-status-list { display:grid; gap:14px; margin:22px 0 14px; }
        .customer-status-row { display:grid; grid-template-columns:minmax(75px,.8fr) minmax(55px,1fr) 24px; align-items:center; gap:9px; color:#69746b; font-size:.61rem; }
        .customer-status-row>strong { color:#455149; font-size:.65rem; text-align:right; }
        .customer-status-track { height:5px; overflow:hidden; border-radius:8px; background:#edf0eb; }
        .customer-status-track>span { display:block; height:100%; min-width:2px; border-radius:inherit; background:linear-gradient(90deg,#a8c5b5,#54877a); }
        .customer-dashboard-text-link { display:inline-flex; align-items:center; gap:7px; color:#588276!important; font-size:.58rem; font-weight:750; text-decoration:none; }
        .customer-dashboard-text-link:hover { color:#315f57!important; }
        .customer-dashboard-lists { grid-template-columns:repeat(2,minmax(0,1fr)); }
        .customer-dashboard-lists .customer-dashboard-panel { padding-bottom:10px; }
        .customer-dashboard-list { margin:13px -19px 0; }
        .customer-list-row { min-height:65px; display:flex; align-items:center; gap:11px; padding:10px 19px; border-top:1px solid #edf0eb; color:inherit; text-decoration:none; transition:background .15s ease; }
        .customer-list-icon { width:34px; height:34px; display:grid; flex:0 0 auto; place-items:center; border-radius:11px; background:#eaf2ef; color:#598478; font-size:.75rem; }
        .customer-list-row>div { display:grid; flex:1; min-width:0; gap:3px; }
        .customer-list-row strong { overflow:hidden; color:#3e4941; font-size:.65rem; font-weight:700; text-overflow:ellipsis; white-space:nowrap; }
        .customer-list-row small { overflow:hidden; color:#929b93; font-size:.55rem; text-overflow:ellipsis; white-space:nowrap; }
        .customer-list-row .admin-badge { flex:0 0 auto; font-size:.5rem; }
        .customer-list-link:hover { background:#f3f7f3; }
        .customer-dashboard-empty { min-height:100px; display:grid; justify-items:center; align-content:center; gap:8px; color:#929a92; font-size:.62rem; text-align:center; }
        .customer-dashboard-empty i { color:#82a194; font-size:1.1rem; }
        .customer-dashboard-notices { margin-bottom:14px; padding:17px 19px 8px; }
        .customer-dashboard-notice-list { margin-top:10px; }
        .customer-dashboard-notice { display:grid; grid-template-columns:32px minmax(0,1fr) auto; align-items:center; gap:10px; padding:10px 0; border-top:1px solid #edf0eb; }
        .customer-dashboard-notice>span { width:30px; height:30px; display:grid; place-items:center; border-radius:10px; background:#eaf2ef; color:#608b7d; font-size:.7rem; }
        .customer-dashboard-notice>div { min-width:0; }
        .customer-dashboard-notice strong { color:#3f4a42; font-size:.63rem; }
        .customer-dashboard-notice p { margin:2px 0 0; color:#858f87; font-size:.57rem; }
        .customer-dashboard-notice time { color:#929a92; font-size:.53rem; white-space:nowrap; }
        @media(max-width:950px) { .customer-dashboard-summary { grid-template-columns:minmax(230px,.8fr) minmax(0,1.2fr); } .customer-dashboard-hero-content { padding:20px; } .customer-dashboard-stat { min-height:132px; } }
        @media(max-width:760px) { .customer-dashboard-summary,.customer-dashboard-analytics,.customer-dashboard-lists { grid-template-columns:1fr; } .customer-dashboard-hero { min-height:245px; } .customer-dashboard-stat-grid { grid-template-columns:repeat(2,minmax(0,1fr)); } }
        @media(max-width:520px) { .customer-dashboard-header { align-items:flex-start; flex-direction:column; } .customer-dashboard-primary { width:100%; justify-content:center; } .customer-dashboard-panel { padding:16px; } .customer-dashboard-list { margin-right:-16px; margin-left:-16px; } .customer-list-row { padding-right:16px; padding-left:16px; } .customer-dashboard-stat { min-height:126px; padding:14px; } .customer-dashboard-stat>strong { font-size:1.45rem; } .customer-dashboard-notice { grid-template-columns:30px minmax(0,1fr); } .customer-dashboard-notice time { grid-column:2; } }
    </style>
@endpush
