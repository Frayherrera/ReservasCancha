@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pagos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    </script>
    <style>
        .pagos-page {
            padding: 16px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .pagos-page h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1a1a2e;
        }

        .pagos-page .subtitle {
            color: #6b7280;
            margin-bottom: 24px;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 14px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 18px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .stat-card .icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
            flex-shrink: 0;
        }

        .stat-card .info h3 {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
        }
        .stat-card .info p {
            margin: 2px 0 0;
            font-size: 0.8rem;
            color: #6b7280;
        }

        .filter-bar {
            display: flex;
            gap: 12px;
            background: white;
            padding: 16px;
            border-radius: 14px;
            margin-bottom: 24px;
            flex-wrap: wrap;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .filter-bar select {
            padding: 8px 14px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            background: white;
        }

        .filter-bar .btn-action {
            background: #003770;
            color: white;
            border: none;
            padding: 8px 18px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
        }

        .table-pagos {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .table-pagos th {
            background: #003770;
            color: white;
            padding: 12px 14px;
            text-align: left;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .table-pagos td {
            padding: 10px 14px;
            border-bottom: 1px solid #f0f0f0;
            font-size: 0.9rem;
        }

        .table-pagos tr:hover td {
            background: #f8faff;
        }

        .badge-estado {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-Pagado {
            background: #d4edda;
            color: #155724;
        }
        .badge-Pendiente {
            background: #fff3cd;
            color: #856404;
        }
        .badge-Cancelado {
            background: #f8d7da;
            color: #721c24;
        }
        .badge-Reembolsado {
            background: #e2e3e5;
            color: #383d41;
        }

        .btn-accion {
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .btn-accion:hover {
            transform: scale(1.03);
        }
        .btn-verde {
            background: #d4edda;
            color: #155724;
        }
        .btn-amarillo {
            background: #fff3cd;
            color: #856404;
        }
        .btn-rojo {
            background: #f8d7da;
            color: #721c24;
        }

        .section-title {
            font-size: 1.05rem;
            font-weight: 600;
            margin: 24px 0 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .section-title i {
            color: #4facfe;
        }

        @media (max-width: 768px) {
            .table-pagos th,
            .table-pagos td {
                padding: 8px 10px;
                font-size: 0.8rem;
            }
            .filter-bar {
                flex-direction: column;
            }
        }
    </style>
</head>

@section('main')
<div class="pagos-page">
    <h1><i class='bx bx-credit-card'></i> Gestión de Pagos</h1>
    <p class="subtitle">Control de pagos de reservas</p>

    @if(session('success'))
    <script>
        Swal.fire({ icon: 'success', title: 'Éxito', text: "{{ session('success') }}", confirmButtonText: 'Aceptar' });
    </script>
    @endif

    <div class="stats-row">
        <div class="stat-card">
            <div class="icon" style="background:linear-gradient(135deg,#4facfe,#00f2fe);"><i class='bx bx-credit-card'></i></div>
            <div class="info">
                <h3>{{ $resumen['total'] }}</h3>
                <p>Total pagos</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon" style="background:linear-gradient(135deg,#11998e,#38ef7d);"><i class='bx bx-check-circle'></i></div>
            <div class="info">
                <h3>${{ number_format($resumen['pagados'], 0, ',', '.') }}</h3>
                <p>Total recaudado</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon" style="background:linear-gradient(135deg,#f093fb,#f5576c);"><i class='bx bx-time'></i></div>
            <div class="info">
                <h3>{{ $resumen['pendientes'] }}</h3>
                <p>Pendientes</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon" style="background:linear-gradient(135deg,#fa709a,#fee140);"><i class='bx bx-calendar-check'></i></div>
            <div class="info">
                <h3>{{ $resumen['contador_pagados'] }}</h3>
                <p>Pagados</p>
            </div>
        </div>
    </div>

    <div class="filter-bar">
        <form method="GET" action="{{ route('admin.pagos.index') }}" style="display:flex; gap:12px; flex-wrap:wrap; align-items:center; width:100%;">
            <select name="estado">
                <option value="">Todos los estados</option>
                <option value="Pendiente" {{ request('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="Pagado" {{ request('estado') == 'Pagado' ? 'selected' : '' }}>Pagado</option>
                <option value="Cancelado" {{ request('estado') == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                <option value="Reembolsado" {{ request('estado') == 'Reembolsado' ? 'selected' : '' }}>Reembolsado</option>
            </select>
            <select name="metodo">
                <option value="">Todos los métodos</option>
                <option value="Efectivo" {{ request('metodo') == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                <option value="Transferencia" {{ request('metodo') == 'Transferencia' ? 'selected' : '' }}>Transferencia</option>
                <option value="Tarjeta" {{ request('metodo') == 'Tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                <option value="Pago en línea" {{ request('metodo') == 'Pago en línea' ? 'selected' : '' }}>Pago en línea</option>
            </select>
            <button type="submit" class="btn-action">Filtrar</button>
            <a href="{{ route('admin.pagos.create') }}" style="margin-left:auto; background:linear-gradient(135deg,#4facfe,#00f2fe); color:white; padding:8px 18px; border-radius:10px; text-decoration:none; font-weight:600; font-size:0.9rem;">
                <i class='bx bx-plus'></i> Nuevo pago
            </a>
        </form>
    </div>

    @if(!$reservasSinPago->isEmpty())
    <div class="section-title">
        <i class='bx bx-bell'></i> Reservas sin pago registrado
    </div>
    <table class="table-pagos" style="margin-bottom:24px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Reserva</th>
                <th>Monto</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservasSinPago->take(5) as $r)
            <tr>
                <td>#{{ $r->id }}</td>
                <td>{{ $r->user->name }}</td>
                <td>{{ \Carbon\Carbon::parse($r->horario->fecha)->format('d/m') }} {{ \Carbon\Carbon::parse($r->horario->hora)->format('H:i') }}</td>
                <td>${{ number_format($r->precio->valor, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('admin.pagos.create', ['reserva_id' => $r->id]) }}" class="btn-accion btn-verde">
                        <i class='bx bx-dollar'></i> Registrar pago
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <div class="section-title">
        <i class='bx bx-list-ul'></i> Todos los pagos
    </div>

    @if($pagos->isEmpty())
    <div style="text-align:center; padding:40px; background:white; border-radius:14px; color:#6b7280;">
        <i class='bx bx-credit-card-front' style="font-size:48px; color:#d1d5db;"></i>
        <p>No hay pagos registrados</p>
    </div>
    @else
    <table class="table-pagos">
        <thead>
            <tr>
                <th>ID</th>
                <th>Reserva</th>
                <th>Cliente</th>
                <th>Monto</th>
                <th>Método</th>
                <th>Referencia</th>
                <th>Estado</th>
                <th>Fecha</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pagos as $pago)
            <tr>
                <td>#{{ $pago->id }}</td>
                <td>#{{ $pago->reserva_id }}</td>
                <td>{{ $pago->reserva->user->name ?? '—' }}</td>
                <td>${{ number_format($pago->monto, 0, ',', '.') }}</td>
                <td>{{ $pago->metodo_pago }}</td>
                <td>{{ $pago->referencia ?: '—' }}</td>
                <td>
                    <span class="badge-estado badge-{{ $pago->estado }}">{{ $pago->estado }}</span>
                </td>
                <td>{{ $pago->fecha_pago ? $pago->fecha_pago->format('d/m/Y') : '—' }}</td>
                <td>
                    @if($pago->estado == 'Pendiente')
                    <form action="{{ route('admin.pagos.marcarPagado', $pago) }}" method="POST" style="display:inline">
                        @csrf
                        <button type="submit" class="btn-accion btn-verde"><i class='bx bx-check'></i> Pagado</button>
                    </form>
                    @endif
                    <a href="{{ route('admin.pagos.edit', $pago) }}" class="btn-accion btn-amarillo"><i class='bx bx-edit'></i></a>
                    <form action="{{ route('admin.pagos.destroy', $pago) }}" method="POST" style="display:inline" onsubmit="event.preventDefault(); Swal.fire({title:'¿Eliminar?', text:'Esta acción no se puede deshacer.', icon:'warning', showCancelButton:true, confirmButtonColor:'#d33', cancelButtonColor:'#6c757d', confirmButtonText:'Sí, eliminar', cancelButtonText:'Cancelar'}).then(r=>r.isConfirmed&&this.submit())">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-accion btn-rojo"><i class='bx bx-trash'></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center mt-4">
        {{ $pagos->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>
@endsection
