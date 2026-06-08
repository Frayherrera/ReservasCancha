@extends('layouts.app')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --pitch-green: #00f593;
            --pitch-green-glow: rgba(0, 245, 147, 0.25);
            --amber: #ffb400;
            --amber-glow: rgba(255, 180, 0, 0.2);
            --danger: #ff4466;
            --danger-glow: rgba(255, 68, 102, 0.2);
            --stadium-bg: #0b0f1c;
            --card-bg: rgba(12, 16, 30, 0.88);
            --card-border: rgba(255, 255, 255, 0.05);
            --text-primary: #f0f4ff;
            --text-secondary: rgba(240, 244, 255, 0.55);
            --text-muted: rgba(240, 244, 255, 0.3);
            --radius: 16px;
            --radius-sm: 10px;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--stadium-bg) !important;
        }

        .reservas-page {
            padding: 28px 32px;
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
        }

        .reservas-page::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                repeating-linear-gradient(0deg, transparent, transparent 60px, rgba(0, 245, 147, 0.01) 60px, rgba(0, 245, 147, 0.01) 61px),
                repeating-linear-gradient(90deg, transparent, transparent 60px, rgba(0, 245, 147, 0.01) 60px, rgba(0, 245, 147, 0.01) 61px);
            pointer-events: none;
            z-index: 0;
        }

        .page-header {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .page-header h1 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2.6rem;
            letter-spacing: 2px;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-header h1 i {
            color: var(--pitch-green);
            font-size: 2rem;
        }

        .page-header .header-accent {
            display: block;
            width: 40px;
            height: 3px;
            background: var(--pitch-green);
            border-radius: 4px;
            box-shadow: 0 0 16px var(--pitch-green-glow);
            margin-top: 6px;
        }

        .page-header .subtitle {
            color: var(--text-secondary);
            font-size: 0.85rem;
            font-weight: 300;
            margin: 6px 0 0;
        }

        /* === STATS === */
        .reservas-stats {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 14px;
            margin-bottom: 24px;
        }

        .reserva-stat {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: var(--radius);
            padding: 18px;
            text-align: center;
            backdrop-filter: blur(12px);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1),
                        border-color 0.3s;
            position: relative;
            overflow: hidden;
        }

        .reserva-stat::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            opacity: 0.2;
        }

        .reserva-stat:hover {
            transform: translateY(-3px);
        }

        .reserva-stat:nth-child(1)::before { background: var(--pitch-green); }
        .reserva-stat:nth-child(2)::before { background: var(--amber); }
        .reserva-stat:nth-child(3)::before { background: var(--pitch-green); }
        .reserva-stat:nth-child(4)::before { background: var(--danger); }

        .reserva-stat h3 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.8rem;
            letter-spacing: 1px;
            margin: 0;
            line-height: 1;
        }

        .reserva-stat:nth-child(1) h3 { color: var(--pitch-green); }
        .reserva-stat:nth-child(2) h3 { color: var(--amber); }
        .reserva-stat:nth-child(3) h3 { color: var(--pitch-green); }
        .reserva-stat:nth-child(4) h3 { color: var(--danger); }

        .reserva-stat p {
            margin: 4px 0 0;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-secondary);
        }

        /* === FILTER BAR === */
        .filter-bar {
            position: relative;
            z-index: 1;
            display: flex;
            gap: 12px;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            padding: 16px 20px;
            border-radius: var(--radius);
            backdrop-filter: blur(12px);
        }

        .filter-bar input,
        .filter-bar select {
            padding: 10px 14px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            font-family: 'Outfit', sans-serif;
            background: rgba(255, 255, 255, 0.04);
            color: var(--text-primary);
            transition: border-color 0.25s, box-shadow 0.25s;
            outline: none;
        }

        .filter-bar input:focus,
        .filter-bar select:focus {
            border-color: var(--pitch-green);
            box-shadow: 0 0 0 3px rgba(0, 245, 147, 0.06);
        }

        .filter-bar input::placeholder {
            color: var(--text-muted);
        }

        .filter-bar select option {
            background: #12182f;
            color: var(--text-primary);
        }

        .filter-bar .search-input {
            flex: 1;
            min-width: 160px;
        }

        .filter-bar .btn-filter {
            background: var(--pitch-green);
            color: #0b0f1c;
            border: none;
            padding: 10px 22px;
            border-radius: var(--radius-sm);
            font-weight: 700;
            font-size: 0.8rem;
            font-family: 'Outfit', sans-serif;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .filter-bar .btn-filter:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px var(--pitch-green-glow);
        }

        .filter-bar .clear-link {
            color: var(--text-muted);
            font-size: 0.8rem;
            text-decoration: none;
            transition: color 0.2s;
        }

        .filter-bar .clear-link:hover {
            color: var(--pitch-green);
        }

        /* === KANBAN === */
        .kanban {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .kanban-column {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid var(--card-border);
            border-radius: var(--radius);
            padding: 16px;
            min-height: 300px;
            backdrop-filter: blur(8px);
            transition: border-color 0.3s;
        }

        .kanban-column.pendiente {
            border-color: rgba(255, 180, 0, 0.08);
        }
        .kanban-column.aprobada {
            border-color: rgba(0, 245, 147, 0.08);
        }
        .kanban-column.rechazada {
            border-color: rgba(255, 68, 102, 0.08);
        }

        .kanban-column .column-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 14px;
            padding-bottom: 12px;
            border-bottom: 2px solid;
        }

        .kanban-column.pendiente .column-header {
            border-color: rgba(255, 180, 0, 0.2);
        }
        .kanban-column.aprobada .column-header {
            border-color: rgba(0, 245, 147, 0.2);
        }
        .kanban-column.rechazada .column-header {
            border-color: rgba(255, 68, 102, 0.2);
        }

        .kanban-column .column-header h3 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.1rem;
            letter-spacing: 1px;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .kanban-column.pendiente .column-header h3 { color: var(--amber); }
        .kanban-column.aprobada .column-header h3 { color: var(--pitch-green); }
        .kanban-column.rechazada .column-header h3 { color: var(--danger); }

        .kanban-column .column-header .count {
            background: rgba(255, 255, 255, 0.04);
            padding: 2px 12px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-secondary);
        }

        /* === RESERVA CARD === */
        .reserva-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: var(--radius-sm);
            padding: 16px;
            margin-bottom: 10px;
            transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1),
                        border-color 0.25s,
                        box-shadow 0.25s;
            position: relative;
        }

        .reserva-card:hover {
            transform: translateY(-3px);
            border-color: rgba(255, 255, 255, 0.08);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }

        .reserva-card .card-header-info {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 8px;
        }

        .reserva-card .cliente {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-primary);
        }

        .reserva-card .cliente small {
            display: block;
            font-weight: 300;
            font-size: 0.72rem;
            color: var(--text-secondary);
        }

        .reserva-card .reserva-id {
            font-size: 0.7rem;
            color: var(--text-muted);
            font-weight: 600;
            background: rgba(255, 255, 255, 0.03);
            padding: 2px 10px;
            border-radius: 6px;
        }

        .reserva-card .detalle {
            font-size: 0.82rem;
            color: var(--text-secondary);
            margin-bottom: 8px;
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .reserva-card .detalle i {
            color: var(--pitch-green);
            width: 16px;
        }

        .reserva-card .fecha-creacion {
            font-size: 0.72rem;
            color: var(--text-muted);
        }

        .reserva-card .acciones {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid rgba(255, 255, 255, 0.04);
        }

        .reserva-card .acciones .btn-action {
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            font-family: 'Outfit', sans-serif;
            border: none;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .reserva-card .acciones .btn-action:hover {
            transform: scale(1.04);
        }

        .btn-aprobar {
            background: rgba(0, 245, 147, 0.12);
            color: var(--pitch-green);
            border: 1px solid rgba(0, 245, 147, 0.12) !important;
        }
        .btn-aprobar:hover {
            box-shadow: 0 0 12px var(--pitch-green-glow);
        }
        .btn-rechazar {
            background: rgba(255, 68, 102, 0.12);
            color: var(--danger);
            border: 1px solid rgba(255, 68, 102, 0.12) !important;
        }
        .btn-rechazar:hover {
            box-shadow: 0 0 12px var(--danger-glow);
        }
        .btn-reagendar {
            background: rgba(255, 180, 0, 0.12);
            color: var(--amber);
            border: 1px solid rgba(255, 180, 0, 0.12) !important;
        }
        .btn-reagendar:hover {
            box-shadow: 0 0 12px var(--amber-glow);
        }
        .btn-eliminar {
            background: rgba(255, 255, 255, 0.04);
            color: var(--text-muted);
            border: 1px solid rgba(255, 255, 255, 0.04) !important;
        }
        .btn-eliminar:hover {
            color: var(--danger);
            background: rgba(255, 68, 102, 0.1);
        }

        .empty-kanban {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-muted);
        }

        .empty-kanban i {
            font-size: 32px;
            margin-bottom: 8px;
        }

        .empty-kanban p {
            margin: 0;
            font-size: 0.85rem;
        }

        /* === EMPTY STATE === */
        .empty-state {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 60px 20px;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: var(--radius);
            backdrop-filter: blur(12px);
        }

        .empty-state i {
            font-size: 48px;
            color: var(--text-muted);
            margin-bottom: 12px;
        }

        .empty-state p {
            color: var(--text-secondary);
        }

        /* === REAGENDAR MODAL === */
        .modal-content {
            background: rgba(12, 16, 30, 0.96) !important;
            border: 1px solid var(--card-border) !important;
            border-radius: var(--radius) !important;
            box-shadow: 0 32px 80px rgba(0, 0, 0, 0.7) !important;
            backdrop-filter: blur(24px);
            position: relative;
            overflow: hidden;
        }

        .modal-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--pitch-green), transparent);
            opacity: 0.3;
        }

        .modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.04) !important;
            padding: 18px 24px 0 !important;
        }

        .modal-header .modal-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.4rem;
            letter-spacing: 1px;
            color: var(--text-primary);
        }

        .modal-header .btn-close {
            filter: invert(1) brightness(200%);
            opacity: 0.4;
            transition: opacity 0.2s, transform 0.2s;
        }

        .modal-header .btn-close:hover {
            opacity: 1;
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 20px 24px !important;
        }

        .modal-body p {
            color: var(--text-secondary) !important;
        }

        .horario-option {
            display: block;
            width: 100%;
            padding: 12px 16px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: var(--radius-sm);
            margin-bottom: 8px;
            background: rgba(255, 255, 255, 0.03);
            cursor: pointer;
            text-align: left;
            transition: border-color 0.2s, background 0.2s;
            font-size: 0.85rem;
            font-family: 'Outfit', sans-serif;
            color: var(--text-secondary);
        }

        .horario-option:hover {
            border-color: var(--pitch-green);
            background: rgba(0, 245, 147, 0.04);
        }

        .horario-option i {
            color: var(--pitch-green);
        }

        .modal-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.04) !important;
            padding: 16px 24px 20px !important;
            gap: 10px;
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.06) !important;
            color: var(--text-secondary) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            padding: 10px 22px !important;
            border-radius: var(--radius-sm) !important;
            font-weight: 600 !important;
            font-family: 'Outfit', sans-serif !important;
            transition: background 0.2s !important;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1) !important;
        }

        .btn-primary {
            background: var(--pitch-green) !important;
            color: #0b0f1c !important;
            border: none !important;
            padding: 10px 24px !important;
            border-radius: var(--radius-sm) !important;
            font-weight: 700 !important;
            font-family: 'Outfit', sans-serif !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            transition: transform 0.2s, box-shadow 0.2s !important;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px var(--pitch-green-glow);
        }

        /* === PAGINATION === */
        .pagination-wrap {
            position: relative;
            z-index: 1;
            margin-top: 24px;
            display: flex;
            justify-content: center;
        }

        @media (max-width: 900px) {
            .kanban {
                grid-template-columns: 1fr;
            }

            .reservas-page {
                padding: 16px;
            }

            .page-header h1 {
                font-size: 1.8rem;
            }

            .filter-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-bar .search-input {
                min-width: unset;
            }
        }
    </style>
@section('main')
<div class="reservas-page">
    <div class="page-header">
        <div>
            <h1>
                <i class='bx bx-calendar-check'></i>
                Reservas
            </h1>
            <p class="subtitle">Administra las reservas de los clientes</p>
            <span class="header-accent"></span>
        </div>
    </div>

    @if(session('success'))
    <script>
        Swal.fire({ icon: 'success', title: 'Operación Exitosa', text: "{{ session('success') }}", confirmButtonText: 'Aceptar', background: '#12182f', color: '#f0f4ff', iconColor: '#00f593', confirmButtonColor: '#00f593' });
    </script>
    @endif
    @if(session('error'))
    <script>
        Swal.fire({ icon: 'error', title: 'Error', text: "{{ session('error') }}", confirmButtonText: 'Aceptar', background: '#12182f', color: '#f0f4ff', iconColor: '#ff4466', confirmButtonColor: '#00f593' });
    </script>
    @endif

    <div class="reservas-stats">
        <div class="reserva-stat">
            <h3>{{ $resumen['total'] }}</h3>
            <p>Total</p>
        </div>
        <div class="reserva-stat">
            <h3>{{ $resumen['pendientes'] }}</h3>
            <p>Pendientes</p>
        </div>
        <div class="reserva-stat">
            <h3>{{ $resumen['aprobadas'] }}</h3>
            <p>Aprobadas</p>
        </div>
        <div class="reserva-stat">
            <h3>{{ $resumen['rechazadas'] }}</h3>
            <p>Rechazadas</p>
        </div>
    </div>

    <form class="filter-bar" method="GET" action="{{ route('reservas.index') }}">
        <input type="text" name="search" class="search-input" placeholder="Buscar cliente..." value="{{ request('search') }}">
        <select name="estado">
            <option value="">Todos los estados</option>
            <option value="Pendiente" {{ request('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
            <option value="Aprobada" {{ request('estado') == 'Aprobada' ? 'selected' : '' }}>Aprobada</option>
            <option value="Rechazada" {{ request('estado') == 'Rechazada' ? 'selected' : '' }}>Rechazada</option>
        </select>
        <input type="date" name="fecha" value="{{ request('fecha') }}">
        <button type="submit" class="btn-filter">Filtrar</button>
        @if(request()->anyFilled(['search', 'estado', 'fecha']))
        <a href="{{ route('reservas.index') }}" class="clear-link">Limpiar filtros</a>
        @endif
    </form>

    @if($reservas->isEmpty())
    <div class="empty-state">
        <i class='bx bx-calendar-x'></i>
        <p>No se encontraron reservas</p>
    </div>
    @else
    <div class="kanban">
        @foreach(['Pendiente', 'Aprobada', 'Rechazada'] as $estado)
        <div class="kanban-column {{ strtolower($estado) }}">
            <div class="column-header">
                <h3>
                    @if($estado == 'Pendiente') <i class='bx bx-time'></i>
                    @elseif($estado == 'Aprobada') <i class='bx bx-check-circle'></i>
                    @else <i class='bx bx-x-circle'></i>
                    @endif
                    {{ $estado }}
                </h3>
                <span class="count">{{ $reservas->where('estado', $estado)->count() }}</span>
            </div>

            @php $columnReservas = $reservas->where('estado', $estado); @endphp
            @forelse($columnReservas as $reserva)
            <div class="reserva-card">
                <div class="card-header-info">
                    <div class="cliente">
                        {{ $reserva->user->name }}
                        <small>{{ $reserva->user->email }}</small>
                    </div>
                    <span class="reserva-id">#{{ $reserva->id }}</span>
                </div>
                <div class="detalle">
                    <span><i class='bx bx-calendar'></i> {{ \Carbon\Carbon::parse($reserva->horario->fecha)->format('d/m/Y') }}</span>
                    <span><i class='bx bx-time'></i> {{ \Carbon\Carbon::parse($reserva->horario->hora)->format('H:i') }}</span>
                    <span><i class='bx bx-dollar'></i> ${{ number_format($reserva->precio->valor, 0, ',', '.') }}</span>
                </div>
                <div class="fecha-creacion">
                    Creada: {{ $reserva->created_at->format('d/m/Y H:i') }}
                </div>
                <div class="acciones">
                    @if($estado == 'Pendiente')
                    <form action="{{ route('reservas.aprobar', $reserva->id) }}" method="post" style="display:inline">
                        @csrf
                        <button type="submit" class="btn-action btn-aprobar"><i class='bx bx-check'></i> Aprobar</button>
                    </form>
                    <form action="{{ route('reservas.rechazar', $reserva->id) }}" method="post" style="display:inline">
                        @csrf
                        <button type="submit" class="btn-action btn-rechazar"><i class='bx bx-x'></i> Rechazar</button>
                    </form>
                    <button class="btn-action btn-reagendar" onclick="openReagendarModal({{ $reserva->id }})">
                        <i class='bx bx-calendar-edit'></i> Reagendar
                    </button>
                    @elseif($estado == 'Aprobada')
                    <button class="btn-action btn-reagendar" onclick="openReagendarModal({{ $reserva->id }})">
                        <i class='bx bx-calendar-edit'></i> Reagendar
                    </button>
                    <form action="{{ route('reservas.rechazar', $reserva->id) }}" method="post" style="display:inline">
                        @csrf
                        <button type="submit" class="btn-action btn-rechazar"><i class='bx bx-x'></i> Cancelar</button>
                    </form>
                    @endif
                    <form action="{{ route('reservas.destroy', $reserva->id) }}" method="POST" style="display:inline" onsubmit="event.preventDefault(); confirmDelete(this)">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-action btn-eliminar"><i class='bx bx-trash'></i></button>
                    </form>
                </div>
            </div>
            @empty
            <div class="empty-kanban">
                <i class='bx bx-inbox'></i>
                <p>Sin reservas</p>
            </div>
            @endforelse
        </div>
        @endforeach
    </div>

    <div class="pagination-wrap">
        {{ $reservas->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>

<div class="modal fade modal-reagendar" id="reagendarModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class='bx bx-calendar-edit' style="color: var(--pitch-green); margin-right: 6px;"></i> Reagendar reserva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Selecciona un nuevo horario disponible:</p>
                <div id="horariosList" style="max-height: 300px; overflow-y: auto;">
                    <p style="color: var(--text-muted);">Cargando horarios...</p>
                </div>
            </div>
            <div class="modal-footer">
                <form id="reagendarForm" method="POST">
                    @csrf
                    <input type="hidden" name="nuevo_horario_id" id="nuevoHorarioId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let reagendarModalInstance = null;

    function openReagendarModal(reservaId) {
        document.getElementById('reagendarForm').action = '/admin/reservas/' + reservaId + '/reagendar';
        document.getElementById('horariosList').innerHTML = '<p style="color: var(--text-muted);">Cargando horarios...</p>';

        fetch('/horarios-disponibles')
            .then(r => r.json())
            .then(horarios => {
                if (horarios.length === 0) {
                    document.getElementById('horariosList').innerHTML = '<p style="color: var(--text-muted);">No hay horarios disponibles</p>';
                    return;
                }
                let html = '';
                horarios.forEach(h => {
                    const fecha = new Date(h.fecha).toLocaleDateString('es-CL');
                    const hora = h.hora.substring(0, 5);
                    html += `<button type="button" class="horario-option" onclick="selectHorario(${h.id})">
                                <i class='bx bx-calendar'></i> ${fecha} - <i class='bx bx-time'></i> ${hora} hrs
                             </button>`;
                });
                document.getElementById('horariosList').innerHTML = html;
            })
            .catch(() => {
                document.getElementById('horariosList').innerHTML = '<p style="color: var(--danger);">Error al cargar horarios</p>';
            });

        if (!reagendarModalInstance) {
            reagendarModalInstance = new bootstrap.Modal(document.getElementById('reagendarModal'));
        }
        reagendarModalInstance.show();
    }

    function selectHorario(id) {
        document.getElementById('nuevoHorarioId').value = id;
        document.querySelectorAll('.horario-option').forEach(el => {
            el.style.borderColor = 'rgba(255,255,255,0.08)';
            el.style.background = 'rgba(255,255,255,0.03)';
        });
        event.target.style.borderColor = '#00f593';
        event.target.style.background = 'rgba(0,245,147,0.06)';
    }

    function confirmDelete(form) {
        Swal.fire({
            title: '¿Eliminar reserva?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ff4466',
            cancelButtonColor: 'rgba(255,255,255,0.08)',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            background: '#12182f',
            color: '#f0f4ff',
            iconColor: '#ffb400'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    }
</script>
@endsection
