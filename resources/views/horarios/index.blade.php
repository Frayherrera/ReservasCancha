@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ReservaFutbol - Reserva tu cancha</title>
    <link rel="stylesheet" href="css/stylesWelcome.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


</head>
@section('main')
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horarios Disponibles</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .horarios-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .sin-horarios {
            text-align: center;
            padding: 40px;
            background-color: #f8f9fa;
            border-radius: 8px;
            margin: 20px 0;
        }

        .horarios-tabla {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .horarios-tabla th,
        .horarios-tabla td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .horarios-tabla th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .estado {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .esperando {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .disponible {
            background-color: #d4edda;
            color: #155724;
        }

        .no.disponible {
            background-color: #f8d7da;
            color: #721c24;
        }

        .btn-reservar {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-reservar:hover {
            background-color: #0056b3;
        }

        .btn-disabled {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: not-allowed;
            opacity: 0.65;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }

        .pagination {
            margin-top: 20px;
        }

        .modal-confirm {
            color: #636363;
        }

        .modal-confirm .modal-content {
            padding: 20px;
            border-radius: 5px;
            border: none;
        }

        .modal-confirm .modal-header {
            border-bottom: none;
            position: relative;
        }

        .modal-confirm h4 {
            text-align: center;
            font-size: 26px;
            margin: 30px 0 -15px;
        }

        .modal-confirm .form-control,
        .modal-confirm .btn {
            min-height: 40px;
            border-radius: 3px;
        }

        .modal-confirm .close {
            position: absolute;
            top: -5px;
            right: -5px;
        }

        .modal-confirm .modal-footer {
            border: none;
            text-align: center;
            border-radius: 5px;
            font-size: 13px;
        }

        .modal-confirm .icon-box {
            color: #fff;
            position: absolute;
            margin: 0 auto;
            left: 0;
            right: 0;
            top: -70px;
            width: 95px;
            height: 95px;
            border-radius: 50%;
            z-index: 9;
            background: #82ce34;
            padding: 15px;
            text-align: center;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
        }

        .modal-confirm .icon-box i {
            font-size: 58px;
            position: relative;
            top: 3px;
        }
    </style>
</head>

<body>
    <div class="horarios-container">
        @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if($horarios->isEmpty())
        <div class="sin-horarios">
            <p class="mb-0">No existen horarios disponibles</p>
        </div>
        @else
        <table class="horarios-tabla">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($horarios as $horario)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($horario->fecha)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($horario->hora)->format('H:i') }}</td>
                    <td>
                        @if($horario->reserva)
                        Reservada: {{ $horario->reserva->user->name }} <!-- Nombre del cliente que reservó -->
                        @else
                        @if($horario->estado == 'Disponible')
                        <span class="estado {{ strtolower($horario->estado) }}">
                            {{ $horario->estado }}
                        </span>
                        @else
                        <span class="esperando {{ strtolower($horario->estado) }}">Esperando Respuesta</span>
                        @endif
                        @endif
                    </td>
                    <td>
                        @if($horario->estado == 'Disponible')
                        <button type="button"
                            class="btn-reservar"
                            data-bs-toggle="modal"
                            data-bs-target="#confirmModal{{ $horario->id }}"
                            data-hora="{{ \Carbon\Carbon::parse($horario->hora)->format('H:i') }}"
                            data-fecha="{{ \Carbon\Carbon::parse($horario->fecha)->format('d/m/Y') }}">
                            Reservar
                        </button>

                        <!-- Modal de Confirmación -->
                        <div class="modal fade" id="confirmModal{{ $horario->id }}" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-confirm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmModalLabel">Confirmar Reserva</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Deseas reservar el horario del día {{ \Carbon\Carbon::parse($horario->fecha)->format('d/m/Y') }}
                                        a las {{ \Carbon\Carbon::parse($horario->hora)->format('H:i') }}?
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('reservas.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="horario_id" value="{{ $horario->id }}">
                                            <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Confirmar Reserva</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <button class="btn-disabled" disabled>X</button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center mt-4">
            {{ $horarios->links('pagination::bootstrap-4') }}
        </div>
        @endif
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script para auto-ocultar las alertas -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-ocultar alertas después de 5 segundos
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                }, 5000);
            });
        });
    </script>
</body>


</html>
<style>
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