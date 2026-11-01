@extends('layouts.admin')
@section('title', 'Consentimientos de cookies')
@section('content')
    <section class="admin-intro">
        <div class="admin-intro-copy">
            <span class="admin-eyebrow"><i class="fa-solid fa-cookie-bite"></i> PRIVACIDAD</span>
            <h1>Consentimientos de cookies</h1>
            <p>Consulta las elecciones guardadas de aceptación o rechazo y su fecha de registro.</p>
        </div>
        <div class="admin-intro-image"><img src="{{ asset('images/image12-640.webp') }}" alt="Vivienda eficiente"></div>
    </section>

    <div class="admin-stats">
        <article class="admin-stat"><div class="admin-stat-top"><span>Total de registros</span><i class="fa-solid fa-database"></i></div><strong class="admin-stat-value">{{ number_format($stats['total']) }}</strong></article>
        <article class="admin-stat"><div class="admin-stat-top"><span>Aceptados</span><i class="fa-solid fa-check"></i></div><strong class="admin-stat-value">{{ number_format($stats['accepted']) }}</strong></article>
        <article class="admin-stat"><div class="admin-stat-top"><span>Rechazados</span><i class="fa-solid fa-ban"></i></div><strong class="admin-stat-value">{{ number_format($stats['rejected']) }}</strong></article>
    </div>

    <section class="admin-panel">
        <div class="admin-panel-head">
            <h2><i class="fa-solid fa-filter" style="color:var(--admin-green)"></i> Registros</h2>
            <span class="admin-badge">{{ $consents->total() }} resultados</span>
        </div>
        <div class="admin-panel-body">
            <form method="GET" class="admin-toolbar">
                <div class="admin-filters">
                    <input type="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Ciudad, país o IP" aria-label="Buscar consentimiento">
                    <select name="consent" aria-label="Filtrar por elección">
                        <option value="">Todas las elecciones</option>
                        <option value="accepted" @selected(($filters['consent'] ?? '') === 'accepted')>Aceptadas</option>
                        <option value="rejected" @selected(($filters['consent'] ?? '') === 'rejected')>Rechazadas</option>
                    </select>
                    <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" aria-label="Desde">
                    <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" aria-label="Hasta">
                    <button class="admin-button admin-button-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
                    @if($filters)<a class="admin-button" href="{{ route('admin.cookie-consents.index') }}">Limpiar</a>@endif
                </div>
            </form>

            @if($consents->isEmpty())
                <div class="admin-empty"><i class="fa-regular fa-folder-open"></i>No hay consentimientos que coincidan con los filtros.</div>
            @else
                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead><tr><th>Último cambio</th><th>Elección</th><th>Visitante</th><th>Ubicación</th><th>IP</th><th>Dispositivo / navegador</th></tr></thead>
                        <tbody>
                            @foreach($consents as $consent)
                                <tr>
                                    <td style="white-space:nowrap">{{ $consent->updated_at->format('d/m/Y H:i') }}</td>
                                    <td><span class="admin-badge {{ $consent->consent_value === 'rejected' ? 'admin-badge-warning' : '' }}">{{ $consent->consent_value === 'accepted' ? 'Aceptadas' : 'Rechazadas' }}</span></td>
                                    <td>{{ $consent->user?->full_name ?? 'Visitante' }}<br><span style="color:var(--admin-muted)">{{ substr($consent->visitor_token, 0, 8) }}…</span></td>
                                    <td>{{ collect([$consent->city, $consent->country])->filter()->implode(', ') ?: '—' }}</td>
                                    <td>{{ $consent->ip_address ?? '—' }}</td>
                                    <td title="{{ $consent->user_agent }}">{{ \Illuminate\Support\Str::limit($consent->user_agent ?? '—', 90) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="admin-pager">{{ $consents->links() }}</div>
            @endif
        </div>
    </section>
@endsection
