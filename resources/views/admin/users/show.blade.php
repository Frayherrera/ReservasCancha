@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
@section('main')
<!DOCTYPE html>
<html>

<body>
    @if(session('success'))
    <script>
        Swal.fire({ icon: 'success', title: 'Operación Exitosa', text: "{{ session('success') }}", confirmButtonText: 'Aceptar' });
    </script>
    @endif

    <div class="horarios-container">
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary mb-3">← Volver</a>

        <div class="card mb-4">
            <div class="card-header">
                <h3>{{ $user->name }}</h3>
            </div>
            <div class="card-body">
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Rol:</strong> {{ $user->getRoleNames()->implode(', ') ?: 'Sin rol' }}</p>
                <p><strong>Estado:</strong>
                    <span class="{{ $user->blocked ? 'estado no disponible' : 'estado disponible' }}">
                        {{ $user->blocked ? 'Bloqueado' : 'Activo' }}
                    </span>
                </p>
                <p><strong>Miembro desde:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>

        <h3>Historial de Reservas</h3>

        @if($user->reservas->isEmpty())
        <div class="sin-horarios">
            <p>Este usuario no tiene reservas.</p>
        </div>
        @else
        <table class="horarios-tabla">
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
                    <td>{{ $reserva->id }}</td>
                    <td>{{ $reserva->horario->hora ? \Carbon\Carbon::parse($reserva->horario->hora)->format('H:i') : 'N/A' }}</td>
                    <td>{{ $reserva->horario->fecha ? \Carbon\Carbon::parse($reserva->horario->fecha)->format('d/m/Y') : 'N/A' }}</td>
                    <td>
                        <span class="{{ $reserva->estado == 'Aprobada' ? 'estado disponible' : ($reserva->estado == 'Rechazada' ? 'estado no disponible' : 'estado esperando') }}">
                            {{ $reserva->estado }}
                        </span>
                    </td>
                    <td>{{ $reserva->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</body>
</html>
@endsection
