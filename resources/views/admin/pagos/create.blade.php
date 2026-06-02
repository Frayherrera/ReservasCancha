@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Pago</title>
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
            transition: border-color 0.2s;
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
            font-size: 1rem;
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
    </style>
</head>

@section('main')
<div class="form-page">
    <h1><i class='bx bx-credit-card'></i> Registrar nuevo pago</h1>

    <div class="form-card">
        <form method="POST" action="{{ route('admin.pagos.store') }}">
            @csrf

            <div class="form-group">
                <label for="reserva_id">Reserva</label>
                <select name="reserva_id" id="reserva_id" required>
                    <option value="">Seleccionar reserva...</option>
                    @foreach($reservas as $r)
                    <option value="{{ $r->id }}" {{ request('reserva_id') == $r->id ? 'selected' : '' }}>
                        #{{ $r->id }} - {{ $r->user->name }} - {{ \Carbon\Carbon::parse($r->horario->fecha)->format('d/m') }} {{ \Carbon\Carbon::parse($r->horario->hora)->format('H:i') }} - ${{ number_format($r->precio->valor, 0, ',', '.') }}
                    </option>
                    @endforeach
                </select>
                @error('reserva_id')
                <span style="color:#ef4444; font-size:0.85rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="monto">Monto ($)</label>
                <input type="number" step="0.01" name="monto" id="monto" class="form-control" value="{{ old('monto') }}" required>
                @error('monto')
                <span style="color:#ef4444; font-size:0.85rem;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="metodo_pago">Método de pago</label>
                <select name="metodo_pago" id="metodo_pago" required>
                    <option value="Efectivo">Efectivo</option>
                    <option value="Transferencia">Transferencia</option>
                    <option value="Tarjeta">Tarjeta</option>
                    <option value="Pago en línea">Pago en línea</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>

            <div class="form-group">
                <label for="referencia">Referencia (opcional)</label>
                <input type="text" name="referencia" id="referencia" class="form-control" value="{{ old('referencia') }}" placeholder="N° de transferencia, tarjeta, etc.">
            </div>

            <div class="form-group">
                <label for="estado">Estado del pago</label>
                <select name="estado" id="estado" required>
                    <option value="Pagado">Pagado</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Cancelado">Cancelado</option>
                </select>
            </div>

            <div style="display:flex; align-items:center; gap:12px; margin-top:24px;">
                <a href="{{ route('admin.pagos.index') }}" class="btn-back">Cancelar</a>
                <button type="submit" class="btn-submit">
                    <i class='bx bx-save'></i> Registrar pago
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
