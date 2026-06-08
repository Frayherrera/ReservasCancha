@extends('layouts.app')

@push('styles')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registrar Pago</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --pitch-green: #00f593;
        --pitch-green-glow: rgba(0, 245, 147, 0.25);
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

    .form-page {
        padding: 28px 32px;
        max-width: 650px;
        margin: 0 auto;
        position: relative;
    }

    .form-page::before {
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
        font-size: 2.2rem;
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

    .form-card {
        position: relative;
        z-index: 1;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius);
        padding: 28px;
        backdrop-filter: blur(12px);
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        font-size: 0.88rem;
        color: var(--text-primary);
        margin-bottom: 6px;
    }

    .form-group .form-control,
    .form-group select {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: var(--radius-sm);
        background: rgba(255, 255, 255, 0.04);
        color: var(--text-primary);
        font-family: 'Outfit', sans-serif;
        font-size: 0.9rem;
        transition: border-color 0.25s, box-shadow 0.25s;
        outline: none;
    }

    .form-group .form-control:focus,
    .form-group select:focus {
        border-color: var(--pitch-green);
        box-shadow: 0 0 0 3px rgba(0, 245, 147, 0.06);
    }

    .form-group .form-control::placeholder {
        color: var(--text-muted);
    }

    .form-group select option {
        background: #12182f;
        color: var(--text-primary);
    }

    .error-text {
        color: #ff4466;
        font-size: 0.82rem;
        display: block;
        margin-top: 4px;
    }

    .form-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 24px;
    }

    .btn-submit {
        background: var(--pitch-green);
        color: #0b0f1c;
        border: none;
        padding: 12px 28px;
        border-radius: var(--radius-sm);
        font-weight: 700;
        font-family: 'Outfit', sans-serif;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px var(--pitch-green-glow);
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 12px 24px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: var(--radius-sm);
        color: var(--text-secondary);
        text-decoration: none;
        font-weight: 600;
        font-family: 'Outfit', sans-serif;
        font-size: 0.9rem;
        transition: border-color 0.2s, color 0.2s;
    }

    .btn-back:hover {
        border-color: rgba(255, 255, 255, 0.15);
        color: var(--text-primary);
    }

    @media (max-width: 768px) {
        .form-page {
            padding: 16px;
        }
        .page-header h1 {
            font-size: 1.6rem;
        }
        .form-actions {
            flex-direction: column;
        }
        .form-actions .btn-back {
            width: 100%;
            justify-content: center;
        }
        .form-actions .btn-submit {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('main')
<div class="form-page">
    <div class="page-header">
        <div>
            <h1>
                <i class='bx bx-credit-card'></i>
                Registrar nuevo pago
            </h1>
            <span class="header-accent"></span>
        </div>
    </div>

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
                <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="monto">Monto ($)</label>
                <input type="number" step="0.01" name="monto" id="monto" class="form-control" value="{{ old('monto') }}" required>
                @error('monto')
                <span class="error-text">{{ $message }}</span>
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

            <div class="form-actions">
                <a href="{{ route('admin.pagos.index') }}" class="btn-back">
                    <i class='bx bx-x'></i> Cancelar
                </a>
                <button type="submit" class="btn-submit">
                    <i class='bx bx-save'></i> Registrar pago
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
