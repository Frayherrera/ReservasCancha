@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .form-page {
            padding: 16px;
            max-width: 600px;
            margin: 0 auto;
        }
        .form-page h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 24px;
        }
        .form-card {
            background: white;
            border-radius: 14px;
            padding: 28px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }
        .form-card .form-group {
            margin-bottom: 18px;
        }
        .form-card label {
            display: block;
            font-weight: 600;
            font-size: 0.9rem;
            color: #374151;
            margin-bottom: 6px;
        }
        .form-card .form-control,
        .form-card select {
            width: 100%;
            padding: 10px 14px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 0.95rem;
        }
        .form-card .form-control:focus,
        .form-card select:focus {
            outline: none;
            border-color: #4facfe;
        }
        .btn-submit {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
        }
        .btn-back {
            display: inline-block;
            padding: 12px 24px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            color: #6b7280;
            text-decoration: none;
            font-weight: 600;
            margin-right: 10px;
        }
        .info-box {
            background: #f0f7ff;
            border-radius: 10px;
            padding: 14px 18px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            color: #1a1a2e;
        }
        .info-box strong {
            color: #4facfe;
        }
    </style>
</head>

@section('main')
<div class="form-page">
    <h1><i class='bx bx-edit'></i> Editar pago #{{ $pago->id }}</h1>

    <div class="form-card">
        <div class="info-box">
            <strong>Reserva #{{ $pago->reserva_id }}</strong> —
            {{ $pago->reserva->user->name ?? '—' }} —
            {{ $pago->reserva->horario ? \Carbon\Carbon::parse($pago->reserva->horario->fecha)->format('d/m/Y') : '—' }}
            <br>
            Monto original: <strong>${{ number_format($pago->monto, 0, ',', '.') }}</strong>
        </div>

        <form method="POST" action="{{ route('admin.pagos.update', $pago) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="metodo_pago">Método de pago</label>
                <select name="metodo_pago" id="metodo_pago" required>
                    <option value="Efectivo" {{ $pago->metodo_pago == 'Efectivo' ? 'selected' : '' }}>Efectivo</option>
                    <option value="Transferencia" {{ $pago->metodo_pago == 'Transferencia' ? 'selected' : '' }}>Transferencia</option>
                    <option value="Tarjeta" {{ $pago->metodo_pago == 'Tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                    <option value="Pago en línea" {{ $pago->metodo_pago == 'Pago en línea' ? 'selected' : '' }}>Pago en línea</option>
                    <option value="Otro" {{ $pago->metodo_pago == 'Otro' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>

            <div class="form-group">
                <label for="referencia">Referencia</label>
                <input type="text" name="referencia" id="referencia" class="form-control" value="{{ old('referencia', $pago->referencia) }}" placeholder="N° de transferencia, tarjeta, etc.">
            </div>

            <div class="form-group">
                <label for="estado">Estado</label>
                <select name="estado" id="estado" required>
                    <option value="Pendiente" {{ $pago->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="Pagado" {{ $pago->estado == 'Pagado' ? 'selected' : '' }}>Pagado</option>
                    <option value="Cancelado" {{ $pago->estado == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                    <option value="Reembolsado" {{ $pago->estado == 'Reembolsado' ? 'selected' : '' }}>Reembolsado</option>
                </select>
            </div>

            <div style="display:flex; align-items:center; gap:12px; margin-top:24px;">
                <a href="{{ route('admin.pagos.index') }}" class="btn-back">Cancelar</a>
                <button type="submit" class="btn-submit">
                    <i class='bx bx-save'></i> Actualizar pago
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
