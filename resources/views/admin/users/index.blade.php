@extends('layouts.app')

@push('styles')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestión de Usuarios</title>
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

    .users-page {
        padding: 28px 32px;
        max-width: 1400px;
        margin: 0 auto;
        position: relative;
    }

    .users-page::before {
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
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
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

    .stats-grid {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 14px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius);
        padding: 20px;
        text-align: center;
        backdrop-filter: blur(12px);
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
        background: var(--pitch-green);
        opacity: 0.2;
    }

    .stat-card:hover {
        transform: translateY(-3px);
    }

    .stat-card i {
        font-size: 28px;
        color: var(--pitch-green);
        margin-bottom: 6px;
    }

    .stat-card h3 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.8rem;
        letter-spacing: 1px;
        margin: 0;
        line-height: 1;
        color: var(--text-primary);
    }

    .stat-card p {
        margin: 4px 0 0;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-secondary);
    }

    .table-wrap {
        position: relative;
        z-index: 1;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius);
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
        padding: 14px 16px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
        font-size: 0.88rem;
        color: var(--text-primary);
        vertical-align: middle;
    }

    .table-wrap tr:last-child td {
        border-bottom: none;
    }

    .table-wrap tr:hover td {
        background: rgba(255, 255, 255, 0.02);
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(0, 245, 147, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--pitch-green);
        font-size: 16px;
        flex-shrink: 0;
        border: 1px solid rgba(0, 245, 147, 0.15);
    }

    .user-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-cell strong {
        color: var(--text-primary);
    }

    .rol-badge {
        background: rgba(0, 245, 147, 0.08);
        color: var(--pitch-green);
        padding: 3px 12px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 12px;
        font-size: 0.72rem;
        font-weight: 600;
    }

    .status-active {
        background: rgba(0, 245, 147, 0.12);
        color: var(--pitch-green);
    }

    .status-blocked {
        background: rgba(255, 68, 102, 0.12);
        color: var(--danger);
    }

    .btn-modern {
        padding: 6px 14px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-family: 'Outfit', sans-serif;
        font-size: 0.78rem;
        transition: transform 0.2s;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .btn-modern:hover {
        transform: scale(1.03);
    }

    .btn-view {
        background: rgba(0, 245, 147, 0.1);
        color: var(--pitch-green);
        border: 1px solid rgba(0, 245, 147, 0.1);
    }

    .btn-block-action {
        background: rgba(255, 68, 102, 0.1);
        color: var(--danger);
        border: 1px solid rgba(255, 68, 102, 0.1);
    }

    .btn-unblock {
        background: rgba(0, 245, 147, 0.1);
        color: var(--pitch-green);
        border: 1px solid rgba(0, 245, 147, 0.1);
    }

    .role-select {
        padding: 6px 28px 6px 12px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 8px;
        font-size: 0.8rem;
        font-family: 'Outfit', sans-serif;
        background: rgba(255, 255, 255, 0.04);
        color: var(--text-primary);
        cursor: pointer;
        transition: border-color 0.2s;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%2300f593' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 8px center;
    }

    .role-select:focus {
        outline: none;
        border-color: var(--pitch-green);
    }

    .role-select option {
        background: #12182f;
        color: var(--text-primary);
    }

    .current-user-badge {
        background: rgba(0, 245, 147, 0.1);
        color: var(--pitch-green);
        padding: 4px 10px;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .empty-state {
        position: relative;
        z-index: 1;
        text-align: center;
        padding: 60px 20px;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius);
        backdrop-filter: blur(12px);
    }

    .empty-state i {
        font-size: 48px;
        color: var(--text-muted);
        margin-bottom: 12px;
    }

    .empty-state p {
        color: var(--text-secondary);
    }

    .total-info {
        position: relative;
        z-index: 1;
        background: rgba(0, 245, 147, 0.04);
        border: 1px solid rgba(0, 245, 147, 0.08);
        padding: 8px 16px;
        border-radius: var(--radius-sm);
        font-size: 0.85rem;
        color: var(--text-secondary);
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .total-info i {
        color: var(--pitch-green);
    }

    @media (max-width: 768px) {
        .users-page {
            padding: 16px;
        }
        .page-header h1 {
            font-size: 1.8rem;
        }
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .table-wrap {
            overflow-x: auto;
        }
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
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
@if(session('error'))
<script>
    Swal.fire({ icon: 'error', title: 'Error', text: "{{ session('error') }}", confirmButtonText: 'Aceptar', background: '#12182f', color: '#f0f4ff', iconColor: '#ff4466', confirmButtonColor: '#00f593' });
</script>
@endif

<div class="users-page">
    <div class="page-header">
        <div>
            <h1>
                <i class='bx bx-group'></i>
                Gestión de Usuarios
            </h1>
            <p class="subtitle">Administra los usuarios del sistema</p>
            <span class="header-accent"></span>
        </div>
        <div class="total-info">
            <i class='bx bx-calendar'></i> Total: {{ $users->total() }} usuarios
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <i class='bx bx-group'></i>
            <h3>{{ $totalUsuarios }}</h3>
            <p>Total usuarios</p>
        </div>
        <div class="stat-card">
            <i class='bx bx-shield'></i>
            <h3>{{ $totalAdministradores ?? 0 }}</h3>
            <p>Administradores</p>
        </div>
        <div class="stat-card">
            <i class='bx bx-user'></i>
            <h3>{{ $totalClientes ?? 0 }}</h3>
            <p>Clientes</p>
        </div>
    </div>

    @if($users->isEmpty())
    <div class="empty-state">
        <i class='bx bx-user-x'></i>
        <p>No hay usuarios registrados</p>
    </div>
    @else
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Reservas</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td><strong>#{{ $user->id }}</strong></td>
                    <td>
                        <div class="user-cell">
                            <div class="user-avatar"><i class='bx bx-user'></i></div>
                            <strong>{{ $user->name }}</strong>
                        </div>
                    </td>
                    <td>
                        <span style="display:flex; align-items:center; gap:4px;">
                            <i class='bx bx-envelope' style="color:var(--pitch-green);"></i>
                            {{ $user->email }}
                        </span>
                    </td>
                    <td>
                        <span class="rol-badge">
                            <i class='bx {{ $user->hasRole('administrador') ? 'bx-shield' : 'bx-user' }}'></i>
                            {{ $user->getRoleNames()->implode(', ') ?: 'Sin rol' }}
                        </span>
                    </td>
                    <td>
                        <span class="status-badge {{ $user->blocked ? 'status-blocked' : 'status-active' }}">
                            <i class='bx {{ $user->blocked ? "bx-lock" : "bx-check-circle" }}'></i>
                            {{ $user->blocked ? 'Bloqueado' : 'Activo' }}
                        </span>
                    </td>
                    <td>
                        <span style="display:inline-flex; align-items:center; gap:4px;">
                            <i class='bx bx-calendar-check' style="color:var(--pitch-green);"></i>
                            <strong>{{ $user->reservas->count() }}</strong>
                        </span>
                    </td>
                    <td>
                        <div style="display:flex; gap:6px; flex-wrap:wrap;">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn-modern btn-view">
                                <i class='bx bx-show-alt'></i> Ver
                            </a>

                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.block', $user) }}" method="POST" style="display:inline">
                                @csrf
                                <button type="submit" class="btn-modern {{ $user->blocked ? 'btn-unblock' : 'btn-block-action' }}">
                                    <i class='bx {{ $user->blocked ? "bx-unlock-alt" : "bx-lock-alt" }}'></i>
                                    {{ $user->blocked ? 'Desbloquear' : 'Bloquear' }}
                                </button>
                            </form>

                            <form action="{{ route('admin.users.changeRole', $user) }}" method="POST" style="display:inline">
                                @csrf
                                <select name="role" onchange="this.form.submit()" class="role-select">
                                    <option value="cliente" {{ $user->hasRole('cliente') ? 'selected' : '' }}>Cliente</option>
                                    <option value="administrador" {{ $user->hasRole('administrador') ? 'selected' : '' }}>Admin</option>
                                </select>
                            </form>
                            @else
                            <span class="current-user-badge">
                                <i class='bx bx-user-check'></i> Tú
                            </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4" style="position:relative; z-index:1;">
        {{ $users->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>
@endpush
@endsection
