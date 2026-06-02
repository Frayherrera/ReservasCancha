@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ReservaFutbol - Mis Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    </script>
    <style>
        .home-cliente {
            padding: 24px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .home-cliente .welcome-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .home-cliente .welcome-header h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1a1a2e;
        }

        .home-cliente .welcome-header h1 span {
            color: #4facfe;
        }

        .btn-reservar-rapido {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: white;
            border: none;
            padding: 10px 24px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: transform 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-reservar-rapido:hover {
            transform: translateY(-2px);
            color: white;
        }

        .cliente-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 16px;
            margin-bottom: 32px;
        }

        .cliente-stat {
            background: white;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            text-align: center;
            transition: transform 0.2s;
        }

        .cliente-stat:hover {
            transform: translateY(-2px);
        }

        .cliente-stat i {
            font-size: 28px;
            color: #4facfe;
            margin-bottom: 8px;
        }

        .cliente-stat h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            color: #1a1a2e;
        }

        .cliente-stat p {
            margin: 2px 0 0;
            color: #6b7280;
            font-size: 0.85rem;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1a1a2e;
            margin: 24px 0 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title i {
            color: #4facfe;
        }

        .match-card {
            background: white;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 12px;
            transition: transform 0.2s;
        }

        .match-card:hover {
            transform: translateY(-2px);
        }

        .match-date {
            text-align: center;
            min-width: 60px;
        }

        .match-date .day {
            font-size: 1.5rem;
            font-weight: 700;
            color: #4facfe;
            display: block;
            line-height: 1;
        }

        .match-date .month {
            font-size: 0.8rem;
            color: #6b7280;
            text-transform: uppercase;
        }

        .match-info {
            flex: 1;
        }

        .match-info .time {
            font-weight: 600;
            color: #1a1a2e;
        }

        .match-info .status {
            font-size: 0.8rem;
            display: inline-block;
            padding: 2px 10px;
            border-radius: 12px;
            font-weight: 500;
        }

        .match-info .status.aprobada {
            background: #d4edda;
            color: #155724;
        }

        .match-info .status.pendiente {
            background: #fff3cd;
            color: #856404;
        }

        .match-price {
            font-weight: 700;
            color: #1a1a2e;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            background: white;
            border-radius: 14px;
            color: #6b7280;
        }

        .empty-state i {
            font-size: 48px;
            color: #d1d5db;
            margin-bottom: 12px;
        }

        @media (max-width: 768px) {
            .home-cliente {
                padding: 16px;
            }
            .home-cliente .welcome-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
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
</head>

@section('main')
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Operación Exitosa',
        text: "{{ session('success') }}",
        confirmButtonText: 'Aceptar'
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
            <i class='bx bx-check-circle' style="color: #38ef7d;"></i>
            <h3>{{ $reservasAprobadas }}</h3>
            <p>Aprobadas</p>
        </div>
        <div class="cliente-stat">
            <i class='bx bx-time' style="color: #fbbf24;"></i>
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
            <a href="{{ route('horarios.index') }}" style="color: #4facfe;">Reserva ahora</a>
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
            <button type="submit" style="background:none; border:none; color:#ef4444; font-size:1.3rem; cursor:pointer;" title="Cancelar reserva">
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
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, cancelar',
            cancelButtonText: 'Volver'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    }
</script>
@endsection
