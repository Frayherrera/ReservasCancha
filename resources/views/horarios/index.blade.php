@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horarios Disponibles</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .horarios-page {
            padding: 16px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .horarios-page h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 8px;
        }

        .horarios-page .subtitle {
            color: #6b7280;
            margin-bottom: 24px;
        }

        /* Filter bar */
        .filter-bar {
            display: flex;
            gap: 12px;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .filter-bar .date-input {
            flex: 1;
            min-width: 200px;
            padding: 10px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.95rem;
            background: white;
            transition: border-color 0.2s;
        }

        .filter-bar .date-input:focus {
            outline: none;
            border-color: #4facfe;
        }

        .filter-bar .status-filter {
            padding: 10px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.95rem;
            background: white;
            min-width: 150px;
        }

        .btn-filter {
            background: var(--primary, #003770);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-filter:hover {
            background: var(--primary-hover, #1e7ede);
        }

        /* Cards grid */
        .horarios-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .hora-card {
            background: white;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
            position: relative;
            overflow: hidden;
        }

        .hora-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
        }

        .hora-card.disponible::before {
            background: linear-gradient(90deg, #11998e, #38ef7d);
        }

        .hora-card.ocupado::before {
            background: linear-gradient(90deg, #eb3349, #f45c43);
        }

        .hora-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .hora-card .hora {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 4px;
        }

        .hora-card .fecha {
            font-size: 0.8rem;
            color: #6b7280;
            margin-bottom: 12px;
        }

        .hora-card .estado-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 12px;
        }

        .hora-card .estado-badge.disponible {
            background: #d4edda;
            color: #155724;
        }

        .hora-card .estado-badge.ocupado {
            background: #f8d7da;
            color: #721c24;
        }

        .hora-card .estado-badge.pendiente {
            background: #fff3cd;
            color: #856404;
        }

        .hora-card .btn-reservar-card {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: transform 0.2s;
            width: 100%;
        }

        .hora-card .btn-reservar-card:hover {
            transform: scale(1.03);
        }

        .hora-card .btn-disabled-card {
            background: #e5e7eb;
            color: #9ca3af;
            border: none;
            padding: 8px 20px;
            border-radius: 10px;
            font-size: 0.85rem;
            width: 100%;
            cursor: not-allowed;
        }

        /* Desktop table */
        .horarios-tabla-wrap {
            display: block;
        }

        .horarios-tabla {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
        }

        .horarios-tabla th {
            background: var(--primary, #003770);
            color: white;
            padding: 14px 16px;
            text-align: left;
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .horarios-tabla td {
            padding: 12px 16px;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }

        .horarios-tabla tr:last-child td {
            border-bottom: none;
        }

        .horarios-tabla tr:hover td {
            background: #f8faff;
        }

        .estado {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .estado.disponible {
            background: #d4edda;
            color: #155724;
        }

        .estado.no.disponible,
        .estado.ocupado {
            background: #f8d7da;
            color: #721c24;
        }

        .estado.esperando {
            background: #fff3cd;
            color: #856404;
        }

        .btn-reservar {
            background: #4facfe;
            color: white;
            border: none;
            padding: 7px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-reservar:hover {
            background: #3d8bda;
        }

        .btn-disabled {
            background: #e5e7eb;
            color: #9ca3af;
            border: none;
            padding: 7px 16px;
            border-radius: 8px;
            cursor: not-allowed;
        }

        .btn-group {
            display: inline-flex;
            gap: 6px;
        }

        .btn-group .btn {
            padding: 4px 12px;
            font-size: 0.8rem;
            border-radius: 6px;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 14px;
            color: #6b7280;
        }

        .empty-state i {
            font-size: 56px;
            color: #d1d5db;
            margin-bottom: 16px;
        }

        /* Alert styles */
        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 16px;
            font-size: 0.9rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* ===== RESPONSIVE ===== */
        @media (min-width: 769px) {
            .horarios-grid {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .horarios-tabla-wrap {
                display: none;
            }

            .horarios-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }

            .filter-bar {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-bar .date-input,
            .filter-bar .status-filter {
                min-width: unset;
            }
        }

        @media (max-width: 400px) {
            .horarios-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
            }

            .hora-card {
                padding: 14px;
            }

            .hora-card .hora {
                font-size: 1.2rem;
            }
        }
    </style>
</head>

@section('main')
<div class="horarios-page">
    <h1><i class='bx bx-calendar'></i> Horarios disponibles</h1>
    <p class="subtitle">Selecciona una fecha y reserva tu espacio</p>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="filter-bar">
        <input type="text" id="dateFilter" class="date-input" placeholder="Filtrar por fecha..." autocomplete="off">
        <select id="statusFilter" class="status-filter">
            <option value="">Todos los estados</option>
            <option value="Disponible">Disponibles</option>
            <option value="No Disponible">No disponibles</option>
        </select>
        <button class="btn-filter" onclick="applyFilters()">Filtrar</button>
    </div>

    @if($horarios->isEmpty())
    <div class="empty-state">
        <i class='bx bx-calendar-x'></i>
        <p>No existen horarios disponibles</p>
    </div>
    @else
    <!-- Cards view (mobile) -->
    <div class="horarios-grid" id="horariosGrid">
        @foreach($horarios as $horario)
        <div class="hora-card {{ strtolower(str_replace(' ', '-', $horario->estado)) }}"
        data-fecha="{{ $horario->fecha }}"
        data-estado="{{ $horario->estado }}">
        <div class="hora">{{ \Carbon\Carbon::parse($horario->hora)->format('H:i') }}</div>
        <div class="fecha">{{ \Carbon\Carbon::parse($horario->fecha)->format('d/m/Y') }}</div>
        <span class="estado-badge {{ strtolower(str_replace(' ', '-', $horario->estado)) }}">
            {{ $horario->estado == 'Disponible' ? 'Disponible' : 'Reservado' }}
        </span>
        @auth
        @if($horario->estado == 'Disponible')
        <button class="btn-reservar-card" onclick="openReservaModal({{ $horario->id }}, '{{ \Carbon\Carbon::parse($horario->fecha)->format('d/m/Y') }}', '{{ \Carbon\Carbon::parse($horario->hora)->format('H:i') }}')">
            Reservar
        </button>
        @else
        <button class="btn-disabled-card" disabled>No disponible</button>
        @endif
        @else
        <button class="btn-reservar-card" onclick="alert('Debes iniciar sesión para reservar.')">Reservar</button>
        @endauth
    </div>
    @endforeach
</div>

<!-- Table view (desktop) -->
<div class="horarios-tabla-wrap">
    <table class="horarios-tabla" id="horariosTable">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($horarios as $horario)
            <tr data-fecha="{{ $horario->fecha }}" data-estado="{{ $horario->estado }}">
                <td>{{ \Carbon\Carbon::parse($horario->fecha)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($horario->hora)->format('H:i') }}</td>
                <td>
                    @if($horario->reserva)
                    <span class="estado ocupado">Reservada</span>
                    @elseif($horario->estado == 'Disponible')
                    <span class="estado disponible">Disponible</span>
                    @else
                    <span class="estado esperando">Esperando Respuesta</span>
                    @endif
                </td>
                <td>
                    @if($horario->estado == 'Disponible')
                    @auth
                    <button class="btn-reservar"
                    onclick="openReservaModal({{ $horario->id }}, '{{ \Carbon\Carbon::parse($horario->fecha)->format('d/m/Y') }}', '{{ \Carbon\Carbon::parse($horario->hora)->format('H:i') }}')">
                    Reservar
                </button>
                @else
                <button class="btn-reservar" onclick="alert('Debes iniciar sesión para realizar una reserva.');">Reservar</button>
                @endauth
                @else
                <button class="btn-disabled" disabled>X</button>
                @endif

                @can('crear horarios')
                <div class="btn-group">
                    <a href="{{ route('horarios.edit', $horario) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('horarios.destroy', $horario) }}" method="POST" style="display:inline" onsubmit="event.preventDefault(); confirmarEliminacion(this);">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </div>
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $horarios->links('pagination::bootstrap-4') }}
</div>
@endif
</div>

<!-- Modal de Confirmación -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-confirm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmar Reserva</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div style="font-size: 3rem; color: #4facfe; margin-bottom: 12px;">
                    <i class='bx bx-football'></i>
                </div>
                <p id="modalText" style="font-size: 1.1rem; margin: 0;"></p>
            </div>
            <div class="modal-footer justify-content-center">
                <form id="reservaForm" action="{{ route('reservas.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="horario_id" id="modalHorarioId">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #4facfe, #00f2fe); border: none; padding: 10px 24px; border-radius: 10px; font-weight: 600;">
                        Confirmar Reserva
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    flatpickr("#dateFilter", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "d/m/Y",
        allowInput: true,
        onChange: function(selectedDates, dateStr) {
            applyFilters();
        }
    });

    function applyFilters() {
        const date = document.getElementById('dateFilter').value;
        const status = document.getElementById('statusFilter').value;

        document.querySelectorAll('#horariosTable tbody tr, .horarios-grid .hora-card').forEach(el => {
            const rowDate = el.dataset.fecha;
            const rowStatus = el.dataset.estado;
            let show = true;

            if (date && rowDate !== date) show = false;
            if (status && rowStatus !== status) show = false;

            el.style.display = show ? '' : 'none';
        });
    }

    function openReservaModal(id, fecha, hora) {
        document.getElementById('modalHorarioId').value = id;
        document.getElementById('modalText').innerHTML =
            ¿Deseas reservar el horario del <strong>' + fecha + '</strong> a las <strong>' + hora + '</strong> hrs?;
        const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
        modal.show();
    }

    function confirmarEliminacion(form) {
        Swal.fire({
            title: '¿Eliminar horario?',
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

    // Auto-hide alerts
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(function() { alert.remove(); }, 500);
            }, 5000);
        });
    });
</script>
@endsection
