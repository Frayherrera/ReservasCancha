@extends('layouts.app')

@push('styles')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --pitch-green: #00f593;
            --pitch-green-dim: rgba(0, 245, 147, 0.08);
            --pitch-green-glow: rgba(0, 245, 147, 0.25);
            --amber: #ffb400;
            --stadium-bg: #0b0f1c;
            --card-bg: rgba(12, 16, 30, 0.88);
            --card-border: rgba(255, 255, 255, 0.05);
            --text-primary: #f0f4ff;
            --text-secondary: rgba(240, 244, 255, 0.55);
            --text-muted: rgba(240, 244, 255, 0.3);
            --danger: #ff4466;
            --radius: 16px;
            --radius-sm: 10px;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--stadium-bg) !important;
        }

        .dashboard {
            padding: 28px 32px;
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
        }

        .dashboard::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                repeating-linear-gradient(0deg, transparent, transparent 60px, rgba(0, 245, 147, 0.01) 60px, rgba(0, 245, 147, 0.01) 61px),
                repeating-linear-gradient(90deg, transparent, transparent 60px, rgba(0, 245, 147, 0.01) 60px, rgba(0, 245, 147, 0.01) 61px);
            pointer-events: none;
            z-index: 0;
        }

        .dashboard-header {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .dashboard-header h1 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2.6rem;
            letter-spacing: 2px;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .dashboard-header h1 i {
            color: var(--pitch-green);
            font-size: 2rem;
        }

        .dashboard-header .header-accent {
            display: block;
            width: 40px;
            height: 3px;
            background: var(--pitch-green);
            border-radius: 4px;
            box-shadow: 0 0 16px var(--pitch-green-glow);
            margin-top: 6px;
        }

        .dashboard-date {
            font-size: 0.85rem;
            color: var(--text-secondary);
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            padding: 8px 16px;
            border-radius: 100px;
        }

        /* === STATS GRID === */
        .stats-grid {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: var(--radius);
            padding: 20px 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            backdrop-filter: blur(12px);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1),
                        border-color 0.3s,
                        box-shadow 0.3s;
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
            opacity: 0.15;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            border-color: rgba(0, 245, 147, 0.12);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
            position: relative;
        }

        .stat-icon.blue {
            background: rgba(79, 172, 254, 0.12);
            color: #4facfe;
        }
        .stat-icon.green {
            background: rgba(0, 245, 147, 0.12);
            color: var(--pitch-green);
        }
        .stat-icon.orange {
            background: rgba(255, 180, 0, 0.12);
            color: var(--amber);
        }
        .stat-icon.purple {
            background: rgba(161, 140, 209, 0.12);
            color: #a18cd1;
        }
        .stat-icon.red {
            background: rgba(255, 68, 102, 0.12);
            color: var(--danger);
        }
        .stat-icon.teal {
            background: rgba(0, 207, 180, 0.12);
            color: #00cfb4;
        }

        .stat-info h3 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.8rem;
            letter-spacing: 1px;
            margin: 0;
            color: var(--text-primary);
            line-height: 1;
        }

        .stat-info p {
            margin: 4px 0 0;
            color: var(--text-secondary);
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* === ROW SPLIT === */
        .row-split {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 28px;
        }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: var(--radius);
            padding: 24px;
            backdrop-filter: blur(12px);
        }

        .card h2 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.2rem;
            letter-spacing: 1px;
            color: var(--text-primary);
            margin: 0 0 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card h2 i {
            color: var(--pitch-green);
        }

        .chart-container {
            position: relative;
            height: 200px;
        }

        /* === RANK LIST === */
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
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        }

        .rank-list li:last-child {
            border-bottom: none;
        }

        .rank-number {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-muted);
            flex-shrink: 0;
        }

        .rank-list li:first-child .rank-number {
            background: var(--pitch-green);
            color: #0b0f1c;
        }
        .rank-list li:nth-child(2) .rank-number {
            background: rgba(0, 245, 147, 0.5);
            color: #0b0f1c;
        }
        .rank-list li:nth-child(3) .rank-number {
            background: rgba(0, 245, 147, 0.25);
            color: var(--text-primary);
        }

        .rank-name {
            flex: 1;
            font-weight: 500;
            color: var(--text-primary);
            font-size: 0.9rem;
        }

        .rank-count {
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        /* === HORARIO BARS === */
        .card-horarios {
            position: relative;
            z-index: 1;
            margin-bottom: 28px;
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
            font-size: 0.85rem;
            color: var(--text-secondary);
            flex-shrink: 0;
        }

        .horario-bar-track {
            flex: 1;
            height: 26px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 13px;
            overflow: hidden;
        }

        .horario-bar-fill {
            height: 100%;
            border-radius: 13px;
            background: linear-gradient(90deg, var(--pitch-green), #00c97a);
            display: flex;
            align-items: center;
            padding-left: 12px;
            font-size: 0.75rem;
            font-weight: 700;
            color: #0b0f1c;
            min-width: fit-content;
            transition: width 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15);
        }

        /* === TABLE === */
        .table-dashboard {
            width: 100%;
            border-collapse: collapse;
        }

        .table-dashboard th {
            text-align: left;
            padding: 12px 14px;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            font-weight: 600;
        }

        .table-dashboard td {
            padding: 12px 14px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.03);
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .table-dashboard tr:last-child td {
            border-bottom: none;
        }

        .table-dashboard tr:hover td {
            background: rgba(255, 255, 255, 0.02);
        }

        .badge-estado {
            padding: 3px 12px;
            border-radius: 100px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-block;
        }

        .badge-aprobada {
            background: rgba(0, 245, 147, 0.1);
            color: var(--pitch-green);
            border: 1px solid rgba(0, 245, 147, 0.12);
        }

        .badge-pendiente {
            background: rgba(255, 180, 0, 0.1);
            color: var(--amber);
            border: 1px solid rgba(255, 180, 0, 0.12);
        }

        .badge-rechazada {
            background: rgba(255, 68, 102, 0.1);
            color: var(--danger);
            border: 1px solid rgba(255, 68, 102, 0.12);
        }

        .card p {
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .dashboard {
                padding: 16px;
            }

            .dashboard-header h1 {
                font-size: 1.8rem;
            }

            .row-split {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 12px;
            }

            .stat-card {
                padding: 16px;
            }

            .stat-info h3 {
                font-size: 1.4rem;
            }

            .card {
                padding: 16px;
            }

            .table-scroll {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }

            .table-scroll table {
                min-width: 600px;
            }
        }

        @media (max-width: 400px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .dashboard-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endpush

@section('main')
<div class="dashboard">
    <div class="dashboard-header">
        <div>
            <h1>
                <i class='bx bxs-dashboard'></i>
                Dashboard
            </h1>
            <span class="header-accent"></span>
        </div>
        <span class="dashboard-date">
            <i class='bx bx-calendar' style="margin-right: 4px;"></i>
            {{ now()->format('d/m/Y') }}
        </span>
    </div>

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
            <p>No hay datos disponibles</p>
            @endforelse
        </div>
    </div>

    <div class="card">
        <h2><i class='bx bx-receipt'></i> Últimas reservas</h2>
        @if($ultimasReservas->isEmpty())
        <p>No hay reservas registradas</p>
        @else
        <div class="table-scroll">
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
                    <td style="font-weight: 600; color: var(--text-primary);">#{{ $reserva->id }}</td>
                    <td>{{ $reserva->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($reserva->horario->fecha)->format('d/m') }}
                        {{ \Carbon\Carbon::parse($reserva->horario->hora)->format('H:i') }}</td>
                    <td style="font-weight: 600;">${{ number_format($reserva->precio->valor, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge-estado badge-{{ strtolower($reserva->estado) }}">
                            {{ $reserva->estado }}
                        </span>
                    </td>
                    <td>{{ $reserva->created_at->format('d/m H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        @endif
    </div>
</div>

@push('scripts')
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
                    borderColor: '#00f593',
                    backgroundColor: 'rgba(0, 245, 147, 0.06)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 3,
                    pointBackgroundColor: '#00f593',
                    pointBorderColor: 'rgba(0, 245, 147, 0.3)',
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: '#00f593',
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
                        grid: { display: false, color: 'rgba(255,255,255,0.03)' },
                        ticks: {
                            font: { size: 10, family: 'Outfit' },
                            color: 'rgba(240,244,255,0.4)'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: { size: 10, family: 'Outfit' },
                            color: 'rgba(240,244,255,0.4)'
                        },
                        grid: {
                            color: 'rgba(255,255,255,0.04)'
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection
