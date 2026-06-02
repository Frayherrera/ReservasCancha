<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte Financiero {{ $year }}-{{ $month }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
        }
        h1 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 4px;
        }
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 24px;
            font-size: 13px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background: #003770;
            color: white;
            padding: 8px 10px;
            text-align: left;
            font-size: 11px;
        }
        td {
            padding: 7px 10px;
            border-bottom: 1px solid #e0e0e0;
        }
        tr:nth-child(even) td {
            background: #f9f9f9;
        }
        .total-row {
            font-weight: bold;
            font-size: 14px;
            border-top: 2px solid #333;
        }
        .footer {
            text-align: center;
            color: #999;
            font-size: 10px;
            margin-top: 32px;
        }
        .badge {
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 10px;
        }
        .badge-aprobada {
            background: #d4edda;
        }
        .badge-pendiente {
            background: #fff3cd;
        }
        .badge-rechazada {
            background: #f8d7da;
        }
    </style>
</head>

<body>
    <h1>Reporte Financiero</h1>
    <p class="subtitle">{{ \Carbon\Carbon::create()->month($month)->locale('es')->monthName }} {{ $year }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Estado</th>
                <th>Monto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reservas as $r)
            <tr>
                <td>#{{ $r->id }}</td>
                <td>{{ $r->user->name }}</td>
                <td>{{ \Carbon\Carbon::parse($r->horario->fecha)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($r->horario->hora)->format('H:i') }}</td>
                <td>
                    <span class="badge badge-{{ strtolower($r->estado) }}">{{ $r->estado }}</span>
                </td>
                <td>${{ number_format($r->precio->valor, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="5" style="text-align:right;">Total ingresos (aprobadas):</td>
                <td>${{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i') }} - Sistema ReservaFutbol
    </div>
</body>

</html>
