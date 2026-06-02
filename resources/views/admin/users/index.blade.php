@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Contenedor principal con efecto glassmorphism */
        .users-container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Header */
        .users-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 3px solid linear-gradient(135deg, #667eea, #764ba2);
        }

        .users-title {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .users-title i {
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-size: 2rem;
        }

        /* Estadísticas */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            padding: 1.5rem;
            border-radius: 15px;
            color: white;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .stat-card h3 {
            font-size: 2rem;
            margin: 0;
        }

        .stat-card p {
            margin: 0;
            opacity: 0.9;
        }

        /* Tabla moderna */
        .users-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        .users-table thead th {
            background: #667eea;
            color: white;
            padding: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
        }

        .users-table thead th:first-child {
            border-radius: 15px 0 0 15px;
        }

        .users-table thead th:last-child {
            border-radius: 0 15px 15px 0;
        }

        .users-table tbody tr {
            background: white;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .users-table tbody tr:hover {
            transform: scale(1.01);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }

        .users-table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
        }

        /* Badges de estado */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-active {
            background: linear-gradient(135deg, #11998e, #38ef7d);
            color: white;
        }

        .status-blocked {
            background: linear-gradient(135deg, #eb3349, #f45c43);
            color: white;
        }

        /* Botones modernos */
        .btn-modern {
            padding: 6px 12px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-view {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: white;
        }

        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(79, 172, 254, 0.4);
        }

        .btn-block {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            color: white;
        }

        .btn-block:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(245, 87, 108, 0.4);
        }

        .btn-unblock {
            background: linear-gradient(135deg, #11998e, #38ef7d);
            color: white;
        }

        .btn-unblock:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(17, 153, 142, 0.4);
        }

        /* Select personalizado */
        .role-select {
            padding: 6px 25px 6px 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 0.85rem;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23667eea' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 8px center;
        }

        .role-select:hover {
            border-color: #667eea;
        }

        .role-select:focus {
            outline: none;
            border-color: #764ba2;
            box-shadow: 0 0 0 3px rgba(118, 75, 162, 0.1);
        }

        /* Mensaje vacío */
        .empty-state {
            text-align: center;
            padding: 4rem;
            background: white;
            border-radius: 15px;
        }

        .empty-state i {
            font-size: 4rem;
            color: #667eea;
            margin-bottom: 1rem;
        }

        .empty-state p {
            font-size: 1.2rem;
            color: #666;
        }

        /* Paginación moderna */
        .pagination-modern {
            margin-top: 2rem;
        }

        .pagination-modern .pagination {
            justify-content: center;
        }

        .pagination-modern .page-item .page-link {
            border: none;
            margin: 0 5px;
            border-radius: 10px;
            color: #667eea;
            background: white;
            transition: all 0.3s ease;
        }

        .pagination-modern .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .pagination-modern .page-item .page-link:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        /* Texto "(Tú)" */
        .current-user-badge {
            background: #667eea;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-left: 8px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .users-container {
                margin: 1rem;
                padding: 1rem;
            }

            .users-table {
                font-size: 0.8rem;
            }

            .btn-modern {
                padding: 4px 8px;
                font-size: 0.7rem;
            }

            .role-select {
                font-size: 0.7rem;
                padding: 4px 20px 4px 8px;
            }
        }

        /* Animación para filas */
        .users-table tbody tr {
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
</head>

@section('main')
<body>
    @if(session('success'))
    <script>
        Swal.fire({ 
            icon: 'success', 
            title: '¡Operación Exitosa!', 
            text: "{{ session('success') }}", 
            confirmButtonText: 'Aceptar',
            background: 'white',
            confirmButtonColor: '#667eea'
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({ 
            icon: 'error', 
            title: 'Error', 
            text: "{{ session('error') }}", 
            confirmButtonText: 'Aceptar',
            background: 'white',
            confirmButtonColor: '#667eea'
        });
    </script>
    @endif

    <div class="users-container">
        <div class="users-header">
            <div class="users-title">
                <i class='bx bx-group'></i>
                <span>Gestión de Usuarios</span>
            </div>
            <div>
                <span style="background: #667eea20; padding: 8px 16px; border-radius: 10px;">
                    <i class='bx bx-calendar'></i> Total: {{ $users->total() }} usuarios
                </span>
            </div>
        </div>

        @if($users->isEmpty())
        <div class="empty-state">
            <i class='bx bx-user-x'></i>
            <p>No hay usuarios registrados</p>
        </div>
        @else
        <table class="users-table">
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
                @foreach($users as $index => $user)
                <tr>
                    <td><strong>#{{ $user->id }}</strong></td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 35px; height: 35px; background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white;">
                                <i class='bx bx-user'></i>
                            </div>
                            <strong>{{ $user->name }}</strong>
                        </div>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 5px;">
                            <i class='bx bx-envelope' style="color: #667eea;"></i>
                            {{ $user->email }}
                        </div>
                    </td>
                    <td>
                        <span style="background: #667eea20; padding: 4px 12px; border-radius: 12px; font-size: 0.8rem;">
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
                        <span style="display: inline-flex; align-items: center; gap: 5px;">
                            <i class='bx bx-calendar-check' style="color: #667eea;"></i>
                            <strong>{{ $user->reservas->count() }}</strong>
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn-modern btn-view">
                                <i class='bx bx-show-alt'></i> Ver
                            </a>

                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.block', $user) }}" method="POST" style="display:inline">
                                @csrf
                                <button type="submit" class="btn-modern {{ $user->blocked ? 'btn-unblock' : 'btn-block' }}">
                                    <i class='bx {{ $user->blocked ? "bx-unlock-alt" : "bx-lock-alt" }}'></i>
                                    {{ $user->blocked ? 'Desbloquear' : 'Bloquear' }}
                                </button>
                            </form>

                            <form action="{{ route('admin.users.changeRole', $user) }}" method="POST" style="display:inline">
                                @csrf
                                <select name="role" onchange="this.form.submit()" class="role-select">
                                    <option value="cliente" {{ $user->hasRole('cliente') ? 'selected' : '' }}>👤 Cliente</option>
                                    <option value="administrador" {{ $user->hasRole('administrador') ? 'selected' : '' }}>🛡️ Admin</option>
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

        <div class="pagination-modern">
            {{ $users->links('pagination::bootstrap-4') }}
        </div>
        @endif
    </div>
</body>
@endsection