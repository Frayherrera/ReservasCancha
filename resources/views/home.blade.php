@extends('layouts.app')

@push('styles')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>ReservaFutbol - Mis Reservas</title>
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

    .home-cliente {
        padding: 28px 32px;
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
    }

    .home-cliente::before {
        content: '';
        position: fixed;
        inset: 0;
        background:
            repeating-linear-gradient(0deg, transparent, transparent 60px, rgba(0, 245, 147, 0.01) 60px, rgba(0, 245, 147, 0.01) 61px),
            repeating-linear-gradient(90deg, transparent, transparent 60px, rgba(0, 245, 147, 0.01) 60px, rgba(0, 245, 147, 0.01) 61px);
        pointer-events: none;
        z-index: 0;
    }

    .welcome-header {
        position: relative;
        z-index: 1;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .welcome-header h1 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 2.2rem;
        letter-spacing: 2px;
        color: var(--text-primary);
        margin: 0;
    }

    .welcome-header h1 span {
        color: var(--pitch-green);
    }

    .btn-reservar-rapido {
        background: var(--pitch-green);
        color: #0b0f1c;
        border: none;
        padding: 10px 22px;
        border-radius: var(--radius-sm);
        font-weight: 700;
        font-family: 'Outfit', sans-serif;
        text-decoration: none;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: transform 0.2s, box-shadow 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-reservar-rapido:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px var(--pitch-green-glow);
        color: #0b0f1c;
    }

    .cliente-stats {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 14px;
        margin-bottom: 32px;
    }

    .cliente-stat {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius);
        padding: 20px;
        text-align: center;
        backdrop-filter: blur(12px);
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), border-color 0.3s;
        position: relative;
        overflow: hidden;
    }

    .cliente-stat::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        opacity: 0.2;
    }

    .cliente-stat:nth-child(1)::before { background: var(--pitch-green); }
    .cliente-stat:nth-child(2)::before { background: var(--pitch-green); }
    .cliente-stat:nth-child(3)::before { background: var(--amber); }

    .cliente-stat:hover {
        transform: translateY(-3px);
    }

    .cliente-stat i {
        font-size: 28px;
        margin-bottom: 6px;
    }

    .cliente-stat:nth-child(1) i { color: var(--pitch-green); }
    .cliente-stat:nth-child(2) i { color: var(--pitch-green); }
    .cliente-stat:nth-child(3) i { color: var(--amber); }

    .cliente-stat h3 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.8rem;
        letter-spacing: 1px;
        margin: 0;
        line-height: 1;
        color: var(--text-primary);
    }

    .cliente-stat p {
        margin: 4px 0 0;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-secondary);
    }

    .section-title {
        position: relative;
        z-index: 1;
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.3rem;
        letter-spacing: 1px;
        color: var(--text-primary);
        margin: 28px 0 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-title i {
        color: var(--pitch-green);
    }

    .match-card {
        position: relative;
        z-index: 1;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius);
        padding: 20px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 20px;
        backdrop-filter: blur(12px);
        transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1), border-color 0.25s, box-shadow 0.25s;
    }

    .match-card:hover {
        transform: translateY(-3px);
        border-color: rgba(255, 255, 255, 0.08);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
    }

    .match-date {
        text-align: center;
        min-width: 60px;
    }

    .match-date .day {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.8rem;
        letter-spacing: 1px;
        color: var(--pitch-green);
        display: block;
        line-height: 1;
    }

    .match-date .month {
        font-size: 0.75rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .match-info {
        flex: 1;
    }

    .match-info .time {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.95rem;
    }

    .match-info .status {
        font-size: 0.75rem;
        display: inline-block;
        padding: 3px 12px;
        border-radius: 12px;
        font-weight: 600;
        margin-top: 4px;
    }

    .match-info .status.aprobada {
        background: rgba(0, 245, 147, 0.12);
        color: var(--pitch-green);
    }

    .match-info .status.pendiente {
        background: rgba(255, 180, 0, 0.12);
        color: var(--amber);
    }

    .match-info .status.rechazada {
        background: rgba(255, 68, 102, 0.12);
        color: var(--danger);
    }

    .match-price {
        font-weight: 700;
        color: var(--text-primary);
        font-size: 1.05rem;
    }

    .match-card form button {
        background: none;
        border: none;
        color: var(--danger);
        font-size: 1.3rem;
        cursor: pointer;
        transition: opacity 0.2s, transform 0.2s;
    }

    .match-card form button:hover {
        opacity: 0.7;
        transform: scale(1.1);
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

    .empty-state a {
        color: var(--pitch-green);
        text-decoration: none;
        font-weight: 600;
    }

    .empty-state a:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .home-cliente {
            padding: 16px;
        }
        .welcome-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .welcome-header h1 {
            font-size: 1.6rem;
        }
        .match-card {
            flex-direction: column;
            text-align: center;
        }
        .cliente-stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endpush

@section('main')
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Operación Exitosa',
        text: "{{ session('success') }}",
        confirmButtonText: 'Aceptar',
        background: '#12182f',
        color: '#f0f4ff',
        iconColor: '#00f593',
        confirmButtonColor: '#00f593'
    });
</script>
@endif

<div class="home-cliente">
    <div class="welcome-header">
        <h1>Bienvenido, <span>{{ auth()->user()->name }}</span></h1>
        <a href="{{ route('horarios.index') }}" class="btn-reservar-rapido">
            <i class='bx bx-plus-circle'></i> Nueva reserva
        </a>
    </div>

    <div class="cliente-stats">
        <div class="cliente-stat">
            <i class='bx bx-calendar-check'></i>
            <h3>{{ $totalReservas }}</h3>
            <p>Total reservas</p>
        </div>
        <div class="cliente-stat">
            <i class='bx bx-check-circle'></i>
            <h3>{{ $reservasAprobadas }}</h3>
            <p>Aprobadas</p>
        </div>
        <div class="cliente-stat">
            <i class='bx bx-time'></i>
            <h3>{{ $reservasPendientes }}</h3>
            <p>Pendientes</p>
        </div>
    </div>

    @if($proximosPartidos->isNotEmpty())
    <div class="section-title">
        <i class='bx bx-football'></i> Próximos partidos
    </div>
    @foreach($proximosPartidos as $reserva)
    <div class="match-card">
        <div class="match-date">
            <span class="day">{{ \Carbon\Carbon::parse($reserva->horario->fecha)->format('d') }}</span>
            <span class="month">{{ \Carbon\Carbon::parse($reserva->horario->fecha)->format('M') }}</span>
        </div>
        <div class="match-info">
            <div class="time">
                <i class='bx bx-time'></i>
                {{ \Carbon\Carbon::parse($reserva->horario->hora)->format('H:i') }} hrs
            </div>
            <span class="status {{ strtolower($reserva->estado) }}">{{ $reserva->estado }}</span>
        </div>
        <div class="match-price">
            ${{ number_format($reserva->precio->valor, 0, ',', '.') }}
        </div>
    </div>
    @endforeach
    @endif

    <div class="section-title" style="margin-top: 32px;">
        <i class='bx bx-list-ul'></i> Mis reservas recientes
    </div>

    @if($reservasActivas->isEmpty())
    <div class="empty-state">
        <i class='bx bx-calendar-x'></i>
        <p>No tienes reservas activas. <br>
            <a href="{{ route('horarios.index') }}">Reserva ahora</a>
        </p>
    </div>
    @else
    @foreach($reservasActivas as $reserva)
    <div class="match-card">
        <div class="match-date">
            <span class="day">{{ \Carbon\Carbon::parse($reserva->horario->fecha)->format('d') }}</span>
            <span class="month">{{ \Carbon\Carbon::parse($reserva->horario->fecha)->format('M') }}</span>
        </div>
        <div class="match-info">
            <div class="time">
                <i class='bx bx-time'></i>
                {{ \Carbon\Carbon::parse($reserva->horario->hora)->format('H:i') }} hrs
            </div>
            <span class="status {{ strtolower($reserva->estado) }}">{{ $reserva->estado }}</span>
        </div>
        <div class="match-price">
            ${{ number_format($reserva->precio->valor, 0, ',', '.') }}
        </div>
        @if($reserva->estado == 'Pendiente')
        <form action="{{ route('reservas.cancelar', $reserva->id) }}" method="POST" onsubmit="event.preventDefault(); confirmCancel(this)">
            @csrf
            <button type="submit" title="Cancelar reserva">
                <i class='bx bx-x-circle'></i>
            </button>
        </form>
        @endif
    </div>
    @endforeach
    @endif
</div>

<script>
function confirmCancel(form) {
    Swal.fire({
        title: '¿Cancelar reserva?',
        text: 'Esta acción liberará el horario.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ff4466',
        cancelButtonColor: 'rgba(255,255,255,0.08)',
        confirmButtonText: 'Sí, cancelar',
        cancelButtonText: 'Volver',
        background: '#12182f',
        color: '#f0f4ff',
        iconColor: '#ffb400'
    }).then((result) => {
        if (result.isConfirmed) form.submit();
    });
}
</script>
@endsection
