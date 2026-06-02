@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js">
    </script>
    <style>
        .dashboard {
            padding: 24px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .dashboard h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            display: flex;
            align-items: center;
            gap: 16px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            color: white;
            flex-shrink: 0;
        }

        .stat-icon.blue {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
        }
        .stat-icon.green {
            background: linear-gradient(135deg, #11998e, #38ef7d);
        }
        .stat-icon.orange {
            background: linear-gradient(135deg, #fa709a, #fee140);
        }
        .stat-icon.purple {
            background: linear-gradient(135deg, #a18cd1, #fbc2eb);
        }
        .stat-icon.red {
            background: linear-gradient(135deg, #eb3349, #f45c43);
        }
        .stat-icon.teal {
            background: linear-gradient(135deg, #2af598, #009efd);
        }

        .stat-info h3 {
            font-size: 1.6rem;
            font-weight: 700;
            margin: 0;
            color: #1a1a2e;
        }

        .stat-info p {
            margin: 2px 0 0;
            color: #6b7280;
            font-size: 0.85rem;
        }

        .row-split {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            margin-bottom: 32px;
        }

        .card {
            background: white;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }

        .card h2 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1a1a2e;
            margin: 0 0 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card h2 i {
            color: #4facfe;
        }

        .table-dashboard {
            width: 100%;
            border-collapse: collapse;
        }

        .table-dashboard th {
            text-align: left;
            padding: 10px 12px;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6b7280;
            border-bottom: 2px solid #f0f0f0;
        }

        .table-dashboard td {
            padding: 10px 12px;
            border-bottom: 1px solid #f5f5f5;
            font-size: 0.9rem;
        }

        .badge-estado {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-aprobada {
            background: #d4edda;
            color: #155724;
        }

        .badge-pendiente {
            background: #fff3cd;
            color: #856404;
        }

        .badge-rechazada {
            background: #f8d7da;
            color: #721c24;
        }

        .rank-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .rank-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #f5f5f5;
        }

        .rank-list li:last-child {
            border-bottom: none;
        }

        .rank-number {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            color: #6b7280;
            flex-shrink: 0;
        }

        .rank-list li:first-child .rank-number {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            color: white;
        }

        .rank-name {
            flex: 1;
            font-weight: 500;
        }

        .rank-count {
            font-size: 0.85rem;
            color: #6b7280;
        }

        .card-horarios {
            grid-column: 1 / -1;
        }

        .horario-bars {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .horario-bar-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .horario-bar-item .hora-label {
            width: 60px;
            font-weight: 600;
            font-size: 0.9rem;
            color: #374151;
            flex-shrink: 0;
        }

        .horario-bar-track {
            flex: 1;
            height: 28px;
            background: #f0f0f0;
            border-radius: 14px;
            overflow: hidden;
        }

        .horario-bar-fill {
            height: 100%;
            border-radius: 14px;
            background: linear-gradient(90deg, #4facfe, #00f2fe);
            display: flex;
            align-items: center;
            padding-left: 12px;
            font-size: 0.8rem;
            font-weight: 600;
            color: white;
            min-width: fit-content;
            transition: width 0.6s ease;
        }

        .chart-container {
            position: relative;
            height: 200px;
        }

        @media (max-width: 768px) {
            .row-split {
                grid-template-columns: 1fr;
            }
            .dashboard {
                padding: 16px;
            }
            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
                gap: 12px;
            }
            .stat-card {
                padding: 16px;
            }
            .stat-info h3 {
                font-size: 1.2rem;
            }
        }
    </style>
</head>

@section('main')
<div class="dashboard">
    <h1>
        <i class='bx bxs-dashboard'></i>
        Dashboard Administrativo
    </h1>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue"><i class='bx bx-calendar-check'></i></div>
            <div class="stat-info">
                <h3>{{ $reservasDelDia }}</h3>
                <p>Reservas del día</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green"><i class='bx bx-dollar-circle'></i></div>
            <div class="stat-info">
                <h3>${{ number_format($gananciasSemanales, 0, ',', '.') }}</h3>
                <p>Ganancias semanales</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple"><i class='bx bx-user'></i></div>
            <div class="stat-info">
                <h3>{{ $usuariosRegistrados }}</h3>
                <p>Usuarios registrados</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange"><i class='bx bx-list-check'></i></div>
            <div class="stat-info">
                <h3>{{ $totalReservas }}</h3>
                <p>Total reservas</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon teal"><i class='bx bx-check-circle'></i></div>
            <div class="stat-info">
                <h3>{{ $reservasAprobadas }}</h3>
                <p>Aprobadas</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red"><i class='bx bx-time'></i></div>
            <div class="stat-info">
                <h3>{{ $reservasPendientes }}</h3>
                <p>Pendientes</p>
            </div>
        </div>
    </div>

    <div class="row-split">
        <div class="card">
            <h2><i class='bx bx-line-chart'></i> Reservas (últimos 30 días)</h2>
            <div class="chart-container">
                <canvas id="reservasChart"></canvas>
            </div>
        </div>
        <div class="card">
            <h2><i class='bx bx-trophy'></i> Top 5 usuarios</h2>
            <ol class="rank-list">
                @foreach($topUsuarios as $user)
                <li>
                    <span class="rank-number">{{ $loop->iteration }}</span>
                    <span class="rank-name">{{ $user->name }}</span>
                    <span class="rank-count">{{ $user->reservas_count }} reservas</span>
                </li>
                @endforeach
            </ol>
        </div>
    </div>

    <div class="card card-horarios">
        <h2><i class='bx bx-time-five'></i> Horarios más solicitados</h2>
        <div class="horario-bars">
            @php $maxTotal = $horariosMasSolicitados->max('total') ?: 1; @endphp
            @forelse($horariosMasSolicitados as $horario)
            <div class="horario-bar-item">
                <span class="hora-label">{{ \Carbon\Carbon::parse($horario->hora)->format('H:i') }}</span>
                <div class="horario-bar-track">
                    <div class="horario-bar-fill" style="width: {{ ($horario->total / $maxTotal) * 100 }}%;">
                        {{ $horario->total }} 
                    </div>
                </div>
            </div>
            @empty
            <p style="color: #6b7280;">No hay datos disponibles</p>
            @endforelse
        </div>
    </div>

    <div class="card" style="margin-top: 24px;">
        <h2><i class='bx bx-receipt'></i> Últimas reservas</h2>
        @if($ultimasReservas->isEmpty())
        <p style="color: #6b7280;">No hay reservas registradas</p>
        @else
        <table class="table-dashboard">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Horario</th>
                    <th>Monto</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ultimasReservas as $reserva)
                <tr>
                    <td>#{{ $reserva->id }}</td>
                    <td>{{ $reserva->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($reserva->horario->fecha)->format('d/m') }}
                        {{ \Carbon\Carbon::parse($reserva->horario->hora)->format('H:i') }}</td>
                    <td>${{ number_format($reserva->precio->valor, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge-estado badge-{{ strtolower($reserva->estado) }}">
                            {{ $reserva->estado }}
                        </span>
                    </td>
                    <td>{{ $reserva->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('reservasChart').getContext('2d');

        const labels = {!! json_encode($reservasPorDia->pluck('fecha')->map(function($d) {
            return \Carbon\Carbon::parse($d)->format('d/m');
        })) !!};

        const data = {!! json_encode($reservasPorDia->pluck('total')) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Reservas',
                    data: data,
                    borderColor: '#4facfe',
                    backgroundColor: 'rgba(79, 172, 254, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 3,
                    pointBackgroundColor: '#4facfe',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10 } }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: { size: 10 }
                        },
                        grid: { color: '#f0f0f0' }
                    }
                }
            }
        });
    });
</script>
@endsection
