@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    </script>
    <style>
        .reservas-page {
            padding: 16px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .reservas-page h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 8px;
        }

        .reservas-page .subtitle {
            color: #6b7280;
            margin-bottom: 24px;
        }

        /* Stats */
        .reservas-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 14px;
            margin-bottom: 24px;
        }

        .reserva-stat {
            background: white;
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .reserva-stat h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
        }

        .reserva-stat p {
            margin: 2px 0 0;
            font-size: 0.8rem;
            color: #6b7280;
        }

        /* Filter bar */
        .filter-bar {
            display: flex;
            gap: 12px;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            background: white;
            padding: 16px;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .filter-bar input,
        .filter-bar select {
            padding: 10px 14px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 0.9rem;
            background: white;
        }

        .filter-bar input:focus,
        .filter-bar select:focus {
            outline: none;
            border-color: #4facfe;
        }

        .filter-bar .search-input {
            flex: 1;
            min-width: 180px;
        }

        .filter-bar .btn-filter {
            background: #003770;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
        }

        /* Kanban columns */
        .kanban {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .kanban-column {
            background: #f8f9fb;
            border-radius: 14px;
            padding: 16px;
            min-height: 300px;
        }

        .kanban-column .column-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            padding-bottom: 10px;
            border-bottom: 3px solid;
        }

        .kanban-column .column-header h3 {
            font-size: 0.95rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .kanban-column .column-header .count {
            background: #e5e7eb;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .kanban-column.pendiente .column-header {
            border-color: #fbbf24;
        }
        .kanban-column.pendiente .column-header h3 {
            color: #92400e;
        }

        .kanban-column.aprobada .column-header {
            border-color: #34d399;
        }
        .kanban-column.aprobada .column-header h3 {
            color: #065f46;
        }

        .kanban-column.rechazada .column-header {
            border-color: #f87171;
        }
        .kanban-column.rechazada .column-header h3 {
            color: #991b1b;
        }

        .reserva-card {
            background: white;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 10px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.06);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .reserva-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
            color: #1a1a2e;
        }

        .reserva-card .cliente small {
            display: block;
            font-weight: 400;
            font-size: 0.75rem;
            color: #6b7280;
        }

        .reserva-card .reserva-id {
            font-size: 0.75rem;
            color: #9ca3af;
            font-weight: 600;
        }

        .reserva-card .detalle {
            font-size: 0.85rem;
            color: #4b5563;
            margin-bottom: 8px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .reserva-card .detalle i {
            color: #4facfe;
            width: 16px;
        }

        .reserva-card .acciones {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #f0f0f0;
        }

        .reserva-card .acciones .btn-action {
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: transform 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .reserva-card .acciones .btn-action:hover {
            transform: scale(1.03);
        }

        .btn-aprobar {
            background: #d4edda;
            color: #155724;
        }
        .btn-rechazar {
            background: #f8d7da;
            color: #721c24;
        }
        .btn-reagendar {
            background: #fff3cd;
            color: #856404;
        }
        .btn-eliminar {
            background: #f3f4f6;
            color: #6b7280;
        }

        /* Desktop table fallback */
        .table-wrap {
            display: none;
        }

        /* Empty state */
        .empty-kanban {
            text-align: center;
            padding: 40px 20px;
            color: #9ca3af;
        }

        .empty-kanban i {
            font-size: 36px;
            margin-bottom: 8px;
        }

        /* Modal reagendar */
        .modal-reagendar .horario-option {
            display: block;
            width: 100%;
            padding: 10px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            margin-bottom: 8px;
            background: white;
            cursor: pointer;
            text-align: left;
            transition: border-color 0.2s;
            font-size: 0.9rem;
        }

        .modal-reagendar .horario-option:hover {
            border-color: #4facfe;
        }

        /* Paginación */
        .pagination-wrap {
            margin-top: 24px;
            display: flex;
            justify-content: center;
        }

        @media (max-width: 900px) {
            .kanban {
                grid-template-columns: 1fr;
            }
            .filter-bar {
                flex-direction: column;
                align-items: stretch;
            }
            .filter-bar .search-input {
                min-width: unset;
            }
        }

        @media (min-width: 901px) {
            .table-wrap-mobile {
                display: none;
            }
        }
    </style>
</head>

@section('main')
<div class="reservas-page">
    <h1><i class='bx bx-calendar-check'></i> Gestión de Reservas</h1>
    <p class="subtitle">Administra las reservas de los clientes</p>

    @if(session('success'))
    <script>
        Swal.fire({ icon: 'success', title: 'Operación Exitosa', text: "{{ session('success') }}", confirmButtonText: 'Aceptar' });
    </script>
    @endif
    @if(session('error'))
    <script>
        Swal.fire({ icon: 'error', title: 'Error', text: "{{ session('error') }}", confirmButtonText: 'Aceptar' });
    </script>
    @endif

    <div class="reservas-stats">
        <div class="reserva-stat">
            <h3 style="color: #003770;">{{ $resumen['total'] }}</h3>
            <p>Total</p>
        </div>
        <div class="reserva-stat">
            <h3 style="color: #92400e;">{{ $resumen['pendientes'] }}</h3>
            <p>Pendientes</p>
        </div>
        <div class="reserva-stat">
            <h3 style="color: #065f46;">{{ $resumen['aprobadas'] }}</h3>
            <p>Aprobadas</p>
        </div>
        <div class="reserva-stat">
            <h3 style="color: #991b1b;">{{ $resumen['rechazadas'] }}</h3>
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
        <a href="{{ route('reservas.index') }}" style="color: #6b7280; font-size: 0.85rem;">Limpiar filtros</a>
        @endif
    </form>

    @if($reservas->isEmpty())
    <div style="text-align:center; padding:60px 20px; background:white; border-radius:14px; color:#6b7280;">
        <i class='bx bx-calendar-x' style="font-size:48px; color:#d1d5db;"></i>
        <p>No se encontraron reservas</p>
    </div>
    @else
    <!-- Kanban view -->
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
                <div style="font-size:0.78rem; color:#9ca3af;">
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

<!-- Modal Reagendar -->
<div class="modal fade modal-reagendar" id="reagendarModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reagendar reserva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p style="color:#6b7280; margin-bottom:16px;">Selecciona un nuevo horario disponible:</p>
                <div id="horariosList" style="max-height: 300px; overflow-y: auto;">
                    <p style="color:#9ca3af;">Cargando horarios...</p>
                </div>
            </div>
            <div class="modal-footer">
                <form id="reagendarForm" method="POST">
                    @csrf
                    <input type="hidden" name="nuevo_horario_id" id="nuevoHorarioId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" style="background:linear-gradient(135deg,#4facfe,#00f2fe); border:none; padding:10px 24px; border-radius:10px; font-weight:600;">Confirmar</button>
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
        document.getElementById('horariosList').innerHTML = '<p style="color:#9ca3af;">Cargando horarios...</p>';

        fetch('/horarios-disponibles')
            .then(r => r.json())
            .then(horarios => {
                if (horarios.length === 0) {
                    document.getElementById('horariosList').innerHTML = '<p style="color:#9ca3af;">No hay horarios disponibles</p>';
                    return;
                }
                let html = '';
                horarios.forEach(h => {
                    const fecha = new Date(h.fecha).toLocaleDateString('es-CL');
                    const hora = h.hora.substring(0, 5);
                    html += `<button type="button" class="horario-option" onclick="selectHorario(${h.id}, '${fecha}', '${hora}')">
                                <i class='bx bx-calendar'></i> ${fecha} - <i class='bx bx-time'></i> ${hora} hrs
                             </button>`;
                });
                document.getElementById('horariosList').innerHTML = html;
            })
            .catch(() => {
                document.getElementById('horariosList').innerHTML = '<p style="color:#ef4444;">Error al cargar horarios</p>';
            });

        if (!reagendarModalInstance) {
            reagendarModalInstance = new bootstrap.Modal(document.getElementById('reagendarModal'));
        }
        reagendarModalInstance.show();
    }

    function selectHorario(id, fecha, hora) {
        document.getElementById('nuevoHorarioId').value = id;
        document.querySelectorAll('.horario-option').forEach(el => el.style.borderColor = '#e5e7eb');
        event.target.style.borderColor = '#4facfe';
        event.target.style.background = '#f0f7ff';
    }

    function confirmDelete(form) {
        Swal.fire({
            title: '¿Eliminar reserva?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    }
</script>
@endsection
