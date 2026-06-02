@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR de Reserva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .qr-page {
            padding: 24px;
            max-width: 500px;
            margin: 0 auto;
            text-align: center;
        }
        .qr-page h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 8px;
        }
        .qr-card {
            background: white;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }
        .qr-card .qr-img {
            width: 280px;
            height: 280px;
            margin: 0 auto 20px;
            display: block;
            border-radius: 12px;
        }
        .qr-card .info {
            margin-bottom: 16px;
        }
        .qr-card .info p {
            margin: 4px 0;
            color: #374151;
            font-size: 0.95rem;
        }
        .qr-card .info strong {
            color: #1a1a2e;
        }
        .btn-print {
            background: #003770;
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-print:hover {
            background: #1e7ede;
        }
    </style>
</head>

@section('main')
<div class="qr-page">
    <h1><i class='bx bx-qr'></i> Código QR de Reserva</h1>
    <p style="color:#6b7280; margin-bottom:24px;">Presenta este código para validar tu reserva</p>

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

<style>
    @media print {
        .sidebar,
        .sidebar-toggle,
        .sidebar-overlay {
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
        .qr-page h1,
        .qr-page>p {
            display: none !important;
        }
    }
</style>
@endsection
