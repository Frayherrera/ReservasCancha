@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva #{{ $reserva->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .detail-page {
            padding: 16px;
            max-width: 600px;
            margin: 0 auto;
        }
        .detail-card {
            background: white;
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }
        .detail-card .status-badge {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }
        .detail-card .status-badge.aprobada {
            background: #d4edda;
            color: #155724;
        }
        .detail-card .status-badge.pendiente {
            background: #fff3cd;
            color: #856404;
        }
        .detail-card .status-badge.rechazada {
            background: #f8d7da;
            color: #721c24;
        }
        .detail-card .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .detail-card .info-row:last-child {
            border-bottom: none;
        }
        .detail-card .label {
            color: #6b7280;
        }
        .detail-card .value {
            font-weight: 600;
            color: #1a1a2e;
        }
        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }
        .btn-group .btn {
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            font-size: 0.9rem;
        }
    </style>
</head>

@section('main')
<div class="detail-page">
    <h1 style="font-size:1.4rem; font-weight:700; color:#1a1a2e; margin-bottom:20px;">
        <i class='bx bx-receipt'></i> Reserva #{{ $reserva->id }}
    </h1>

    <div class="detail-card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
            <span class="status-badge {{ strtolower($reserva->estado) }}">{{ $reserva->estado }}</span>
            <span style="color:#9ca3af; font-size:0.85rem;">{{ $reserva->created_at->format('d/m/Y H:i') }}</span>
        </div>

        <div class="info-row">
            <span class="label">Cliente</span>
            <span class="value">{{ $reserva->user->name }}</span>
        </div>
        <div class="info-row">
            <span class="label">Email</span>
            <span class="value">{{ $reserva->user->email }}</span>
        </div>
        <div class="info-row">
            <span class="label">Fecha</span>
            <span class="value">{{ \Carbon\Carbon::parse($reserva->horario->fecha)->format('d/m/Y') }}</span>
        </div>
        <div class="info-row">
            <span class="label">Hora</span>
            <span class="value">{{ \Carbon\Carbon::parse($reserva->horario->hora)->format('H:i') }} hrs</span>
        </div>
        <div class="info-row">
            <span class="label">Monto</span>
            <span class="value">${{ number_format($reserva->precio->valor, 0, ',', '.') }}</span>
        </div>
        @if($reserva->pagoAprobado)
        <div class="info-row">
            <span class="label">Pago</span>
            <span class="value" style="color:#059669;">Pagado ({{ $reserva->pagoAprobado->metodo_pago }})</span>
        </div>
        @endif

        <div class="btn-group">
            <a href="{{ route('reservas.qr', $reserva->id) }}" class="btn" style="background:#003770; color:white;">
                <i class='bx bx-qr'></i> Ver QR
            </a>
            @if($reserva->estado == 'Aprobada' && !$reserva->resena)
            <a href="{{ route('resenas.create', $reserva) }}" class="btn" style="background:linear-gradient(135deg,#f093fb,#f5576c); color:white;">
                <i class='bx bx-star'></i> Calificar
            </a>
            @endif
            @if($reserva->estado == 'Pendiente' && auth()->id() === $reserva->user_id)
            <form action="{{ route('reservas.cancelar', $reserva->id) }}" method="POST" style="display:inline" onsubmit="event.preventDefault(); Swal.fire({title:'¿Cancelar?', text:'Esta acción liberará el horario.', icon:'warning', showCancelButton:true, confirmButtonColor:'#ef4444', cancelButtonColor:'#6c757d', confirmButtonText:'Sí, cancelar', cancelButtonText:'Volver'}).then(r=>r.isConfirmed&&this.submit())">
                @csrf
                <button type="submit" class="btn" style="background:#f8d7da; color:#721c24; border:none; cursor:pointer;">
                    <i class='bx bx-x-circle'></i> Cancelar
                </button>
            </form>
            @endif
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
