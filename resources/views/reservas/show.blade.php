@extends('layouts.app')

@push('styles')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reserva #{{ $reserva->id }}</title>
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

    .detail-page {
        padding: 28px 32px;
        max-width: 650px;
        margin: 0 auto;
        position: relative;
    }

    .detail-page::before {
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
        margin-bottom: 24px;
    }

    .page-header h1 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 2rem;
        letter-spacing: 2px;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-header h1 i {
        color: var(--pitch-green);
        font-size: 1.8rem;
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

    .detail-card {
        position: relative;
        z-index: 1;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius);
        padding: 28px;
        backdrop-filter: blur(12px);
    }

    .detail-card .top-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 18px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        font-family: 'Outfit', sans-serif;
    }

    .status-badge.aprobada {
        background: rgba(0, 245, 147, 0.12);
        color: var(--pitch-green);
    }

    .status-badge.pendiente {
        background: rgba(255, 180, 0, 0.12);
        color: var(--amber);
    }

    .status-badge.rechazada {
        background: rgba(255, 68, 102, 0.12);
        color: var(--danger);
    }

    .detail-card .fecha-creacion {
        color: var(--text-muted);
        font-size: 0.8rem;
    }

    .detail-card .info-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    }

    .detail-card .info-row:last-of-type {
        border-bottom: none;
    }

    .detail-card .label {
        color: var(--text-secondary);
        font-size: 0.88rem;
    }

    .detail-card .value {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.92rem;
    }

    .detail-card .value.pagado {
        color: var(--pitch-green);
    }

    .btn-group {
        display: flex;
        gap: 10px;
        margin-top: 24px;
        flex-wrap: wrap;
        padding-top: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.04);
    }

    .btn-group .btn {
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
        border: none;
        cursor: pointer;
    }

    .btn-group .btn:hover {
        transform: translateY(-2px);
    }

    .btn-primary-custom {
        background: var(--pitch-green);
        color: #0b0f1c;
    }

    .btn-primary-custom:hover {
        box-shadow: 0 4px 16px var(--pitch-green-glow);
        color: #0b0f1c;
    }

    .btn-danger-custom {
        background: rgba(255, 68, 102, 0.12);
        color: var(--danger);
    }

    .btn-danger-custom:hover {
        box-shadow: 0 4px 16px rgba(255, 68, 102, 0.2);
    }

    @media (max-width: 768px) {
        .detail-page {
            padding: 16px;
        }
        .page-header h1 {
            font-size: 1.4rem;
        }
    }
</style>
@endpush

@section('main')
<div class="detail-page">
    <div class="page-header">
        <div>
            <h1>
                <i class='bx bx-receipt'></i>
                Reserva #{{ $reserva->id }}
            </h1>
            <span class="header-accent"></span>
        </div>
    </div>

    <div class="detail-card">
        <div class="top-row">
            <span class="status-badge {{ strtolower($reserva->estado) }}">{{ $reserva->estado }}</span>
            <span class="fecha-creacion">{{ $reserva->created_at->format('d/m/Y H:i') }}</span>
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
            <span class="value pagado">Pagado ({{ $reserva->pagoAprobado->metodo_pago }})</span>
        </div>
        @endif

        <div class="btn-group">
            <a href="{{ route('reservas.qr', $reserva->id) }}" class="btn btn-primary-custom">
                <i class='bx bx-qr'></i> Ver QR
            </a>
            @if($reserva->estado == 'Aprobada' && !$reserva->resena)
            <a href="{{ route('resenas.create', $reserva) }}" class="btn btn-primary-custom">
                <i class='bx bx-star'></i> Calificar
            </a>
            @endif
            @if($reserva->estado == 'Pendiente' && auth()->id() === $reserva->user_id)
            <form action="{{ route('reservas.cancelar', $reserva->id) }}" method="POST" style="display:inline" onsubmit="event.preventDefault(); Swal.fire({title:'¿Cancelar reserva?', text:'Esta acción liberará el horario.', icon:'warning', showCancelButton:true, confirmButtonColor:'#ff4466', cancelButtonColor:'rgba(255,255,255,0.08)', confirmButtonText:'Sí, cancelar', cancelButtonText:'Volver', background:'#12182f', color:'#f0f4ff', iconColor:'#ffb400'}).then(r=>r.isConfirmed&&this.submit())">
                @csrf
                <button type="submit" class="btn btn-danger-custom">
                    <i class='bx bx-x-circle'></i> Cancelar
                </button>
            </form>
            @endif
        </div>
    </div>
</div>
@endpush
@endsection
