@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes Financieros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js">
    </script>
    <style>
        .finances-page {
            padding: 16px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .finances-page h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 8px;
        }

        .finances-page .subtitle {
            color: #6b7280;
            margin-bottom: 24px;
        }

        .filter-row {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
            background: white;
            padding: 16px 20px;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            margin-bottom: 24px;
        }

        .filter-row select {
            padding: 10px 14px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 0.9rem;
            background: white;
        }

        .filter-row .btn-action {
            background: #003770;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
        }

        .filter-row .btn-outline-action {
            background: transparent;
            border: 2px solid #003770;
            color: #003770;
            padding: 8px 18px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .filter-row .btn-outline-action:hover {
            background: #003770;
            color: white;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: white;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .stat-card .icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: white;
            flex-shrink: 0;
        }

        .stat-card .icon.green {
            background: linear-gradient(135deg, #11998e, #38ef7d);
        }
        .stat-card .icon.blue {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
        }
        .stat-card .icon.orange {
            background: linear-gradient(135deg, #fa709a, #fee140);
        }
        .stat-card .icon.red {
            background: linear-gradient(135deg, #eb3349, #f45c43);
        }

        .stat-card .info h3 {
            font-size: 1.4rem;
            font-weight: 700;
            margin: 0;
            color: #1a1a2e;
        }

        .stat-card .info p {
            margin: 2px 0 0;
            font-size: 0.8rem;
            color: #6b7280;
        }

        .chart-wrap {
            background: white;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            margin-bottom: 24px;
        }

        .chart-wrap h2 {
            font-size: 1.05rem;
            font-weight: 600;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .chart-wrap .chart-container {
            position: relative;
            height: 250px;
        }

        .table-wrap {
            background: white;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .table-wrap h2 {
            font-size: 1.05rem;
            font-weight: 600;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table-finances {
            width: 100%;
            border-collapse: collapse;
        }

        .table-finances th {
            text-align: left;
            padding: 10px 12px;
            font-size: 0.75rem;
            text-transform: uppercase;
            color: #6b7280;
            border-bottom: 2px solid #f0f0f0;
            letter-spacing: 0.5px;
        }

        .table-finances td {
            padding: 10px 12px;
            border-bottom: 1px solid #f5f5f5;
            font-size: 0.9rem;
        }

        .badge-estado {
            padding: 3px 10px;
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
    </style>
</head>

@section('main')
<div class="finances-page">
    <h1><i class='bx bx-line-chart'></i> Reportes Financieros</h1>
    <p class="subtitle">Gestión de ingresos y exportación de reportes</p>

    <form class="filter-row" method="GET" action="{{ route('admin.finances.index') }}">
        <label style="font-weight:600; font-size:0.9rem;">Período:</label>
        <select name="year">
            @foreach($yearsDisponibles as $y)
            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endforeach
        </select>
        <select name="month">
            @foreach(range(1, 12) as $m)
            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ \Carbon\Carbon::create()->month($m)->locale('es')->monthName }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-action">Consultar</button>
        <a href="{{ route('admin.finances.pdf', ['year' => $year, 'month' => $month]) }}" class="btn-outline-action">
            <i class='bx bxs-file-pdf'></i> PDF
        </a>
        <a href="{{ route('admin.finances.csv', ['year' => $year, 'month' => $month]) }}" class="btn-outline-action">
            <i class='bx bxs-file-export'></i> CSV
        </a>
    </form>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="icon green"><i class='bx bx-dollar-circle'></i></div>
            <div class="info">
                <h3>${{ number_format($ingresosMensuales, 0, ',', '.') }}</h3>
                <p>Ingresos del mes</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon blue"><i class='bx bx-calendar-check'></i></div>
            <div class="info">
                <h3>{{ $totalReservasMes }}</h3>
                <p>Total reservas del mes</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon orange"><i class='bx bx-check-circle'></i></div>
            <div class="info">
                <h3>{{ $reservasPagadas }}</h3>
                <p>Pagadas (Aprobadas)</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon red"><i class='bx bx-time'></i></div>
            <div class="info">
                <h3>{{ $reservasPendientes }}</h3>
                <p>Pendientes de pago</p>
            </div>
        </div>
    </div>

    <div class="chart-wrap">
        <h2><i class='bx bx-bar-chart-alt-2' style="color:#4facfe;"></i> Ingresos mensuales {{ $year }}</h2>
        <div class="chart-container">
            <canvas id="ingresosChart"></canvas>
        </div>
    </div>

    <div class="table-wrap">
        <h2><i class='bx bx-receipt' style="color:#4facfe;"></i> Últimos pagos registrados</h2>
        <table class="table-finances">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Monto</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ultimosPagos as $r)
                <tr>
                    <td>#{{ $r->id }}</td>
                    <td>{{ $r->user->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->horario->fecha)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($r->horario->hora)->format('H:i') }}</td>
                    <td>${{ number_format($r->precio->valor, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge-estado badge-{{ strtolower($r->estado) }}">{{ $r->estado }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; color:#9ca3af; padding:24px;">No hay registros</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('ingresosChart').getContext('2d');
        const months = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        const data = {!! json_encode($ingresosAnuales) !!};

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Ingresos',
                    data: data,
                    backgroundColor: 'rgba(79, 172, 254, 0.7)',
                    borderColor: '#4facfe',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString('es-CL');
                            }
                        },
                        grid: { color: '#f0f0f0' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endsection
