@extends('layouts.app')


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ReservaFutbol</title>
    <link rel="stylesheet" href="/css/stylesWelcome.css">
    <!-- Bootstrap CSS -->
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
        Swal.fire({
            icon: 'success',
            title: 'Operación Exitosa',
            text: "{{ session('success') }}",
            confirmButtonText: 'Aceptar'
        });
    </script>
    @endif

    <div class="horarios-container">
        @if($reservas->isEmpty())
        <div class="sin-horarios">
            <p>No existen reservas</p>
        </div>
        @else

        <table class="horarios-tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Estado</th>
                    <th>Precio</th>
                    <th>Horario</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservas as $reserva)
                <tr>
                    <td>{{ $reserva->id }}</td>
                    <td>{{ $reserva->user->name }}</td>
                    <td>
                        <span class="
        @if ($reserva->estado === 'Pendiente')
            estado-pendiente
        @elseif ($reserva->estado === 'Aprobada')
            estado-aprobada
        @elseif ($reserva->estado === 'Rechazada')
            estado-rechazada
        @endif
    ">
                            {{ $reserva->estado }}
                        </span>
                    </td>
                    <td>{{ $reserva->precio->valor }}</td>
                    <td>{{ $reserva->horario->hora }}</td>

                    <td>
                        <form action="{{ route('reservas.aprobar', $reserva->id) }}" method="post" class="d-inline-block">
                            @csrf
                            <button onclick="funcion" type="submit" class="btn btn-outline">
                                <i class='bx bxs-check-circle bx-tada' style='color:#73dc1f; font-size: 30px;'></i>
                            </button>
                        </form>

                        <form action="{{ route('reservas.rechazar', $reserva->id) }}" method="post" class="d-inline-block">
                            @csrf
                            <button type="submit" class="btn btn-outline">
                                <i class='bx bxs-x-circle bx-tada' style='color:#ff0000; font-size: 30px;'></i>
                            </button>
                        </form>
                        <form action="{{route('reservas.destroy', $reserva->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta reserva?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline">
                                <i class='bx bxs-trash bx-tada' style='color:#ff0000; font-size: 30px;'></i>
                            </button>
                        </form>



                    </td>


                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center mt-4">
            {{ $reservas->links('pagination::bootstrap-4') }}
        </div>

        @endif
    </div>
</body>

</html>
<style>
    .estado-pendiente {
        background-color: #ffeb3b;
        /* Amarillo */
        color: #000;
        padding: 5px 10px;
        border-radius: 4px;
    }

    .estado-aprobada {
        background-color: #4caf50;
        /* Verde */
        color: #fff;
        padding: 5px 10px;
        border-radius: 4px;
    }

    .estado-rechazada {
        background-color: #f44336;
        /* Rojo */
        color: #fff;
        padding: 5px 10px;
        border-radius: 4px;
    }

    .horarios-container {
        margin: 20px auto;
        max-width: 1000px;
        font-family: Arial, sans-serif;
    }

    .horarios-tabla {
        width: 100%;
        border-collapse: collapse;
        background: white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .horarios-tabla th {
        background: #003366;
        color: white;
        padding: 15px;
        text-align: center;
        font-weight: 500;
    }

    .horarios-tabla td {
        padding: 12px;
        text-align: center;
        border: 1px solid #eee;
    }

    .horarios-tabla tr:nth-child(even) {
        background: #f9f9f9;
    }

    .estado {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .disponible {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .ocupado {
        background: #ffebee;
        color: #c62828;
    }

    .btn-reservar {
        background: #4CAF50;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .btn-reservar:hover {
        background: #45a049;
    }

    .sin-horarios {
        text-align: center;
        padding: 20px;
        background: #f5f5f5;
        border-radius: 4px;
        color: #666;
    }
</style>
@endsection