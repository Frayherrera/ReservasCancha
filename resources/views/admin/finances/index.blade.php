@extends('layouts.app')

@push('styles')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reportes Financieros</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
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

    .finances-page {
        padding: 28px 32px;
        max-width: 1300px;
        margin: 0 auto;
        position: relative;
    }

    .finances-page::before {
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

    .filter-row {
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

    .filter-row label {
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--text-secondary);
    }

    .filter-row select {
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

    .filter-row select:focus {
        border-color: var(--pitch-green);
        box-shadow: 0 0 0 3px rgba(0, 245, 147, 0.06);
    }

    .filter-row select option {
        background: #12182f;
        color: var(--text-primary);
    }

    .btn-action {
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
        text-decoration: none;
    }

    .btn-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 16px var(--pitch-green-glow);
    }

    .btn-outline-action {
        background: transparent;
        border: 1px solid rgba(0, 245, 147, 0.2);
        color: var(--pitch-green);
        padding: 10px 20px;
        border-radius: var(--radius-sm);
        font-weight: 600;
        font-size: 0.8rem;
        font-family: 'Outfit', sans-serif;
        cursor: pointer;
        text-decoration: none;
        transition: background 0.2s, border-color 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-outline-action:hover {
        background: rgba(0, 245, 147, 0.04);
        border-color: rgba(0, 245, 147, 0.4);
    }

    .stats-grid {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius);
        padding: 20px;
        backdrop-filter: blur(12px);
        display: flex;
        align-items: center;
        gap: 16px;
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
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
    .stat-card:nth-child(3)::before { background: var(--pitch-green); }
    .stat-card:nth-child(4)::before { background: var(--amber); }

    .stat-card:hover {
        transform: translateY(-3px);
    }

    .stat-card .icon {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }

    .stat-card:nth-child(1) .icon { background: rgba(0, 245, 147, 0.1); color: var(--pitch-green); }
    .stat-card:nth-child(2) .icon { background: rgba(0, 245, 147, 0.1); color: var(--pitch-green); }
    .stat-card:nth-child(3) .icon { background: rgba(0, 245, 147, 0.1); color: var(--pitch-green); }
    .stat-card:nth-child(4) .icon { background: rgba(255, 180, 0, 0.1); color: var(--amber); }

    .stat-card .info h3 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.5rem;
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

    .chart-wrap, .table-wrap {
        position: relative;
        z-index: 1;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius);
        padding: 24px;
        backdrop-filter: blur(12px);
        margin-bottom: 24px;
    }

    .chart-wrap h2, .table-wrap h2 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.2rem;
        letter-spacing: 1px;
        color: var(--text-primary);
        margin: 0 0 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .chart-wrap h2 i, .table-wrap h2 i {
        color: var(--pitch-green);
    }

    .chart-container {
        position: relative;
        height: 260px;
    }

    .table-finances {
        width: 100%;
        border-collapse: collapse;
    }

    .table-finances th {
        text-align: left;
        padding: 10px 12px;
        font-size: 0.72rem;
        text-transform: uppercase;
        color: var(--text-secondary);
        border-bottom: 2px solid rgba(255, 255, 255, 0.04);
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .table-finances td {
        padding: 10px 12px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        font-size: 0.88rem;
        color: var(--text-primary);
    }

    .table-finances tr:last-child td {
        border-bottom: none;
    }

    .table-finances tr:hover td {
        background: rgba(255, 255, 255, 0.02);
    }

    .badge-estado {
        padding: 3px 12px;
        border-radius: 12px;
        font-size: 0.72rem;
        font-weight: 600;
        display: inline-block;
    }

    .badge-aprobada {
        background: rgba(0, 245, 147, 0.12);
        color: var(--pitch-green);
    }

    .badge-pendiente {
        background: rgba(255, 180, 0, 0.12);
        color: var(--amber);
    }

    .badge-rechazada {
        background: rgba(255, 68, 102, 0.12);
        color: var(--danger);
    }

    @media (max-width: 768px) {
        .finances-page {
            padding: 16px;
        }
        .page-header h1 {
            font-size: 1.8rem;
        }
        .filter-row {
            flex-direction: column;
            align-items: stretch;
        }
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .table-wrap {
            overflow-x: auto;
        }
    }
</style>
@endpush

@section('main')
<div class="finances-page">
    <div class="page-header">
        <div>
            <h1>
                <i class='bx bx-line-chart'></i>
                Reportes Financieros
            </h1>
            <p class="subtitle">Gestión de ingresos y exportación de reportes</p>
            <span class="header-accent"></span>
        </div>
    </div>

    <form class="filter-row" method="GET" action="{{ route('admin.finances.index') }}">
        <label>Período:</label>
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
            <div class="icon"><i class='bx bx-dollar-circle'></i></div>
            <div class="info">
                <h3>${{ number_format($ingresosMensuales, 0, ',', '.') }}</h3>
                <p>Ingresos del mes</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon"><i class='bx bx-calendar-check'></i></div>
            <div class="info">
                <h3>{{ $totalReservasMes }}</h3>
                <p>Total reservas del mes</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon"><i class='bx bx-check-circle'></i></div>
            <div class="info">
                <h3>{{ $reservasPagadas }}</h3>
                <p>Pagadas (Aprobadas)</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="icon"><i class='bx bx-time'></i></div>
            <div class="info">
                <h3>{{ $reservasPendientes }}</h3>
                <p>Pendientes de pago</p>
            </div>
        </div>
    </div>

    <div class="chart-wrap">
        <h2><i class='bx bx-bar-chart-alt-2'></i> Ingresos mensuales {{ $year }}</h2>
        <div class="chart-container">
            <canvas id="ingresosChart"></canvas>
        </div>
    </div>

    <div class="table-wrap">
        <h2><i class='bx bx-receipt'></i> Últimos pagos registrados</h2>
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
                    <td><strong>#{{ $r->id }}</strong></td>
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
                    <td colspan="6" style="text-align:center; color:var(--text-muted); padding:24px;">No hay registros</td>
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
                backgroundColor: 'rgba(0, 245, 147, 0.5)',
                borderColor: '#00f593',
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
                        color: 'rgba(240, 244, 255, 0.5)',
                        callback: function(value) {
                            return '$' + value.toLocaleString('es-CL');
                        }
                    },
                    grid: { color: 'rgba(255, 255, 255, 0.04)' }
                },
                x: {
                    ticks: { color: 'rgba(240, 244, 255, 0.5)' },
                    grid: { display: false }
                }
            }
        }
    });
});
</script>
@endsection
