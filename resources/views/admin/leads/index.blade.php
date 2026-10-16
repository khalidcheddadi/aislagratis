@extends('layouts.admin')
@section('title', 'Solicitudes')
@section('content')
    <section class="admin-intro"><div class="admin-intro-copy"><span class="admin-eyebrow"><i class="fa-solid fa-inbox"></i> GESTIÓN COMERCIAL</span><h1>Solicitudes</h1><p>Consulta las solicitudes recibidas, revisa su estado y accede a la información completa de cada cliente potencial.</p></div><div class="admin-intro-image"><img src="{{ asset('images/image12.jpg') }}" alt="Vivienda eficiente"></div></section>
    <section class="admin-panel">
        <div class="admin-panel-head"><h2><i class="fa-solid fa-filter" style="color:var(--admin-green)"></i> Filtros y resultados</h2><span class="admin-badge">{{ $leads->total() }} solicitudes</span></div>
        <div class="admin-panel-body">
            <form method="GET" class="admin-toolbar">
                <div class="admin-filters">
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Nombre, email o teléfono" aria-label="Buscar solicitud">
                    <select name="status" aria-label="Filtrar por estado"><option value="">Todos los estados</option>@foreach($statuses as $status)<option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>@endforeach</select>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" aria-label="Desde">
                    <input type="date" name="date_to" value="{{ request('date_to') }}" aria-label="Hasta">
                    <button class="admin-button admin-button-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
                    @if(request()->query())<a class="admin-button" href="{{ route('admin.leads.index') }}">Limpiar</a>@endif
                </div>
            </form>
            @if($leads->isEmpty())
                <div class="admin-empty"><i class="fa-regular fa-folder-open"></i>No hay solicitudes que coincidan con los filtros.</div>
            @else
                <div class="admin-table-wrap"><table class="admin-table">
                    <thead><tr><th>Fecha</th><th>Cliente</th><th>Contacto</th><th>Localidad</th><th>Servicio</th><th>Estado</th><th>Acciones</th></tr></thead>
                    <tbody>@foreach($leads as $lead)
                        @php($status = $lead->status)
                        <tr>
                            <td style="white-space:nowrap">{{ $lead->created_at->format('d/m/Y H:i') }}</td><td><strong>{{ $lead->full_name }}</strong><br><span style="color:var(--admin-muted)">{{ $lead->property_type->label() }}</span></td>
                            <td>{{ $lead->email }}@if($lead->phone)<br><span style="color:var(--admin-muted)">{{ $lead->phone }}</span>@endif</td><td>{{ $lead->city ?? '—' }}<br><span style="color:var(--admin-muted)">{{ $lead->postal_code }}</span></td><td>{{ $lead->service?->name ?? '—' }}</td>
                            <td><span class="admin-badge {{ $status->value === 'descartado' ? 'admin-badge-danger' : ($status->value === 'contactado' ? 'admin-badge-warning' : '') }}">{{ $status->label() }}</span></td>
                            <td><div class="admin-actions"><a class="admin-button" href="{{ route('admin.leads.show', $lead) }}" title="Ver detalles"><i class="fa-solid fa-eye"></i></a><a class="admin-button" href="{{ route('admin.leads.export', $lead) }}" title="Exportar CSV"><i class="fa-solid fa-download"></i></a><a class="admin-button" href="{{ route('admin.appointments.create', ['lead_id' => $lead->id]) }}" title="Programar cita"><i class="fa-solid fa-calendar-plus"></i></a></div></td>
                        </tr>
                    @endforeach</tbody>
                </table></div><div class="admin-pager">{{ $leads->links() }}</div>
            @endif
        </div>
    </section>
@endsection