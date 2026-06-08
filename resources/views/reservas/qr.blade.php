@extends('layouts.app')

@push('styles')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>QR de Reserva</title>
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

    .qr-page {
        padding: 28px 32px;
        max-width: 550px;
        margin: 0 auto;
        text-align: center;
        position: relative;
    }

    .qr-page::before {
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
        margin: 6px auto 0;
    }

    .page-header .subtitle {
        color: var(--text-secondary);
        font-size: 0.85rem;
        font-weight: 300;
        margin: 6px 0 0;
    }

    .qr-card {
        position: relative;
        z-index: 1;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius);
        padding: 36px 32px;
        backdrop-filter: blur(12px);
    }

    .qr-card .qr-img {
        width: 260px;
        height: 260px;
        margin: 0 auto 20px;
        display: block;
        border-radius: 12px;
        border: 2px solid rgba(255, 255, 255, 0.04);
        background: white;
        padding: 8px;
    }

    .qr-card .info {
        margin-bottom: 20px;
    }

    .qr-card .info p {
        margin: 4px 0;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .qr-card .info strong {
        color: var(--text-primary);
    }

    .btn-print {
        background: var(--pitch-green);
        color: #0b0f1c;
        border: none;
        padding: 12px 28px;
        border-radius: var(--radius-sm);
        font-weight: 700;
        font-family: 'Outfit', sans-serif;
        cursor: pointer;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-print:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px var(--pitch-green-glow);
    }

    @media print {
        .sidebar, .sidebar-toggle, .sidebar-overlay {
            display: none !important;
        }
        .main-content {
            margin-left: 0 !important;
            width: 100% !important;
            padding: 0 !important;
        }
        .btn-print {
            display: none !important;
        }
        .page-header {
            display: none !important;
        }
        body {
            background: white !important;
        }
        .qr-card {
            box-shadow: none !important;
            border: 1px solid #e0e0e0 !important;
            background: white !important;
        }
        .qr-card .info p {
            color: #333 !important;
        }
        .qr-card .info strong {
            color: #000 !important;
        }
    }

    @media (max-width: 768px) {
        .qr-page {
            padding: 16px;
        }
        .page-header h1 {
            font-size: 1.6rem;
        }
        .qr-card .qr-img {
            width: 200px;
            height: 200px;
        }
    }
</style>
@endpush

@section('main')
<div class="qr-page">
    <div class="page-header">
        <div>
            <h1>
                <i class='bx bx-qr'></i> Código QR
            </h1>
            <p class="subtitle">Presenta este código para validar tu reserva</p>
            <span class="header-accent"></span>
        </div>
    </div>

    <div class="qr-card" id="qrSection">
        <img src="{{ $qrUrl }}" alt="QR de Reserva" class="qr-img" id="qrImage">

        <div class="info">
            <p><strong>Reserva:</strong> #{{ $reserva->id }}</p>
            <p><strong>Cliente:</strong> {{ $reserva->user->name }}</p>
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($reserva->horario->fecha)->format('d/m/Y') }}</p>
            <p><strong>Hora:</strong> {{ \Carbon\Carbon::parse($reserva->horario->hora)->format('H:i') }} hrs</p>
            <p><strong>Estado:</strong> {{ $reserva->estado }}</p>
        </div>

        <button class="btn-print" onclick="window.print()">
            <i class='bx bx-printer'></i> Imprimir QR
        </button>
    </div>
</div>
@endsection
