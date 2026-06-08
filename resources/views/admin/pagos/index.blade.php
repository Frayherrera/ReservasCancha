@extends('layouts.app')

@push('styles')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestión de Pagos</title>
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
        --danger: #ff4466;
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

    .pagos-page {
        padding: 28px 32px;
        max-width: 1400px;
        margin: 0 auto;
        position: relative;
    }

    .pagos-page::before {
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

    .btn-nuevo {
        background: var(--pitch-green);
        color: #0b0f1c;
        border: none;
        padding: 10px 22px;
        border-radius: var(--radius-sm);
        font-weight: 700;
        font-family: 'Outfit', sans-serif;
        text-decoration: none;
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: transform 0.2s, box-shadow 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-nuevo:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px var(--pitch-green-glow);
        color: #0b0f1c;
    }

    .stats-row {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 14px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius);
        padding: 18px;
        backdrop-filter: blur(12px);
        display: flex;
        align-items: center;
        gap: 14px;
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), border-color 0.3s;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        opacity: 0.2;
    }

    .stat-card:nth-child(1)::before { background: var(--pitch-green); }
    .stat-card:nth-child(2)::before { background: var(--pitch-green); }
    .stat-card:nth-child(3)::before { background: var(--amber); }
    .stat-card:nth-child(4)::before { background: var(--pitch-green); }

    .stat-card:hover {
        transform: translateY(-3px);
    }

    .stat-card .icon {
        width: 44px;
        height: 44px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .stat-card:nth-child(1) .icon { background: rgba(0, 245, 147, 0.1); color: var(--pitch-green); }
    .stat-card:nth-child(2) .icon { background: rgba(0, 245, 147, 0.1); color: var(--pitch-green); }
    .stat-card:nth-child(3) .icon { background: rgba(255, 180, 0, 0.1); color: var(--amber); }
    .stat-card:nth-child(4) .icon { background: rgba(0, 245, 147, 0.1); color: var(--pitch-green); }

    .stat-card .info h3 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.4rem;
        letter-spacing: 1px;
        margin: 0;
        color: var(--text-primary);
    }

    .stat-card .info p {
        margin: 2px 0 0;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-secondary);
    }

    .filter-bar {
        position: relative;
        z-index: 1;
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        padding: 16px 20px;
        border-radius: var(--radius);
        margin-bottom: 24px;
        backdrop-filter: blur(12px);
    }

    .filter-bar form {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        align-items: center;
        width: 100%;
    }

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

    .filter-bar select:focus {
        border-color: var(--pitch-green);
        box-shadow: 0 0 0 3px rgba(0, 245, 147, 0.06);
    }

    .filter-bar select option {
        background: #12182f;
        color: var(--text-primary);
    }

    .btn-filter {
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

    .btn-filter:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 16px var(--pitch-green-glow);
    }

    .section-title {
        position: relative;
        z-index: 1;
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.2rem;
        letter-spacing: 1px;
        color: var(--text-primary);
        margin: 24px 0 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-title i {
        color: var(--pitch-green);
    }

    .table-wrap {
        position: relative;
        z-index: 1;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius);
        overflow: hidden;
        backdrop-filter: blur(12px);
    }

    .table-wrap table {
        width: 100%;
        border-collapse: collapse;
    }

    .table-wrap th {
        background: rgba(0, 245, 147, 0.04);
        color: var(--text-secondary);
        padding: 12px 16px;
        text-align: left;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    }

    .table-wrap td {
        padding: 12px 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        font-size: 0.88rem;
        color: var(--text-primary);
    }

    .table-wrap tr:last-child td {
        border-bottom: none;
    }

    .table-wrap tr:hover td {
        background: rgba(255, 255, 255, 0.02);
    }

    .badge-estado {
        padding: 3px 12px;
        border-radius: 12px;
        font-size: 0.72rem;
        font-weight: 600;
        display: inline-block;
    }

    .badge-Pagado {
        background: rgba(0, 245, 147, 0.12);
        color: var(--pitch-green);
    }

    .badge-Pendiente {
        background: rgba(255, 180, 0, 0.12);
        color: var(--amber);
    }

    .badge-Cancelado {
        background: rgba(255, 68, 102, 0.12);
        color: var(--danger);
    }

    .badge-Reembolsado {
        background: rgba(255, 255, 255, 0.06);
        color: var(--text-muted);
    }

    .btn-accion {
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        font-family: 'Outfit', sans-serif;
        border: none;
        cursor: pointer;
        transition: transform 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        text-decoration: none;
    }

    .btn-accion:hover {
        transform: scale(1.03);
    }

    .btn-verde {
        background: rgba(0, 245, 147, 0.12);
        color: var(--pitch-green);
        border: 1px solid rgba(0, 245, 147, 0.12);
    }

    .btn-amarillo {
        background: rgba(255, 180, 0, 0.12);
        color: var(--amber);
        border: 1px solid rgba(255, 180, 0, 0.12);
    }

    .btn-rojo {
        background: rgba(255, 68, 102, 0.12);
        color: var(--danger);
        border: 1px solid rgba(255, 68, 102, 0.12);
    }

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

    @media (max-width: 768px) {
        .pagos-page {
            padding: 16px;
        }
        .page-header h1 {
            font-size: 1.8rem;
        }
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .filter-bar form {
            flex-direction: column;
        }
        .table-wrap {
            overflow-x: auto;
        }
    }
</style>
@endpush

@section('main')
<div class="pagos-page">
    <div class="page-header">
        <div>
            <h1>
                <i class='bx bx-credit-card'></i>
                Gestión de Pagos
            </h1>
            <p class="subtitle">Control de pagos de reservas</p>
            <span class="header-accent"></span>
        </div>
        <a href="{{ route('admin.pagos.create') }}" class="btn-nuevo">
            <i class='bx bx-plus'></i> Nuevo pago
        </a>
    </div>

    @if(session('success'))
    <script>
        Swal.fire({ icon: 'success', title: 'Éxito', text: "{{ session('success') }}", confirmButtonText: 'Aceptar', background: '#12182f', color: '#f0f4ff', iconColor: '#00f593', confirmButtonColor: '#00f593' });
    </script>
    @endif

    <div class="stats-row">
        <div class="stat-card">
            <div class="icon"><i class='bx bx-credit-card'></i></div>
            <div class="info">
                <h3>{{ $resumen['total'] }}</h3>
                <p>Total pagos</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon"><i class='bx bx-check-circle'></i></div>
            <div class="info">
                <h3>${{ number_format($resumen['pagados'], 0, ',', '.') }}</h3>
                <p>Total recaudado</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon"><i class='bx bx-time'></i></div>
            <div class="info">
                <h3>{{ $resumen['pendientes'] }}</h3>
                <p>Pendientes</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon"><i class='bx bx-calendar-check'></i></div>
            <div class="info">
                <h3>{{ $resumen['contador_pagados'] }}</h3>
                <p>Pagados</p>
            </div>
        </div>
    </div>

    <div class="filter-bar">
        <form method="GET" action="{{ route('admin.pagos.index') }}">
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
            <button type="submit" class="btn-filter">Filtrar</button>
        </form>
    </div>

    @if(!$reservasSinPago->isEmpty())
    <div class="section-title">
        <i class='bx bx-bell'></i> Reservas sin pago registrado
    </div>
    <div class="table-wrap" style="margin-bottom:24px;">
        <table>
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
                    <td><strong>#{{ $r->id }}</strong></td>
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
    </div>
    @endif

    <div class="section-title">
        <i class='bx bx-list-ul'></i> Todos los pagos
    </div>

    @if($pagos->isEmpty())
    <div class="empty-state">
        <i class='bx bx-credit-card-front'></i>
        <p>No hay pagos registrados</p>
    </div>
    @else
    <div class="table-wrap">
        <table>
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
                    <td><strong>#{{ $pago->id }}</strong></td>
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
                        <div style="display:flex; gap:4px; flex-wrap:wrap;">
                            @if($pago->estado == 'Pendiente')
                            <form action="{{ route('admin.pagos.marcarPagado', $pago) }}" method="POST" style="display:inline">
                                @csrf
                                <button type="submit" class="btn-accion btn-verde"><i class='bx bx-check'></i> Pagado</button>
                            </form>
                            @endif
                            <a href="{{ route('admin.pagos.edit', $pago) }}" class="btn-accion btn-amarillo"><i class='bx bx-edit'></i></a>
                            <form action="{{ route('admin.pagos.destroy', $pago) }}" method="POST" style="display:inline" onsubmit="event.preventDefault(); Swal.fire({title:'¿Eliminar?', text:'Esta acción no se puede deshacer.', icon:'warning', showCancelButton:true, confirmButtonColor:'#ff4466', cancelButtonColor:'rgba(255,255,255,0.08)', confirmButtonText:'Sí, eliminar', cancelButtonText:'Cancelar', background:'#12182f', color:'#f0f4ff', iconColor:'#ffb400'}).then(r=>r.isConfirmed&&this.submit())">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-accion btn-rojo"><i class='bx bx-trash'></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-4" style="position:relative; z-index:1;">
        {{ $pagos->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>
@endsection
