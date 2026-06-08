@extends('layouts.app')

@push('styles')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detalle de Usuario</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    .users-show-page {
        padding: 28px 32px;
        max-width: 900px;
        margin: 0 auto;
        position: relative;
    }

    .users-show-page::before {
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
        font-size: 2rem;
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

    .back-link {
        color: var(--text-secondary);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        transition: color 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        margin-bottom: 12px;
    }

    .back-link:hover {
        color: var(--pitch-green);
    }

    .profile-card {
        position: relative;
        z-index: 1;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius);
        padding: 28px;
        backdrop-filter: blur(12px);
        margin-bottom: 24px;
        display: flex;
        gap: 24px;
        align-items: flex-start;
        flex-wrap: wrap;
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--pitch-green), #0b0f1c);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: #0b0f1c;
        flex-shrink: 0;
        border: 2px solid rgba(0, 245, 147, 0.2);
    }

    .profile-info {
        flex: 1;
        min-width: 200px;
    }

    .profile-info h3 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.6rem;
        letter-spacing: 1px;
        color: var(--text-primary);
        margin: 0 0 4px;
    }

    .profile-info .email {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .profile-info .meta {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        font-size: 0.85rem;
    }

    .profile-info .meta span {
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .profile-info .meta i {
        color: var(--pitch-green);
    }

    .profile-info .badge-rol {
        display: inline-block;
        background: rgba(0, 245, 147, 0.1);
        color: var(--pitch-green);
        padding: 3px 12px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .profile-info .badge-status {
        display: inline-block;
        padding: 3px 12px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-status.activo {
        background: rgba(0, 245, 147, 0.12);
        color: var(--pitch-green);
    }

    .badge-status.bloqueado {
        background: rgba(255, 68, 102, 0.12);
        color: var(--danger);
    }

    .section-title {
        position: relative;
        z-index: 1;
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.2rem;
        letter-spacing: 1px;
        color: var(--text-primary);
        margin: 28px 0 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .section-title i {
        color: var(--pitch-green);
    }

    .table-wrap {
        position: relative;
        z-index: 1;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius);
        padding: 0;
        overflow: hidden;
        backdrop-filter: blur(12px);
    }

    .table-wrap table {
        width: 100%;
        border-collapse: collapse;
    }

    .table-wrap th {
        background: rgba(0, 245, 147, 0.04);
        color: var(--text-secondary);
        padding: 12px 16px;
        text-align: left;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    }

    .table-wrap td {
        padding: 12px 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        font-size: 0.88rem;
        color: var(--text-primary);
    }

    .table-wrap tr:last-child td {
        border-bottom: none;
    }

    .table-wrap tr:hover td {
        background: rgba(255, 255, 255, 0.02);
    }

    .estado-disponible {
        background: rgba(0, 245, 147, 0.12);
        color: var(--pitch-green);
        padding: 2px 10px;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .estado-no-disponible {
        background: rgba(255, 68, 102, 0.12);
        color: var(--danger);
        padding: 2px 10px;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .estado-esperando {
        background: rgba(255, 180, 0, 0.12);
        color: var(--amber);
        padding: 2px 10px;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .empty-state {
        position: relative;
        z-index: 1;
        text-align: center;
        padding: 40px 20px;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius);
        color: var(--text-muted);
        backdrop-filter: blur(12px);
    }

    @media (max-width: 768px) {
        .users-show-page {
            padding: 16px;
        }
        .profile-card {
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        .profile-info .meta {
            justify-content: center;
        }
    }
</style>
@endpush

@section('main')
@if(session('success'))
<script>
    Swal.fire({ icon: 'success', title: 'Operación Exitosa', text: "{{ session('success') }}", confirmButtonText: 'Aceptar', background: '#12182f', color: '#f0f4ff', iconColor: '#00f593', confirmButtonColor: '#00f593' });
</script>
@endif

<div class="users-show-page">
    <a href="{{ route('admin.users.index') }}" class="back-link">
        <i class='bx bx-arrow-back'></i> Volver a usuarios
    </a>

    <div class="profile-card">
        <div class="profile-avatar">
            <i class='bx bx-user'></i>
        </div>
        <div class="profile-info">
            <h3>{{ $user->name }}</h3>
            <div class="email">
                <i class='bx bx-envelope'></i> {{ $user->email }}
            </div>
            <div class="meta">
                <span>
                    <i class='bx bx-shield'></i>
                    <span class="badge-rol">{{ $user->getRoleNames()->implode(', ') ?: 'Sin rol' }}</span>
                </span>
                <span>
                    <i class='bx bx-{{ $user->blocked ? "lock" : "check-circle" }}'></i>
                    <span class="badge-status {{ $user->blocked ? 'bloqueado' : 'activo' }}">
                        {{ $user->blocked ? 'Bloqueado' : 'Activo' }}
                    </span>
                </span>
                <span>
                    <i class='bx bx-calendar'></i>
                    Miembro desde {{ $user->created_at->format('d/m/Y') }}
                </span>
            </div>
        </div>
    </div>

    <div class="section-title">
        <i class='bx bx-list-ul'></i> Historial de Reservas
    </div>

    @if($user->reservas->isEmpty())
    <div class="empty-state">
        <i class='bx bx-inbox'></i>
        <p>Este usuario no tiene reservas.</p>
    </div>
    @else
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Horario</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                    <th>Creada</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user->reservas as $reserva)
                <tr>
                    <td><strong>#{{ $reserva->id }}</strong></td>
                    <td>{{ $reserva->horario->hora ? \Carbon\Carbon::parse($reserva->horario->hora)->format('H:i') : 'N/A' }}</td>
                    <td>{{ $reserva->horario->fecha ? \Carbon\Carbon::parse($reserva->horario->fecha)->format('d/m/Y') : 'N/A' }}</td>
                    <td>
                        <span class="{{ $reserva->estado == 'Aprobada' ? 'estado-disponible' : ($reserva->estado == 'Rechazada' ? 'estado-no-disponible' : 'estado-esperando') }}">
                            {{ $reserva->estado }}
                        </span>
                    </td>
                    <td>{{ $reserva->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endpush
@endsection
