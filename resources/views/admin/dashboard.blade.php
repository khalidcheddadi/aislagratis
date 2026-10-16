<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    @include('partials.site-icons')
    <title>Dashboard - aislagratis</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --bg-page: #FFFFFF;
            --bg-card: #FFFFFF;
            --text-primary: #111827;
            --text-secondary: #6B7280;
            --text-muted: #9CA3AF;
            --border-light: #E5E7EB;
            --black: #111827;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --radius-md: 12px;
            --radius-lg: 16px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            background-color: var(--bg-page);
            font-family: 'Inter', 'Montserrat', sans-serif;
            color: var(--text-primary);
            line-height: 1.6;
        }

        .dashboard-header {
            background: #FFFFFF;
            border-bottom: 1px solid var(--border-light);
            padding: 20px 32px;
        }
        .dashboard-header-container {
            max-width: 1440px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
        }
        .dashboard-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 900;
            font-size: 1.1rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #1B5E20;
        }
        .dashboard-logo img { width: 42px; height: 42px; object-fit: contain; border-radius: 10px; background: #fff; }
        .dashboard-welcome {
            background: #F9FAFB;
            border: 1px solid var(--border-light);
            border-radius: 30px;
            padding: 8px 20px;
            font-weight: 500;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .dashboard-welcome i { color: var(--black); }
        .btn-logout {
            padding: 10px 20px;
            border-radius: var(--radius-md);
            background: #111827;
            color: white;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: 0.2s;
        }
        .btn-logout:hover { background: #000; }

        .dashboard-container {
            max-width: 1440px;
            margin: 0 auto;
            padding: 32px;
        }
        .page-title {
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .page-title i { color: var(--black); }

        .notifications-card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow-sm);
            margin-bottom: 24px;
            overflow: hidden;
        }
        .notifications-card .card-header {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border-light);
            background: #FAFAFA;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95rem;
        }
        .notifications-list { list-style: none; }
        .notification-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 16px 24px;
            border-bottom: 1px solid var(--border-light);
        }
        .notification-item:last-child { border-bottom: none; }
        .notification-item:hover { background: #F9FAFB; }
        .notification-title { font-weight: 600; color: var(--text-primary); display: block; }
        .notification-message { font-size: 0.9rem; color: var(--text-secondary); }
        .mark-read-link {
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-secondary);
            text-decoration: none;
            white-space: nowrap;
            padding: 4px 8px;
            border-radius: 4px;
        }
        .mark-read-link:hover { background: var(--border-light); color: var(--black); }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }
        .stat-card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-light);
            padding: 20px;
            box-shadow: var(--shadow-sm);
            transition: 0.2s;
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .stat-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.05); transform: translateY(-2px); }
        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            background: #F3F4F6;
            color: var(--black);
            flex-shrink: 0;
        }
        .stat-info h3 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.2;
        }
        .stat-info p {
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
            margin: 0;
        }

        .leads-card {
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }
        .leads-card .card-header {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border-light);
            background: #FAFAFA;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
        .leads-card .card-header span {
            font-weight: 600;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.85rem;
            border: 1px solid var(--border-light);
            background: transparent;
            color: var(--black);
            cursor: pointer;
            text-decoration: none;
            transition: 0.2s;
        }
        .btn-outline:hover { background: var(--black); color: white; border-color: var(--black); }

        .table-wrapper { overflow-x: auto; }
        .leads-table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
        .leads-table thead th {
            background: #FAFAFA;
            color: var(--text-secondary);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.75rem;
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid var(--border-light);
            white-space: nowrap;
        }
        .leads-table tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-light);
            vertical-align: middle;
        }
        .leads-table tbody tr:last-child td { border-bottom: none; }
        .leads-table tbody tr:hover { background: #F9FAFB; }
        .property-type { font-size: 0.8rem; color: var(--text-secondary); }
        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: 1px solid var(--border-light);
            color: var(--text-secondary);
            transition: 0.2s;
        }
        .action-btn:hover { background: var(--black); border-color: var(--black); color: white; }

        .badge-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.3px;
            display: inline-block;
        }
        .badge-nuevo { background: #F3F4F6; color: #6B7280; }
        .badge-contactado { background: #FFFBEB; color: #D97706; }
        .badge-programado { background: #ECFDF5; color: #059669; }
        .badge-completado { background: #F3F4F6; color: #374151; }
        .badge-descartado { background: #FEF2F2; color: #DC2626; }

        @media (max-width: 768px) {
            .dashboard-container { padding: 16px; }
            .stats-grid { grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 12px; }
            .stat-card { flex-direction: column; text-align: center; padding: 12px; }
            .stat-info h3 { font-size: 1.4rem; }
        }
    </style>
</head>
<body>

    
    <header class="dashboard-header">
        <div class="dashboard-header-container">
            <div class="dashboard-logo">
                <img src="{{ asset('icons/icon-192.png') }}?v={{ filemtime(public_path('icons/icon-192.png')) }}" alt="" aria-hidden="true" width="42" height="42">
                aislagratis
            </div>
            <div class="dashboard-welcome">
                <i class="fa-solid fa-user-circle"></i>
                Bienvenido, {{ auth()->user()->first_name }} ({{ auth()->user()->role->value }})
            </div>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Salir
                </button>
            </form>
        </div>
    </header>

    <div class="dashboard-container">

        <h1 class="page-title">
            <i class="fa-solid fa-gauge-high"></i>
            Dashboard
        </h1>

        
        @if($unreadNotifications->isNotEmpty())
            <div class="notifications-card">
                <div class="card-header">
                    <i class="fa-solid fa-bell"></i> Notificaciones no leídas
                </div>
                <ul class="notifications-list">
                    @foreach($unreadNotifications as $notif)
                        <li class="notification-item">
                            <div>
                                <span class="notification-title">{{ $notif->data['title'] ?? '' }}</span>
                                <span class="notification-message">{{ $notif->data['message'] ?? '' }}</span>
                            </div>
                            <a href="{{ route('admin.notifications.read', $notif->id) }}"
                               onclick="event.preventDefault(); document.getElementById('read-{{ $notif->id }}').submit();"
                               class="mark-read-link">
                                <i class="fa-solid fa-check"></i> Marcar leída
                            </a>
                            <form id="read-{{ $notif->id }}" method="POST" action="{{ route('admin.notifications.read', $notif->id) }}" style="display:none;">
                                @csrf
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
                <div class="stat-info">
                    <h3>{{ $stats['total_users'] }}</h3>
                    <p>Usuarios</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fa-solid fa-file-alt"></i></div>
                <div class="stat-info">
                    <h3>{{ $stats['total_leads'] }}</h3>
                    <p>Leads Totales</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fa-solid fa-bolt"></i></div>
                <div class="stat-info">
                    <h3>{{ $stats['new_leads'] }}</h3>
                    <p>Leads Nuevos</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fa-solid fa-calendar-check"></i></div>
                <div class="stat-info">
                    <h3>{{ $stats['pending_appointments'] }}</h3>
                    <p>Citas Pendientes</p>
                </div>
            </div>
        </div>

        
        <div class="leads-card">
            <div class="card-header">
                <span><i class="fa-solid fa-list-ul"></i> Últimos Leads</span>
                <a href="{{ route('admin.leads.index') }}" class="btn-outline">
                    Ver todos <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
            <div class="table-wrapper">
                @if($recentLeads->isEmpty())
                    <div style="padding: 32px; text-align: center; color: var(--text-muted);">
                        No hay leads registrados.
                    </div>
                @else
                    <table class="leads-table">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Nombre</th>
                                <th>Contacto</th>
                                <th>Ubicación</th>
                                <th>Tipo Inmueble</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentLeads as $lead)
                                <tr>
                                    <td style="white-space: nowrap;">
                                        <i class="fa-regular fa-clock" style="color: var(--text-muted); margin-right: 4px;"></i>
                                        {{ $lead->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td><strong>{{ $lead->full_name }}</strong></td>
                                    <td>
                                        <div>{{ $lead->email }}</div>
                                        @if($lead->phone)
                                            <small style="color: var(--text-muted);">{{ $lead->phone }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $lead->city ?? '' }}, {{ $lead->postal_code ?? '' }}</td>
                                    <td>
                                        <span class="property-type">
                                            {{ ucfirst(str_replace('_', ' ', $lead->property_type->value)) }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = match($lead->status->value) {
                                                'nuevo' => 'badge-nuevo',
                                                'contactado' => 'badge-contactado',
                                                'programado' => 'badge-programado',
                                                'completado' => 'badge-completado',
                                                'descartado' => 'badge-descartado',
                                                default => 'badge-nuevo',
                                            };
                                        @endphp
                                        <span class="badge-status {{ $statusClass }}">
                                            {{ $lead->status->value }}
                                        </span>
                                    </td>
                                    <td style="text-align: right;">
                                        <a href="{{ route('admin.leads.show', $lead) }}" class="action-btn" title="Ver detalles">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

</body>
</html>
