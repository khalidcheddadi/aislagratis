@extends('layouts.admin')

@section('title', 'Panel de administración')

@section('content')
    <section class="admin-intro">
        <div class="admin-intro-copy">
            <span class="admin-eyebrow"><i class="fa-solid fa-leaf"></i> aislagratis · CENTRO DE OPERACIONES</span>
            <h1>Tu hogar, cada vez más eficiente.</h1>
            <p>Hola, {{ auth()->user()->first_name }}. Revisa las solicitudes, coordina el trabajo del equipo y mantén cada mejora energética en marcha.</p>
        </div>
        <div class="admin-intro-image"><img src="{{ asset('images/image12.jpg') }}" alt="Vivienda con soluciones de eficiencia energética"></div>
    </section>

    <section class="admin-content" aria-labelledby="overview-title">
        <div class="admin-section-heading">
            <div><h2 id="overview-title">Resumen de actividad</h2><p>Indicadores principales de la operación.</p></div>
            @if(auth()->user()->role->value === 'admin')<a class="admin-button" href="{{ route('admin.reports.index') }}"><i class="fa-solid fa-chart-pie"></i> Ver informes</a>@endif
        </div>
        <div class="admin-stats">
            <article class="admin-stat"><div class="admin-stat-top"><span>Usuarios</span><span class="admin-stat-icon"><i class="fa-solid fa-users"></i></span></div><strong class="admin-stat-value">{{ number_format($stats['total_users']) }}</strong></article>
            <article class="admin-stat"><div class="admin-stat-top"><span>Solicitudes</span><span class="admin-stat-icon"><i class="fa-solid fa-inbox"></i></span></div><strong class="admin-stat-value">{{ number_format($stats['total_leads']) }}</strong></article>
            <article class="admin-stat"><div class="admin-stat-top"><span>Nuevas</span><span class="admin-stat-icon"><i class="fa-solid fa-bolt"></i></span></div><strong class="admin-stat-value">{{ number_format($stats['new_leads']) }}</strong></article>
            <article class="admin-stat"><div class="admin-stat-top"><span>Citas pendientes</span><span class="admin-stat-icon"><i class="fa-solid fa-calendar-check"></i></span></div><strong class="admin-stat-value">{{ number_format($stats['pending_appointments']) }}</strong></article>
            <article class="admin-stat"><div class="admin-stat-top"><span>Instalaciones completadas</span><span class="admin-stat-icon"><i class="fa-solid fa-house-circle-check"></i></span></div><strong class="admin-stat-value">{{ number_format($stats['completed_installations']) }}</strong></article>
        </div>
    </section>

    @if($unreadNotifications->isNotEmpty())
        <section class="admin-panel">
            <div class="admin-panel-head"><h2><i class="fa-solid fa-bell" style="color:var(--admin-green)"></i> Avisos sin leer</h2><a href="{{ route('admin.notifications.index') }}" class="admin-login-link">Todos los avisos</a></div>
            <div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Aviso</th><th>Fecha</th><th></th></tr></thead><tbody>
                @foreach($unreadNotifications as $notification)
                    <tr>
                        <td><strong>{{ $notification->data['title'] ?? 'Aviso' }}</strong><br><span style="color:var(--admin-muted)">{{ $notification->data['message'] ?? '' }}</span></td>
                        <td>{{ $notification->created_at->format('d/m/Y H:i') }}</td>
                        <td><form method="POST" action="{{ route('admin.notifications.read', $notification) }}">@csrf<button class="admin-button" type="submit"><i class="fa-solid fa-check"></i> Marcar leído</button></form></td>
                    </tr>
                @endforeach
            </tbody></table></div>
        </section>
    @endif

    <section class="admin-panel">
        <div class="admin-panel-head">
            <h2><i class="fa-solid fa-list-ul" style="color:var(--admin-green)"></i> Solicitudes recientes</h2>
            <a href="{{ route('admin.leads.index') }}" class="admin-button"><i class="fa-solid fa-arrow-right"></i> Ver todas</a>
        </div>
        @if($recentLeads->isEmpty())
            <div class="admin-empty"><i class="fa-regular fa-folder-open"></i>No hay solicitudes registradas.</div>
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
                            <td><a class="admin-button" href="{{ route('admin.leads.show', $lead) }}" title="Ver solicitud"><i class="fa-solid fa-eye"></i></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table></div>
        @endif
    </section>
@endsection