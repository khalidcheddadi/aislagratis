@extends('layouts.admin')

@section('title', 'Panel de administración')

@section('content')
    @php
        $chartValues = $insights['monthly_leads']->values();
        $chartMax = max(1, (int) $chartValues->max('total'));
        $chartPoints = $chartValues->map(function (array $month, int $index) use ($chartValues, $chartMax) {
            $x = $chartValues->count() > 1 ? 30 + ($index * 660 / ($chartValues->count() - 1)) : 360;
            $y = 155 - ($month['total'] / $chartMax * 120);

            return ['x' => round($x, 1), 'y' => round($y, 1), 'label' => $month['label'], 'total' => $month['total']];
        });
        $linePath = $chartPoints->map(fn (array $point) => $point['x'].','.$point['y'])->implode(' ');
        $firstPoint = $chartPoints->first();
        $lastPoint = $chartPoints->last();
        $areaPath = $firstPoint
            ? 'M '.$firstPoint['x'].' 160 L '.$linePath.' L '.$lastPoint['x'].' 160 Z'
            : '';
        $topLocationTotal = max(1, (int) $insights['top_locations']->max('total'));
        $statusTotal = max(1, (int) $insights['lead_statuses']->sum('total'));
        $currentMonthLeads = (int) $chartValues->last()['total'];
        $previousMonthLeads = $chartValues->count() > 1 ? (int) $chartValues->get($chartValues->count() - 2)['total'] : 0;
        $leadTrend = $currentMonthLeads - $previousMonthLeads;
    @endphp

    <div class="admin-dashboard">
        <header class="dashboard-header">
            <div class="dashboard-heading">
                <span class="dashboard-eyebrow"><span class="dashboard-eyebrow-dot"></span> AISLAGRATIS <span>/</span> {{ auth()->user()->isSales() ? 'PANEL COMERCIAL' : 'CENTRO DE CONTROL' }}</span>
                <h1>Hola, {{ auth()->user()->first_name }} <span aria-hidden="true">✳</span></h1>
                <p>{{ auth()->user()->isSales() ? 'Organiza el seguimiento de solicitudes y coordina las próximas visitas.' : 'Un resumen sencillo de la actividad y el rendimiento de tu equipo.' }}</p>
            </div>
            <div class="dashboard-header-actions">
                <span class="dashboard-date"><i class="fa-regular fa-calendar" aria-hidden="true"></i>{{ now()->translatedFormat('d M Y') }}</span>
                @if(auth()->user()->role->value === 'admin')
                    <a class="dashboard-report-link" href="{{ route('admin.reports.index') }}"><i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i> Informes</a>
                @endif
            </div>
        </header>

        <section class="dashboard-top-grid" aria-label="Resumen principal">
            <article class="dashboard-card dashboard-summary-card">
                <div class="dashboard-card-topline">
                    <div><span class="dashboard-card-label">RESULTADO ACUMULADO</span><h2>Ahorro neto generado</h2></div>
                    <span class="dashboard-card-icon"><i class="fa-solid fa-wallet" aria-hidden="true"></i></span>
                </div>
                <div class="dashboard-total">{{ number_format($stats['revenue'], 0, ',', '.') }}<span>€</span></div>
                <div class="dashboard-summary-note"><span class="dashboard-check"><i class="fa-solid fa-check" aria-hidden="true"></i></span> En instalaciones completadas</div>
                <div class="dashboard-summary-divider"></div>
                <div class="dashboard-summary-stats">
                    <div><span>Clientes</span><strong>{{ number_format($stats['total_customers']) }}</strong></div>
                    <div><span>Solicitudes</span><strong>{{ number_format($stats['total_leads']) }}</strong></div>
                    <div><span>Instalaciones</span><strong>{{ number_format($stats['completed_installations']) }}</strong></div>
                </div>
                <svg class="dashboard-summary-sparkline" viewBox="0 0 160 56" aria-hidden="true">
                    <path d="M1 48 C19 45 18 32 35 38 S55 47 69 29 89 35 101 22 121 32 132 15 147 16 159 3" fill="none" stroke="#90aa96" stroke-width="2"/>
                    <path d="M1 48 C19 45 18 32 35 38 S55 47 69 29 89 35 101 22 121 32 132 15 147 16 159 3 L159 56 L1 56Z" fill="url(#summaryFill)" opacity=".55"/>
                    <defs><linearGradient id="summaryFill" x1="0" x2="0" y1="0" y2="1"><stop offset="0" stop-color="#90aa96"/><stop offset="1" stop-color="#fff"/></linearGradient></defs>
                </svg>
            </article>

            <article class="dashboard-card dashboard-status-card">
                <div class="dashboard-card-topline">
                    <div><span class="dashboard-card-label">EMBUDO COMERCIAL</span><h2>Solicitudes por estado</h2></div>
                    <a class="dashboard-card-more" href="{{ route('admin.leads.index') }}">Ver todas <i class="fa-solid fa-arrow-up-right-from-square" aria-hidden="true"></i></a>
                </div>
                <div class="dashboard-status-list">
                    @foreach($insights['lead_statuses'] as $index => $status)
                        @php
                            $percentage = (int) round($status['total'] / $statusTotal * 100);
                        @endphp
                        <a class="dashboard-status-row" href="{{ route('admin.leads.index', ['status' => $status['value']]) }}">
                            <span class="dashboard-status-symbol dashboard-status-symbol-{{ $index }}"><i class="{{ ['fa-solid fa-inbox', 'fa-regular fa-comment-dots', 'fa-solid fa-circle-check', 'fa-solid fa-circle-xmark', 'fa-solid fa-arrow-right-arrow-left'][$index % 5] }}" aria-hidden="true"></i></span>
                            <span class="dashboard-status-name">{{ $status['label'] }}<small>{{ $percentage }}% del total</small></span>
                            <span class="dashboard-status-track"><span style="width: {{ $percentage }}%"></span></span>
                            <strong>{{ number_format($status['total']) }}</strong>
                            <i class="fa-solid fa-chevron-right dashboard-row-chevron" aria-hidden="true"></i>
                        </a>
                    @endforeach
                </div>
                <div class="dashboard-status-footer"><span>Total de solicitudes</span><strong>{{ number_format($stats['total_leads']) }}</strong></div>
            </article>

            <div class="dashboard-side-stack">
                <article class="dashboard-card dashboard-month-card">
                    <div class="dashboard-card-topline">
                        <div><span class="dashboard-card-label">ÚLTIMOS 7 MESES</span><h2>Solicitudes recibidas</h2></div>
                        <span class="dashboard-month-icon"><i class="fa-solid fa-chart-column" aria-hidden="true"></i></span>
                    </div>
                    <div class="dashboard-month-total">{{ number_format($currentMonthLeads) }} <span>este mes</span></div>
                    <div class="dashboard-month-bars" role="img" aria-label="Solicitudes mensuales">
                        @foreach($chartValues as $month)
                            @php
                                $height = max(5, (int) round($month['total'] / $chartMax * 100));
                            @endphp
                            <div class="dashboard-month-column" title="{{ $month['label'] }}: {{ $month['total'] }}">
                                <span class="dashboard-month-bar {{ $loop->last ? 'is-current' : '' }}" style="--month-height: {{ $height }}%"></span>
                                <small>{{ $month['label'] }}</small>
                            </div>
                        @endforeach
                    </div>
                </article>

                <article class="dashboard-card dashboard-appointment-card">
                    <img src="{{ asset('images/image10-640.webp') }}" alt="" aria-hidden="true" loading="lazy" decoding="async">
                    <div class="dashboard-appointment-shade"></div>
                    <div class="dashboard-appointment-content">
                        <span><i class="fa-solid fa-leaf" aria-hidden="true"></i> EN MOVIMIENTO</span>
                        <h2>Hogares más eficientes</h2>
                        <p>{{ number_format($stats['pending_appointments']) }} citas pendientes de coordinar</p>
                        <a href="{{ route('admin.appointments.index') }}">Ver agenda <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
                    </div>
                    <span class="dashboard-appointment-icon"><i class="fa-solid fa-calendar-check" aria-hidden="true"></i></span>
                </article>
            </div>
        </section>

        <section class="dashboard-lower-grid" aria-label="Análisis detallado">
            <article class="dashboard-card dashboard-trend-card">
                <div class="dashboard-card-topline dashboard-trend-heading">
                    <div><span class="dashboard-card-label">TENDENCIA DE ACTIVIDAD</span><h2>Dinámica de solicitudes</h2></div>
                    <div class="dashboard-trend-controls">
                        <span class="dashboard-period"><i class="fa-regular fa-calendar" aria-hidden="true"></i> Últimos 7 meses</span>
                        <span class="dashboard-trend-delta {{ $leadTrend < 0 ? 'is-negative' : '' }}"><i class="fa-solid {{ $leadTrend < 0 ? 'fa-arrow-down' : 'fa-arrow-up' }}" aria-hidden="true"></i>{{ $leadTrend > 0 ? '+' : '' }}{{ $leadTrend }} <small>vs. mes anterior</small></span>
                    </div>
                </div>
                <div class="dashboard-trend-summary"><strong>{{ number_format($currentMonthLeads) }}</strong><span>solicitudes este mes</span></div>
                <div class="dashboard-trend-chart">
                    <svg viewBox="0 0 720 180" role="img" aria-label="Evolución mensual de solicitudes">
                        <defs>
                            <linearGradient id="trendFill" x1="0" x2="0" y1="0" y2="1">
                                <stop offset="0%" stop-color="#688675" stop-opacity=".36"/>
                                <stop offset="100%" stop-color="#688675" stop-opacity=".015"/>
                            </linearGradient>
                        </defs>
                        @foreach([35, 75, 115, 155] as $gridY)
                            <line x1="30" y1="{{ $gridY }}" x2="690" y2="{{ $gridY }}" stroke="#e9ebe5" stroke-dasharray="3 7"/>
                        @endforeach
                        @if($chartPoints->isNotEmpty())
                            <path d="{{ $areaPath }}" fill="url(#trendFill)"/>
                            <polyline points="{{ $linePath }}" fill="none" stroke="#496956" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            @foreach($chartPoints as $index => $point)
                                <circle cx="{{ $point['x'] }}" cy="{{ $point['y'] }}" r="{{ $index === $chartPoints->count() - 1 ? 5 : 3.5 }}" fill="{{ $index === $chartPoints->count() - 1 ? '#496956' : '#fff' }}" stroke="#496956" stroke-width="2"/>
                            @endforeach
                        @endif
                    </svg>
                    <div class="dashboard-chart-labels">
                        @foreach($chartPoints as $point)
                            <span>{{ $point['label'] }}</span>
                        @endforeach
                    </div>
                </div>
            </article>

            <article class="dashboard-card dashboard-locations-card">
                <div class="dashboard-card-topline">
                    <div><span class="dashboard-card-label">COBERTURA</span><h2>Volumen por provincia</h2></div>
                    <span class="dashboard-location-icon"><i class="fa-solid fa-location-dot" aria-hidden="true"></i></span>
                </div>
                @if($insights['top_locations']->isEmpty())
                    <div class="dashboard-empty-locations"><i class="fa-solid fa-map-location-dot" aria-hidden="true"></i><span>Las provincias aparecerán aquí al recibir solicitudes.</span></div>
                @else
                    <div class="dashboard-location-list">
                        @foreach($insights['top_locations'] as $index => $location)
                            <div class="dashboard-location-row">
                                <span class="dashboard-location-index">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                <div class="dashboard-location-content">
                                    <div><strong>{{ $location['name'] }}</strong><span>{{ number_format($location['total']) }}</span></div>
                                    <span class="dashboard-location-track"><span style="width: {{ (int) round($location['total'] / $topLocationTotal * 100) }}%"></span></span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <a class="dashboard-location-link" href="{{ route('admin.leads.index') }}">Explorar solicitudes <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></a>
            </article>
        </section>

        @if($unreadNotifications->isNotEmpty())
            <section class="admin-panel dashboard-notifications">
                <div class="admin-panel-head"><h2><i class="fa-solid fa-bell" style="color:var(--admin-green)" aria-hidden="true"></i> Avisos sin leer</h2><a href="{{ route('admin.notifications.index') }}" class="dashboard-card-more">Todos los avisos</a></div>
                <div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Aviso</th><th>Fecha</th><th></th></tr></thead><tbody>
                    @foreach($unreadNotifications as $notification)
                        <tr>
                            <td><strong>{{ $notification->data['title'] ?? 'Aviso' }}</strong><br><span style="color:var(--admin-muted)">{{ $notification->data['message'] ?? '' }}</span></td>
                            <td>{{ $notification->created_at->format('d/m/Y H:i') }}</td>
                            <td><form method="POST" action="{{ route('admin.notifications.read', $notification) }}">@csrf<button class="admin-button" type="submit"><i class="fa-solid fa-check" aria-hidden="true"></i> Marcar leído</button></form></td>
                        </tr>
                    @endforeach
                </tbody></table></div>
            </section>
        @endif

        <section class="admin-panel dashboard-recent-panel">
            <div class="admin-panel-head">
                <div><h2><i class="fa-solid fa-inbox" style="color:var(--admin-green)" aria-hidden="true"></i> Solicitudes recientes</h2><span class="dashboard-recent-caption">Las últimas solicitudes recibidas por el equipo</span></div>
                <a href="{{ route('admin.leads.index') }}" class="admin-button"><i class="fa-solid fa-arrow-right" aria-hidden="true"></i> Ver todas</a>
            </div>
            @if($recentLeads->isEmpty())
                <div class="admin-empty"><i class="fa-regular fa-folder-open" aria-hidden="true"></i>No hay solicitudes registradas.</div>
            @else
                <div class="admin-table-wrap"><table class="admin-table">
                    <thead><tr><th>Fecha</th><th>Nombre</th><th>Contacto</th><th>Ubicación</th><th>Tipo de inmueble</th><th>Estado</th><th></th></tr></thead>
                    <tbody>
                        @foreach($recentLeads as $lead)
                            @php
                                $status = $lead->status->value;
                                $badge = match($status) { 'contactado' => 'admin-badge-warning', 'descartado' => 'admin-badge-danger', 'nuevo' => 'admin-badge-neutral', default => 'admin-badge' };
                            @endphp
                            <tr>
                                <td style="white-space:nowrap">{{ $lead->created_at->format('d/m/Y H:i') }}</td>
                                <td><strong>{{ $lead->full_name }}</strong></td>
                                <td>{{ $lead->email }}@if($lead->phone)<br><span style="color:var(--admin-muted)">{{ $lead->phone }}</span>@endif</td>
                                <td>{{ $lead->city ?? '—' }}@if($lead->postal_code), {{ $lead->postal_code }}@endif</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $lead->property_type->value)) }}</td>
                                <td><span class="admin-badge {{ $badge }}">{{ ucfirst($status) }}</span></td>
                                <td><a class="admin-button" href="{{ route('admin.leads.show', $lead) }}" title="Ver solicitud"><i class="fa-solid fa-eye" aria-hidden="true"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table></div>
            @endif
        </section>
    </div>
@endsection

@push('styles')
    <style>
        .site-admin:has(.admin-dashboard) { background:#e9eae5; }
        .site-admin:has(.admin-dashboard) .admin-topbar,
        .site-admin:has(.admin-dashboard) .admin-nav-wrap { background:#f4f4f0; border-color:#dddfd8; }
        .site-admin:has(.admin-dashboard) .admin-main { width:min(1580px,100%); padding:30px clamp(16px,3vw,42px) 58px; }
        .admin-dashboard { --dash-ink:#202520; --dash-muted:#838981; --dash-line:#e9e9e3; --dash-green:#526e5d; --dash-soft:#f0f0eb; color:var(--dash-ink); }
        .dashboard-header { display:flex; align-items:flex-end; justify-content:space-between; gap:20px; margin:0 0 23px; }
        .dashboard-heading { min-width:0; }
        .dashboard-eyebrow { display:flex; align-items:center; gap:8px; color:#7f887f; font-size:.62rem; font-weight:800; letter-spacing:.13em; }
        .dashboard-eyebrow>span:nth-child(2) { color:#b5bbb2; }
        .dashboard-eyebrow-dot { width:7px; height:7px; border-radius:50%; background:#78917d; box-shadow:0 0 0 4px rgba(120,145,125,.13); }
        .dashboard-header h1 { margin:8px 0 4px; color:#202520; font-size:clamp(1.7rem,2.7vw,2.35rem); font-weight:650; letter-spacing:-.055em; line-height:1.15; }
        .dashboard-header h1 span { color:#819687; font-size:.76em; }
        .dashboard-header p { margin:0; color:#858b83; font-size:.79rem; }
        .dashboard-header-actions { display:flex; align-items:center; gap:9px; }
        .dashboard-date,.dashboard-report-link { min-height:39px; display:inline-flex; align-items:center; gap:8px; padding:0 13px; border:1px solid #dfe1da; border-radius:12px; background:#f8f8f5; color:#566057; font-size:.69rem; font-weight:700; white-space:nowrap; }
        .dashboard-date i { color:#879388; }
        .dashboard-report-link { border-color:#26352d; background:#26352d; color:#fff; text-decoration:none; transition:background .18s ease, transform .18s ease; }
        .dashboard-report-link:hover { transform:translateY(-1px); background:#354a3e; }
        .dashboard-top-grid { display:grid; grid-template-columns:minmax(0,1.05fr) minmax(0,1.16fr) minmax(245px,.73fr); align-items:stretch; gap:15px; }
        .dashboard-card { min-width:0; overflow:hidden; border:1px solid rgba(220,222,215,.85); border-radius:22px; background:#fbfbf8; box-shadow:0 8px 24px rgba(36,43,35,.055); }
        .dashboard-summary-card,.dashboard-status-card,.dashboard-month-card { padding:20px; }
        .dashboard-summary-card { position:relative; min-height:324px; background:linear-gradient(145deg,#fff 0%,#fafaf7 72%,#f0f1eb 100%); }
        .dashboard-card-topline { position:relative; z-index:1; display:flex; align-items:center; justify-content:space-between; gap:12px; }
        .dashboard-card-label { display:block; margin-bottom:5px; color:#93988f; font-size:.55rem; font-weight:800; letter-spacing:.13em; }
        .dashboard-card-topline h2 { margin:0; color:#252a25; font-size:.91rem; font-weight:650; letter-spacing:-.025em; }
        .dashboard-card-icon,.dashboard-month-icon,.dashboard-location-icon { width:34px; height:34px; display:grid; flex:0 0 auto; place-items:center; border-radius:12px; background:#eef0e9; color:#5f7966; font-size:.8rem; }
        .dashboard-total { position:relative; z-index:1; margin:27px 0 4px; color:#242824; font-size:clamp(2.2rem,4vw,3.3rem); font-weight:650; letter-spacing:-.075em; line-height:1; }
        .dashboard-total span { margin-left:3px; color:#7e877e; font-size:.55em; font-weight:550; }
        .dashboard-summary-note { position:relative; z-index:1; display:flex; align-items:center; gap:7px; color:#899087; font-size:.64rem; }
        .dashboard-check { width:17px; height:17px; display:grid; place-items:center; border-radius:50%; background:#e7efe7; color:#557b5f; font-size:.53rem; }
        .dashboard-summary-divider { height:1px; margin:23px 0 17px; background:#e8e9e3; }
        .dashboard-summary-stats { position:relative; z-index:1; display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:10px; }
        .dashboard-summary-stats>div { display:grid; gap:4px; }
        .dashboard-summary-stats span { color:#90968e; font-size:.59rem; }
        .dashboard-summary-stats strong { color:#343a34; font-size:1.16rem; font-weight:650; }
        .dashboard-summary-sparkline { position:absolute; right:14px; bottom:14px; width:126px; height:44px; opacity:.5; }
        .dashboard-status-card { min-height:324px; padding-bottom:16px; }
        .dashboard-card-more { display:inline-flex; align-items:center; gap:7px; color:#7a8179; font-size:.62rem; font-weight:700; text-decoration:none; white-space:nowrap; }
        .dashboard-card-more:hover { color:#47644f; }
        .dashboard-card-more i { font-size:.58rem; }
        .dashboard-status-list { display:grid; gap:5px; margin:18px 0 12px; }
        .dashboard-status-row { display:grid; grid-template-columns:34px minmax(80px,1fr) minmax(50px,.85fr) 30px 9px; align-items:center; gap:9px; min-height:43px; padding:4px 3px; border-radius:11px; color:inherit; text-decoration:none; transition:background .16s ease; }
        .dashboard-status-row:hover { background:#f2f3ee; }
        .dashboard-status-symbol { width:31px; height:31px; display:grid; place-items:center; border-radius:10px; background:#e9eee8; color:#657c69; font-size:.71rem; }
        .dashboard-status-symbol-1 { background:#eeece3; color:#8d8061; }.dashboard-status-symbol-2 { background:#e7efe9; color:#567d61; }.dashboard-status-symbol-3 { background:#f2e9e5; color:#a16f62; }.dashboard-status-symbol-4 { background:#e9ebef; color:#69778a; }
        .dashboard-status-name { min-width:0; overflow:hidden; color:#4a514a; font-size:.66rem; font-weight:650; text-overflow:ellipsis; white-space:nowrap; }
        .dashboard-status-name small { display:block; margin-top:2px; color:#9a9f97; font-size:.53rem; font-weight:500; }
        .dashboard-status-track,.dashboard-location-track { display:block; height:5px; overflow:hidden; border-radius:9px; background:#eceee8; }
        .dashboard-status-track>span,.dashboard-location-track>span { display:block; height:100%; min-width:2px; border-radius:inherit; background:linear-gradient(90deg,#aebead,#607a66); }
        .dashboard-status-row>strong { color:#404740; font-size:.68rem; font-weight:700; text-align:right; }
        .dashboard-row-chevron { color:#b1b5ad; font-size:.52rem; }
        .dashboard-status-footer { display:flex; justify-content:space-between; margin-top:12px; padding-top:11px; border-top:1px solid #ebebe6; color:#8d938b; font-size:.61rem; }
        .dashboard-status-footer strong { color:#424941; font-size:.7rem; }
        .dashboard-side-stack { display:grid; grid-template-rows:minmax(0,1fr) minmax(130px,.76fr); gap:15px; min-height:324px; }
        .dashboard-month-card { min-height:174px; padding:17px 18px 13px; }
        .dashboard-month-icon { width:30px; height:30px; font-size:.7rem; }
        .dashboard-month-total { display:flex; align-items:baseline; gap:7px; margin:14px 0 5px; color:#303630; font-size:1.45rem; font-weight:650; letter-spacing:-.045em; }
        .dashboard-month-total span { color:#969b93; font-size:.56rem; font-weight:500; letter-spacing:0; }
        .dashboard-month-bars { height:63px; display:grid; grid-template-columns:repeat(7,minmax(0,1fr)); align-items:end; gap:8px; padding-top:3px; }
        .dashboard-month-column { height:100%; display:flex; flex-direction:column; align-items:center; justify-content:flex-end; gap:5px; }
        .dashboard-month-bar { display:block; width:100%; max-width:20px; height:var(--month-height); min-height:4px; border-radius:7px 7px 3px 3px; background:#e6e8e1; }
        .dashboard-month-bar.is-current { background:linear-gradient(180deg,#728b79,#3e5a48); }
        .dashboard-month-column small { color:#969b93; font-size:.48rem; text-transform:capitalize; }
        .dashboard-appointment-card { position:relative; min-height:135px; overflow:hidden; background:#26392f; color:#fff; }
        .dashboard-appointment-card>img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; opacity:.38; }
        .dashboard-appointment-shade { position:absolute; inset:0; background:linear-gradient(110deg,rgba(26,44,34,.97) 0%,rgba(26,44,34,.76) 58%,rgba(26,44,34,.25) 100%); }
        .dashboard-appointment-content { position:relative; z-index:1; padding:17px 18px; }
        .dashboard-appointment-content>span { color:#c0d0c1; font-size:.51rem; font-weight:800; letter-spacing:.12em; }
        .dashboard-appointment-content>span i { margin-right:4px; }
        .dashboard-appointment-content h2 { margin:7px 0 3px; color:#fff; font-size:.91rem; font-weight:650; }
        .dashboard-appointment-content p { margin:0; color:#d0d8d0; font-size:.57rem; }
        .dashboard-appointment-content>a { display:inline-flex; align-items:center; gap:8px; margin-top:10px; color:#f2f4ef; font-size:.57rem; font-weight:750; text-decoration:none; }
        .dashboard-appointment-content>a:hover { color:#b7d2bb; }
        .dashboard-appointment-icon { position:absolute; right:17px; bottom:14px; color:rgba(255,255,255,.25); font-size:1.5rem; }
        .dashboard-lower-grid { display:grid; grid-template-columns:minmax(0,1.55fr) minmax(285px,.85fr); gap:15px; margin-top:15px; }
        .dashboard-trend-card,.dashboard-locations-card { min-height:297px; padding:20px 21px 17px; }
        .dashboard-trend-heading { align-items:flex-start; }
        .dashboard-trend-controls { display:flex; align-items:center; justify-content:flex-end; gap:8px; }
        .dashboard-period,.dashboard-trend-delta { min-height:29px; display:inline-flex; align-items:center; gap:6px; padding:0 9px; border:1px solid #e8e9e3; border-radius:9px; background:#f8f8f5; color:#788078; font-size:.55rem; font-weight:650; white-space:nowrap; }
        .dashboard-period i { color:#939b91; }
        .dashboard-trend-delta { border-color:#e4ece4; background:#eef3ed; color:#56765e; }
        .dashboard-trend-delta.is-negative { border-color:#f0e2de; background:#f8eeeb; color:#a36d62; }
        .dashboard-trend-delta small { color:#8a9389; font-size:.49rem; font-weight:500; }
        .dashboard-trend-summary { display:flex; align-items:baseline; gap:8px; margin-top:17px; }
        .dashboard-trend-summary strong { color:#2f352f; font-size:1.5rem; font-weight:650; letter-spacing:-.05em; }
        .dashboard-trend-summary span { color:#93988f; font-size:.6rem; }
        .dashboard-trend-chart { margin-top:3px; }
        .dashboard-trend-chart svg { display:block; width:100%; height:151px; overflow:visible; }
        .dashboard-chart-labels { display:grid; grid-template-columns:repeat(7,1fr); margin:0 2.8%; color:#92988f; font-size:.52rem; text-align:center; text-transform:capitalize; }
        .dashboard-locations-card { display:flex; flex-direction:column; }
        .dashboard-location-icon { background:#ecefe8; color:#738477; }
        .dashboard-location-list { display:grid; gap:15px; margin:25px 0 14px; }
        .dashboard-location-row { display:grid; grid-template-columns:26px minmax(0,1fr); align-items:center; gap:9px; }
        .dashboard-location-index { color:#a4a89f; font-size:.55rem; font-weight:800; }
        .dashboard-location-content { display:grid; gap:7px; min-width:0; }
        .dashboard-location-content>div { display:flex; align-items:center; justify-content:space-between; gap:10px; }
        .dashboard-location-content strong { overflow:hidden; color:#515851; font-size:.66rem; font-weight:650; text-overflow:ellipsis; white-space:nowrap; }
        .dashboard-location-content>div>span { color:#707970; font-size:.61rem; font-weight:700; }
        .dashboard-location-track { height:5px; }
        .dashboard-location-track>span { background:linear-gradient(90deg,#bac8b8,#687f6b); }
        .dashboard-location-link { display:flex; align-items:center; justify-content:space-between; gap:8px; margin-top:auto; padding-top:12px; border-top:1px solid #ebebe6; color:#6f7f71; font-size:.59rem; font-weight:700; text-decoration:none; }
        .dashboard-location-link:hover { color:#344f3c; }
        .dashboard-empty-locations { display:grid; flex:1; align-content:center; justify-items:center; gap:10px; min-height:120px; color:#8a9088; font-size:.65rem; text-align:center; }
        .dashboard-empty-locations i { color:#809984; font-size:1.2rem; }
        .dashboard-notifications { margin-top:17px; }
        .dashboard-recent-panel { margin-top:17px; border-radius:19px; }
        .dashboard-recent-caption { display:block; margin:4px 0 0 25px; color:#8c928a; font-size:.61rem; font-weight:500; }
        .admin-role-sales .admin-dashboard { --dash-green:#527c88; }
        .admin-role-sales .admin-dashboard .dashboard-summary-card { background:linear-gradient(145deg,#fff 0%,#f7faf9 72%,#edf3f3 100%); }
        .admin-role-sales .admin-dashboard .dashboard-card-icon,
        .admin-role-sales .admin-dashboard .dashboard-month-icon,
        .admin-role-sales .admin-dashboard .dashboard-location-icon { background:#e9f1f2; color:#527c88; }
        .admin-role-sales .admin-dashboard .dashboard-month-bar.is-current { background:linear-gradient(180deg,#7fa1a8,#4d737d); }
        .admin-role-sales .admin-dashboard .dashboard-status-track>span,
        .admin-role-sales .admin-dashboard .dashboard-location-track>span { background:linear-gradient(90deg,#b2c9c9,#62858c); }
        .admin-role-sales .admin-dashboard .dashboard-trend-card svg polyline { stroke:#577d83; }
        .admin-role-sales .admin-dashboard .dashboard-trend-card svg circle { stroke:#577d83; }
        .admin-role-sales .admin-dashboard .dashboard-trend-card svg path[fill="url(#trendFill)"] { fill:rgba(95,143,148,.22); }
        @media(max-width:1120px) {
            .dashboard-top-grid { grid-template-columns:minmax(0,1fr) minmax(0,1fr); }
            .dashboard-summary-card,.dashboard-status-card { min-height:315px; }
            .dashboard-side-stack { grid-column:1 / -1; grid-template-columns:minmax(0,1fr) minmax(0,1fr); grid-template-rows:180px; min-height:0; }
        }
        @media(max-width:760px) {
            .site-admin:has(.admin-dashboard) .admin-main { padding-top:23px; }
            .dashboard-header { align-items:flex-start; flex-direction:column; gap:14px; }
            .dashboard-header-actions { width:100%; justify-content:space-between; }
            .dashboard-top-grid,.dashboard-lower-grid { grid-template-columns:minmax(0,1fr); }
            .dashboard-summary-card,.dashboard-status-card { min-height:0; }
            .dashboard-summary-card { min-height:275px; }
            .dashboard-side-stack { grid-column:auto; grid-template-columns:minmax(0,1fr); grid-template-rows:auto; }
            .dashboard-month-card { min-height:180px; }
            .dashboard-appointment-card { min-height:155px; }
            .dashboard-trend-card,.dashboard-locations-card { min-height:270px; }
        }
        @media(max-width:500px) {
            .dashboard-header h1 { font-size:1.8rem; }
            .dashboard-summary-card,.dashboard-status-card,.dashboard-trend-card,.dashboard-locations-card { padding:17px; border-radius:18px; }
            .dashboard-total { margin-top:23px; font-size:2.55rem; }
            .dashboard-summary-sparkline { width:95px; opacity:.35; }
            .dashboard-status-row { grid-template-columns:31px minmax(75px,1fr) minmax(38px,.7fr) 26px 7px; gap:6px; }
            .dashboard-trend-heading { flex-direction:column; }
            .dashboard-trend-controls { width:100%; justify-content:space-between; }
            .dashboard-trend-chart svg { height:135px; }
            .dashboard-appointment-content { padding:17px; }
        }
    </style>
@endpush
