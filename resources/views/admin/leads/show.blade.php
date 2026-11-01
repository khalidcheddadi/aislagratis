@extends('layouts.admin')
@section('title', 'Solicitud #'.$lead->id)
@section('content')
    @php
        $status = $lead->status;
        $propertyDetails = [
            ['Tipo de inmueble', $lead->property_type->label(), 'fa-house'],
            ['Superficie', $lead->area_m2 ? $lead->area_m2.' m²' : null, 'fa-ruler-combined'],
            ['Año de construcción', $lead->year_built, 'fa-calendar'],
            ['Acceso registrado', $lead->access_type?->label(), 'fa-stairs'],
            ['Buhardilla', $lead->has_attic ? 'Sí' : 'No', 'fa-house-chimney'],
            ['Sótano', $lead->has_basement ? 'Sí' : 'No', 'fa-warehouse'],
            ['Zona cubierta', $lead->is_covered ? 'Sí' : 'No', 'fa-map-location-dot'],
        ];
        $eligibilityDetails = [
            ['¿Es propietario?', is_null($lead->is_owner) ? null : ($lead->is_owner ? 'Sí' : 'No')],
            ['Tipo indicado', $lead->eligibility_property_kind],
            ['Zona que desea aislar', $lead->eligibility_zone],
            ['Acceso a la zona', $lead->eligibility_access],
            ['¿El desván es habitable?', $lead->eligibility_habitable],
            ['Antigüedad aproximada', $lead->eligibility_age],
            ['Ayudas o actuaciones previas', $lead->eligibility_prior_aid],
            ['Preferencia de contacto', $lead->contact_preference],
            ['Referencia catastral', $lead->cadastral_reference],
            ['Aceptación de privacidad', $lead->privacy_accepted_at?->format('d/m/Y · H:i')],
        ];
    @endphp

    <div class="lead-detail-page">
        <nav class="lead-detail-breadcrumb" aria-label="Ruta de navegación">
            <a href="{{ route('admin.dashboard') }}">Administración</a>
            <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
            <a href="{{ route('admin.leads.index') }}">Solicitudes</a>
            <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
            <span>Solicitud #{{ $lead->id }}</span>
        </nav>

        <header class="lead-detail-hero">
            <div class="lead-detail-hero-main">
                <span class="lead-detail-eyebrow"><i class="fa-solid fa-sparkles" aria-hidden="true"></i> ESTUDIO DE VIVIENDA · #{{ $lead->id }}</span>
                <h1>{{ $lead->full_name }}</h1>
                <p>{{ $lead->service?->name ?? 'Solicitud de estudio energético' }} <span aria-hidden="true">·</span> Recibida el {{ $lead->created_at->format('d/m/Y · H:i') }}</p>
                <div class="lead-detail-hero-meta">
                    <span><i class="fa-solid fa-location-dot" aria-hidden="true"></i> {{ collect([$lead->city, $lead->province])->filter()->implode(', ') ?: 'Ubicación pendiente' }}{{ $lead->postal_code ? ' · '.$lead->postal_code : '' }}</span>
                    <span><i class="fa-solid fa-house" aria-hidden="true"></i> {{ $lead->property_type->label() }}</span>
                </div>
            </div>
            <div class="lead-detail-hero-actions">
                <span class="lead-detail-status"><span></span>{{ $status->label() }}</span>
                <a class="admin-button lead-excel-button" href="{{ route('admin.leads.export', $lead) }}">
                    <i class="fa-solid fa-file-excel" aria-hidden="true"></i> Descargar Excel
                </a>
                <a class="admin-button admin-button-primary" href="{{ route('admin.appointments.create', ['lead_id' => $lead->id]) }}">
                    <i class="fa-solid fa-calendar-plus" aria-hidden="true"></i> Programar cita
                </a>
            </div>
            <div class="lead-detail-hero-glow" aria-hidden="true"></div>
        </header>

        <section class="lead-detail-quick-grid" aria-label="Resumen de contacto">
            <article class="lead-detail-quick-card">
                <span class="lead-detail-quick-icon"><i class="fa-solid fa-envelope" aria-hidden="true"></i></span>
                <div><small>Correo electrónico</small><a href="mailto:{{ $lead->email }}">{{ $lead->email }}</a></div>
                <i class="fa-solid fa-arrow-up-right-from-square lead-detail-card-arrow" aria-hidden="true"></i>
            </article>
            <article class="lead-detail-quick-card">
                <span class="lead-detail-quick-icon"><i class="fa-solid fa-phone" aria-hidden="true"></i></span>
                <div><small>Teléfono de contacto</small>
                    @if($lead->phone)
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $lead->phone) }}">{{ $lead->phone }}</a>
                    @else
                        <strong>Sin teléfono</strong>
                    @endif
                </div>
                <i class="fa-solid fa-arrow-up-right-from-square lead-detail-card-arrow" aria-hidden="true"></i>
            </article>
            <article class="lead-detail-quick-card">
                <span class="lead-detail-quick-icon"><i class="fa-solid fa-location-dot" aria-hidden="true"></i></span>
                <div><small>Localidad</small><strong>{{ $lead->location ?: 'No indicada' }}</strong></div>
                <i class="fa-solid fa-map lead-detail-card-arrow" aria-hidden="true"></i>
            </article>
        </section>

        <div class="lead-detail-layout">
            <main class="lead-detail-main-column">
                <section class="lead-detail-card">
                    <header class="lead-detail-card-heading">
                        <span class="lead-detail-section-icon"><i class="fa-solid fa-clipboard-list" aria-hidden="true"></i></span>
                        <div><h2>Respuestas del estudio CAE</h2><p>Información facilitada por el cliente en el formulario</p></div>
                        <span class="lead-detail-section-count">{{ count(array_filter($eligibilityDetails, fn ($item) => filled($item[1]))) }} respuestas</span>
                    </header>
                    <dl class="lead-detail-answer-grid">
                        @foreach($eligibilityDetails as [$label, $value])
                            <div class="lead-detail-answer">
                                <dt>{{ $label }}</dt>
                                <dd class="{{ filled($value) ? '' : 'is-empty' }}">
                                    @if($label === 'Aceptación de privacidad' && filled($value))
                                        <span class="lead-detail-privacy-check"><i class="fa-solid fa-check" aria-hidden="true"></i></span>
                                    @endif
                                    {{ $value ?: 'No facilitado' }}
                                </dd>
                            </div>
                        @endforeach
                    </dl>
                </section>

                <section class="lead-detail-card">
                    <header class="lead-detail-card-heading">
                        <span class="lead-detail-section-icon"><i class="fa-solid fa-house-chimney-window" aria-hidden="true"></i></span>
                        <div><h2>Características del inmueble</h2><p>Datos técnicos y ubicación de la vivienda</p></div>
                    </header>
                    <dl class="lead-detail-property-grid">
                        @foreach($propertyDetails as [$label, $value, $icon])
                            <div class="lead-detail-property-item">
                                <span class="lead-detail-property-icon"><i class="fa-solid {{ $icon }}" aria-hidden="true"></i></span>
                                <div><dt>{{ $label }}</dt><dd>{{ $value ?? 'No indicado' }}</dd></div>
                            </div>
                        @endforeach
                    </dl>
                    <div class="lead-detail-address">
                        <i class="fa-solid fa-map-location-dot" aria-hidden="true"></i>
                        <div><small>Dirección del inmueble</small><strong>{{ collect([$lead->address, $lead->postal_code, $lead->city, $lead->province])->filter()->implode(', ') ?: 'No indicada' }}</strong></div>
                    </div>
                </section>

                <section class="lead-detail-card">
                    <header class="lead-detail-card-heading">
                        <span class="lead-detail-section-icon"><i class="fa-solid fa-comment-dots" aria-hidden="true"></i></span>
                        <div><h2>Mensaje del cliente</h2><p>Comentarios y detalles adicionales</p></div>
                    </header>
                    @if(filled($lead->message))
                        <blockquote class="lead-detail-message">{{ $lead->message }}</blockquote>
                    @else
                        <div class="lead-detail-empty-message"><i class="fa-regular fa-message" aria-hidden="true"></i> El cliente no añadió comentarios adicionales.</div>
                    @endif
                </section>

                <section class="lead-detail-card">
                    <header class="lead-detail-card-heading">
                        <span class="lead-detail-section-icon"><i class="fa-solid fa-calendar-check" aria-hidden="true"></i></span>
                        <div><h2>Citas asociadas</h2><p>Seguimiento de las visitas programadas</p></div>
                        @if($lead->appointments->isNotEmpty())
                            <span class="lead-detail-section-count">{{ $lead->appointments->count() }} citas</span>
                        @endif
                    </header>
                    @if($lead->appointments->isEmpty())
                        <div class="lead-detail-empty-message"><i class="fa-regular fa-calendar" aria-hidden="true"></i> Todavía no hay citas asociadas a esta solicitud.</div>
                    @else
                        <div class="admin-table-wrap">
                            <table class="admin-table">
                                <thead><tr><th>Fecha</th><th>Técnico</th><th>Estado</th><th>Notas</th></tr></thead>
                                <tbody>
                                    @foreach($lead->appointments as $appointment)
                                        <tr>
                                            <td>{{ $appointment->appointment_date->format('d/m/Y · H:i') }}</td>
                                            <td>{{ $appointment->technician?->full_name ?? 'Sin asignar' }}</td>
                                            <td>{{ $appointment->status->label() }}</td>
                                            <td>{{ $appointment->notes ?: '—' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </section>
            </main>

            <aside class="lead-detail-side-column">
                <section class="lead-detail-card lead-detail-followup">
                    <header class="lead-detail-card-heading">
                        <span class="lead-detail-section-icon"><i class="fa-solid fa-arrows-rotate" aria-hidden="true"></i></span>
                        <div><h2>Estado y seguimiento</h2><p>Actualiza el progreso de esta solicitud</p></div>
                    </header>
                    <form method="POST" action="{{ route('admin.leads.status', $lead) }}" class="lead-detail-status-form">
                        @csrf
                        @method('PATCH')
                        <label for="lead-status">Estado actual</label>
                        <select id="lead-status" name="status">
                            @foreach(\App\Enums\LeadStatus::cases() as $option)
                                <option value="{{ $option->value }}" @selected($status === $option)>{{ $option->label() }}</option>
                            @endforeach
                        </select>
                        <button class="admin-button admin-button-primary" type="submit"><i class="fa-solid fa-check" aria-hidden="true"></i> Guardar estado</button>
                    </form>
                    <div class="lead-detail-timeline">
                        <div class="lead-detail-timeline-item is-current"><span><i class="fa-solid fa-inbox" aria-hidden="true"></i></span><div><strong>Solicitud recibida</strong><small>{{ $lead->created_at->format('d/m/Y · H:i') }}</small></div></div>
                        @if($lead->privacy_accepted_at)
                            <div class="lead-detail-timeline-item"><span><i class="fa-solid fa-shield-halved" aria-hidden="true"></i></span><div><strong>Privacidad aceptada</strong><small>{{ $lead->privacy_accepted_at->format('d/m/Y · H:i') }}</small></div></div>
                        @endif
                        @if($lead->contacted_at)
                            <div class="lead-detail-timeline-item"><span><i class="fa-solid fa-phone" aria-hidden="true"></i></span><div><strong>Cliente contactado</strong><small>{{ $lead->contacted_at->format('d/m/Y · H:i') }}</small></div></div>
                        @endif
                        @if($lead->converted_at)
                            <div class="lead-detail-timeline-item"><span><i class="fa-solid fa-circle-check" aria-hidden="true"></i></span><div><strong>Solicitud completada</strong><small>{{ $lead->converted_at->format('d/m/Y · H:i') }}</small></div></div>
                        @endif
                    </div>
                </section>

                <section class="lead-detail-card lead-detail-source-card">
                    <span class="lead-detail-source-icon"><i class="fa-solid fa-link" aria-hidden="true"></i></span>
                    <div><small>Origen de la solicitud</small><strong>{{ ucfirst($lead->source ?? 'web') }}</strong></div>
                    @if($lead->utm_campaign)
                        <p>Campaña: {{ $lead->utm_campaign }}</p>
                    @endif
                </section>
            </aside>
        </div>

        <div class="lead-detail-footer-actions">
            <a class="admin-button" href="{{ route('admin.leads.index') }}"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> Volver a solicitudes</a>
            <a class="admin-button lead-excel-button" href="{{ route('admin.leads.export', $lead) }}"><i class="fa-solid fa-file-excel" aria-hidden="true"></i> Descargar ficha Excel</a>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .lead-detail-page { --ld-ink: #17251b; --ld-muted: #718075; --ld-line: #e5ece5; --ld-green: #1b5e20; --ld-soft: #eff7ef; }
        .lead-detail-breadcrumb { display:flex; align-items:center; gap:10px; margin:0 0 17px; color:var(--ld-muted); font-size:.72rem; font-weight:700; }
        .lead-detail-breadcrumb a { text-decoration:none; }
        .lead-detail-breadcrumb a:hover { color:var(--ld-green); }
        .lead-detail-breadcrumb i { font-size:.58rem; opacity:.6; }
        .lead-detail-hero { position:relative; isolation:isolate; display:flex; align-items:center; justify-content:space-between; gap:24px; min-height:220px; overflow:hidden; margin-bottom:18px; padding:clamp(24px,4vw,42px); border:1px solid rgba(32,94,43,.12); border-radius:20px; background:radial-gradient(ellipse at 85% 20%,rgba(151,207,133,.25),transparent 40%),linear-gradient(125deg,#fff 15%,#f2f8f0 100%); box-shadow:0 16px 46px rgba(27,65,32,.07); }
        .lead-detail-hero-main,.lead-detail-hero-actions { position:relative; z-index:1; }
        .lead-detail-hero h1 { margin:5px 0 7px; color:var(--ld-ink); font-size:clamp(1.7rem,3vw,2.65rem); line-height:1.15; font-weight:800; letter-spacing:-.045em; }
        .lead-detail-hero-main>p { margin:0; color:var(--ld-muted); font-size:.82rem; }
        .lead-detail-eyebrow { display:inline-flex; align-items:center; gap:8px; color:var(--ld-green); font-size:.66rem; font-weight:800; letter-spacing:.11em; }
        .lead-detail-hero-meta { display:flex; flex-wrap:wrap; gap:9px; margin-top:20px; }
        .lead-detail-hero-meta span { display:inline-flex; align-items:center; gap:8px; padding:8px 11px; border:1px solid rgba(27,94,32,.1); border-radius:999px; background:rgba(255,255,255,.75); color:#435347; font-size:.69rem; font-weight:700; }
        .lead-detail-hero-meta i { color:var(--ld-green); }
        .lead-detail-hero-actions { display:grid; justify-items:stretch; gap:9px; min-width:185px; }
        .lead-detail-hero-actions .admin-button { justify-content:center; min-height:42px; }
        .lead-detail-status { display:inline-flex; align-items:center; justify-content:center; gap:8px; margin-bottom:3px; padding:8px 12px; border:1px solid #d5e8d5; border-radius:999px; background:#fff; color:#285f31; font-size:.72rem; font-weight:800; }
        .lead-detail-status>span { width:8px; height:8px; border-radius:50%; background:#4ba45a; box-shadow:0 0 0 4px #e6f4e7; }
        .lead-excel-button { border-color:#cfe5d0!important; background:#f4faf3!important; color:#1b5e20!important; }
        .lead-excel-button:hover { border-color:#90c393!important; background:#e9f5e8!important; }
        .lead-detail-hero-glow { position:absolute; z-index:0; top:-100px; right:22%; width:330px; height:330px; border-radius:50%; background:rgba(146,198,126,.13); filter:blur(4px); pointer-events:none; }
        .lead-detail-quick-grid { display:grid; grid-template-columns:repeat(3,minmax(0,1fr)); gap:12px; margin-bottom:18px; }
        .lead-detail-quick-card { display:flex; align-items:center; gap:12px; min-width:0; padding:15px; border:1px solid var(--ld-line); border-radius:14px; background:#fff; box-shadow:0 7px 22px rgba(22,40,28,.035); }
        .lead-detail-quick-icon,.lead-detail-section-icon,.lead-detail-property-icon { flex:0 0 auto; display:grid; place-items:center; color:var(--ld-green); background:var(--ld-soft); }
        .lead-detail-quick-icon { width:40px; height:40px; border-radius:12px; }
        .lead-detail-quick-card>div { display:grid; min-width:0; gap:3px; }
        .lead-detail-quick-card small,.lead-detail-source-card small { color:var(--ld-muted); font-size:.65rem; font-weight:700; }
        .lead-detail-quick-card a,.lead-detail-quick-card strong { overflow:hidden; color:var(--ld-ink); font-size:.76rem; font-weight:800; text-overflow:ellipsis; text-decoration:none; white-space:nowrap; }
        .lead-detail-quick-card a:hover { color:var(--ld-green); }
        .lead-detail-card-arrow { margin-left:auto; color:#9aa99b; font-size:.72rem; }
        .lead-detail-layout { display:grid; grid-template-columns:minmax(0,1.65fr) minmax(280px,.8fr); align-items:start; gap:17px; }
        .lead-detail-main-column,.lead-detail-side-column { display:grid; gap:16px; min-width:0; }
        .lead-detail-card { min-width:0; overflow:hidden; border:1px solid var(--ld-line); border-radius:16px; background:#fff; box-shadow:0 8px 26px rgba(22,40,28,.045); }
        .lead-detail-card-heading { display:flex; align-items:center; gap:12px; min-height:77px; padding:15px 19px; border-bottom:1px solid #edf1ed; }
        .lead-detail-section-icon { width:40px; height:40px; border-radius:12px; font-size:.9rem; }
        .lead-detail-card-heading>div { min-width:0; }
        .lead-detail-card-heading h2 { margin:0; color:var(--ld-ink); font-size:.88rem; font-weight:800; }
        .lead-detail-card-heading p { margin:3px 0 0; color:var(--ld-muted); font-size:.67rem; }
        .lead-detail-section-count { margin-left:auto; padding:6px 9px; border:1px solid #e4eee3; border-radius:999px; background:#f7fbf6; color:#3e7647; font-size:.62rem; font-weight:800; white-space:nowrap; }
        .lead-detail-answer-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:0 20px; margin:0; padding:5px 20px 11px; }
        .lead-detail-answer { min-width:0; padding:14px 0; border-bottom:1px solid #f0f3f0; }
        .lead-detail-answer:nth-last-child(-n+2) { border-bottom:0; }
        .lead-detail-answer dt,.lead-detail-property-item dt { margin-bottom:5px; color:var(--ld-muted); font-size:.65rem; font-weight:700; }
        .lead-detail-answer dd { display:flex; align-items:center; gap:7px; margin:0; color:var(--ld-ink); font-size:.76rem; font-weight:750; line-height:1.55; overflow-wrap:anywhere; }
        .lead-detail-answer dd.is-empty { color:#9aa49c; font-weight:500; }
        .lead-detail-privacy-check { display:grid; width:18px; height:18px; place-items:center; border-radius:50%; background:#e9f6e8; color:#27823a; font-size:.58rem; }
        .lead-detail-property-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:3px 15px; margin:0; padding:16px 19px 12px; }
        .lead-detail-property-item { display:flex; align-items:center; gap:10px; min-width:0; padding:9px 0; }
        .lead-detail-property-icon { width:34px; height:34px; border-radius:10px; font-size:.75rem; }
        .lead-detail-property-item>div { min-width:0; }
        .lead-detail-property-item dt { margin:0 0 2px; font-size:.6rem; }
        .lead-detail-property-item dd { margin:0; color:var(--ld-ink); font-size:.72rem; font-weight:750; overflow-wrap:anywhere; }
        .lead-detail-address { display:flex; align-items:flex-start; gap:11px; margin:0 19px 17px; padding:13px; border:1px solid #e9f0e8; border-radius:12px; background:#f8fbf7; color:var(--ld-green); }
        .lead-detail-address>i { margin-top:2px; }
        .lead-detail-address>div { display:grid; gap:3px; }
        .lead-detail-address small { color:var(--ld-muted); font-size:.62rem; font-weight:700; }
        .lead-detail-address strong { color:var(--ld-ink); font-size:.72rem; line-height:1.5; }
        .lead-detail-message { margin:17px 19px; padding:16px; border:0; border-left:3px solid #76ae72; border-radius:0 11px 11px 0; background:#f7faf6; color:#34443a; font-size:.78rem; line-height:1.8; white-space:pre-line; overflow-wrap:anywhere; }
        .lead-detail-empty-message { display:flex; align-items:center; gap:10px; padding:19px; color:var(--ld-muted); font-size:.72rem; }
        .lead-detail-empty-message i { color:#88a88b; font-size:.95rem; }
        .lead-detail-status-form { display:grid; gap:9px; padding:17px 18px; }
        .lead-detail-status-form label { color:#48584c; font-size:.68rem; font-weight:800; }
        .lead-detail-status-form select { min-height:43px; padding:0 12px; border:1px solid #dfe8df; border-radius:10px; background:#fff; color:var(--ld-ink); font:inherit; font-size:.75rem; }
        .lead-detail-status-form .admin-button { justify-content:center; min-height:42px; margin-top:2px; }
        .lead-detail-timeline { display:grid; gap:0; padding:0 18px 16px; }
        .lead-detail-timeline-item { position:relative; display:flex; align-items:flex-start; gap:10px; min-height:54px; }
        .lead-detail-timeline-item:not(:last-child)::after { position:absolute; top:29px; bottom:0; left:14px; width:1px; background:#e1eae1; content:''; }
        .lead-detail-timeline-item>span { z-index:1; display:grid; width:29px; height:29px; flex:0 0 auto; place-items:center; border:1px solid #e4ede3; border-radius:50%; background:#fff; color:#6b9470; font-size:.65rem; }
        .lead-detail-timeline-item.is-current>span { border-color:#d5ead3; background:#eef8ec; color:#267333; }
        .lead-detail-timeline-item>div { display:grid; gap:3px; padding-top:2px; }
        .lead-detail-timeline-item strong { color:#334238; font-size:.67rem; }
        .lead-detail-timeline-item small { color:var(--ld-muted); font-size:.62rem; }
        .lead-detail-source-card { display:grid; grid-template-columns:40px 1fr; align-items:center; gap:8px 11px; padding:16px; }
        .lead-detail-source-icon { display:grid; width:40px; height:40px; grid-row:span 2; place-items:center; border-radius:12px; background:#f0f5ff; color:#49699e; }
        .lead-detail-source-card>div { display:grid; gap:3px; }
        .lead-detail-source-card>div strong { color:var(--ld-ink); font-size:.76rem; }
        .lead-detail-source-card p { grid-column:2; margin:0; color:var(--ld-muted); font-size:.65rem; }
        .lead-detail-footer-actions { display:flex; justify-content:space-between; gap:10px; margin-top:18px; }
        @media(max-width:1050px) { .lead-detail-layout { grid-template-columns:minmax(0,1.35fr) minmax(260px,.8fr); } .lead-detail-hero { align-items:flex-start; } }
        @media(max-width:800px) { .lead-detail-layout { grid-template-columns:1fr; } .lead-detail-side-column { grid-row:1; grid-template-columns:repeat(2,minmax(0,1fr)); align-items:start; } .lead-detail-followup { grid-row:span 2; } }
        @media(max-width:620px) { .lead-detail-hero { flex-direction:column; gap:18px; border-radius:16px; } .lead-detail-hero-actions { grid-template-columns:repeat(2,minmax(0,1fr)); width:100%; } .lead-detail-status { grid-column:1/-1; justify-self:start; } .lead-detail-quick-grid { grid-template-columns:1fr; gap:8px; } .lead-detail-quick-card { padding:12px; } .lead-detail-side-column { grid-template-columns:1fr; } .lead-detail-followup { grid-row:auto; } .lead-detail-answer-grid,.lead-detail-property-grid { grid-template-columns:1fr; } .lead-detail-answer:nth-last-child(-n+2) { border-bottom:1px solid #f0f3f0; } .lead-detail-answer:last-child { border-bottom:0; } .lead-detail-card-heading { padding:13px; } .lead-detail-section-count { font-size:.56rem; } .lead-detail-footer-actions { flex-direction:column; } .lead-detail-footer-actions .admin-button { justify-content:center; } }
    </style>
@endpush
