@extends('layouts.admin')
@section('title', 'Citas')
@section('content')
    @if(auth()->user()->isTechnician())
        <section class="admin-intro">
            <div class="admin-intro-copy">
                <span class="admin-eyebrow"><i class="fa-solid fa-screwdriver-wrench"></i> ESPACIO TÉCNICO</span>
                <h1>Hola, {{ auth()->user()->first_name }}</h1>
                <p>Tu agenda de visitas, asignaciones y tareas del día en un solo lugar.</p>
                <strong style="display:block;margin-top:14px;color:var(--admin-green)">{{ $upcomingCount }} citas próximas</strong>
            </div>
            <div class="admin-intro-image"><img src="{{ asset('images/image12-640.webp') }}" alt="Vivienda eficiente"></div>
        </section>

        <section class="admin-stats" aria-label="Resumen técnico">
            <article class="admin-stat">
                <div class="admin-stat-top"><span>Citas asignadas</span><span class="admin-stat-icon"><i class="fa-solid fa-calendar-days"></i></span></div>
                <strong class="admin-stat-value">{{ number_format($technicianSummary['assigned']) }}</strong>
            </article>
            <article class="admin-stat">
                <div class="admin-stat-top"><span>Próximas visitas</span><span class="admin-stat-icon"><i class="fa-solid fa-clock"></i></span></div>
                <strong class="admin-stat-value">{{ number_format($technicianSummary['upcoming']) }}</strong>
            </article>
            <article class="admin-stat">
                <div class="admin-stat-top"><span>Pendientes de confirmar</span><span class="admin-stat-icon"><i class="fa-solid fa-hourglass-half"></i></span></div>
                <strong class="admin-stat-value">{{ number_format($technicianSummary['awaiting']) }}</strong>
            </article>
            <article class="admin-stat">
                <div class="admin-stat-top"><span>Realizadas hoy</span><span class="admin-stat-icon"><i class="fa-solid fa-circle-check"></i></span></div>
                <strong class="admin-stat-value">{{ number_format($technicianSummary['completed_today']) }}</strong>
            </article>
        </section>

        <section class="admin-panel">
            <div class="admin-panel-head"><h2><i class="fa-solid fa-location-dot" style="color:var(--admin-green)"></i> Próxima visita</h2></div>
            <div class="admin-panel-body">
                @if($nextAppointment)
                    <div class="admin-next-appointment">
                        <div class="admin-next-appointment-date">
                            <span>{{ $nextAppointment->appointment_date->translatedFormat('D') }}</span>
                            <strong>{{ $nextAppointment->appointment_date->format('d') }}</strong>
                            <span>{{ $nextAppointment->appointment_date->translatedFormat('M') }}</span>
                        </div>
                        <div class="admin-next-appointment-details">
                            <strong>{{ $nextAppointment->lead?->first_name }} {{ $nextAppointment->lead?->last_name }}</strong>
                            <span><i class="fa-regular fa-clock"></i> {{ $nextAppointment->appointment_date->format('H:i') }} · {{ $nextAppointment->duration_minutes }} min</span>
                            <span><i class="fa-solid fa-location-dot"></i> {{ $nextAppointment->lead?->address ?: 'Dirección no disponible' }}{{ $nextAppointment->lead?->city ? ', '.$nextAppointment->lead->city : '' }}</span>
                        </div>
                        <span class="admin-badge {{ $nextAppointment->status->value === 'pendiente' ? 'admin-badge-warning' : '' }}">{{ $nextAppointment->status->label() }}</span>
                    </div>
                @else
                    <div class="admin-empty"><i class="fa-regular fa-calendar"></i>No tienes próximas visitas asignadas.</div>
                @endif
            </div>
        </section>
    @else
        <section class="admin-intro"><div class="admin-intro-copy"><span class="admin-eyebrow"><i class="fa-solid fa-calendar-check"></i> COORDINACIÓN DE VISITAS</span><h1>Citas</h1><p>Organiza las visitas técnicas, asigna profesionales y actualiza el estado de cada cita.</p></div><div class="admin-intro-image"><img src="{{ asset('images/image12-640.webp') }}" alt="Vivienda eficiente"></div></section>
    @endif
    <section class="admin-panel"><div class="admin-panel-head"><h2>Agenda y seguimiento</h2>@can('appointments.create')<a class="admin-button admin-button-primary" href="{{ route('admin.appointments.create') }}"><i class="fa-solid fa-plus"></i> Programar cita</a>@endcan</div><div class="admin-panel-body">
        <form method="GET" class="admin-toolbar"><div class="admin-filters"><select name="status"><option value="">Todos los estados</option>@foreach($statuses as $status)<option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>@endforeach</select>@unless(auth()->user()->isTechnician())<select name="technician_id"><option value="">Todos los técnicos</option>@foreach($technicians as $technician)<option value="{{ $technician->id }}" @selected((string)request('technician_id') === (string)$technician->id)>{{ $technician->first_name }} {{ $technician->last_name }}</option>@endforeach</select>@endunless<input type="date" name="date" value="{{ request('date') }}" aria-label="Filtrar por fecha"><button class="admin-button admin-button-primary">Filtrar</button></div></form>
        @if($appointments->isEmpty())<div class="admin-empty"><i class="fa-regular fa-calendar"></i>No hay citas con estos filtros.</div>@else<div class="admin-table-wrap"><table class="admin-table"><thead><tr><th>Fecha y hora</th><th>Cliente</th><th>Contacto</th><th>Dirección</th>@unless(auth()->user()->isTechnician())<th>Técnico</th>@endunless<th>Duración</th><th>Estado</th><th>Actualizar</th></tr></thead><tbody>@foreach($appointments as $appointment)<tr><td>{{ $appointment->appointment_date->format('d/m/Y H:i') }}</td><td><strong>{{ $appointment->lead?->first_name }} {{ $appointment->lead?->last_name }}</strong></td><td>{{ $appointment->lead?->email }}<br><span style="color:var(--admin-muted)">{{ $appointment->lead?->phone }}</span></td><td>{{ $appointment->lead?->address ?: '—' }}@if($appointment->lead?->city)<br><span style="color:var(--admin-muted)">{{ $appointment->lead->city }}</span>@endif</td>@unless(auth()->user()->isTechnician())<td>{{ $appointment->technician?->first_name ?? 'Sin asignar' }} {{ $appointment->technician?->last_name }}</td>@endunless<td>{{ $appointment->duration_minutes }} min</td><td><span class="admin-badge {{ $appointment->status->value === 'cancelada' ? 'admin-badge-danger' : ($appointment->status->value === 'pendiente' ? 'admin-badge-warning' : '') }}">{{ $appointment->status->label() }}</span></td><td>@if(auth()->user()->isTechnician())@if(in_array($appointment->status->value, ['pendiente', 'confirmada'], true))<form method="POST" action="{{ route('admin.appointments.status', $appointment) }}" onsubmit="return confirm('¿Marcar esta cita como realizada?')">@csrf @method('PATCH')<input type="hidden" name="status" value="realizada"><button class="admin-button admin-button-primary"><i class="fa-solid fa-check"></i> Realizada</button></form>@else<span style="color:var(--admin-muted)">—</span>@endif @else<form method="POST" action="{{ route('admin.appointments.status', $appointment) }}" class="admin-inline-form">@csrf @method('PATCH')<select name="status" aria-label="Estado de cita">@foreach($statuses as $status)<option value="{{ $status->value }}" @selected($appointment->status === $status)>{{ $status->label() }}</option>@endforeach</select><button class="admin-button" title="Guardar estado"><i class="fa-solid fa-check"></i></button></form>@endif</td></tr>@endforeach</tbody></table></div><div class="admin-pager">{{ $appointments->links() }}</div>@endif
    </div></section>
@endsection