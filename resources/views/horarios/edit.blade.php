@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ReservaFutbol - Editar Horario</title>
    <link rel="stylesheet" href="/css/stylesWelcome.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
@section('main')
<div class="crear-horario-container">
    @if(session('error'))
    <script>
        Swal.fire({ icon: 'error', title: 'Error', text: "{{ session('error') }}" });
    </script>
    @endif

    @if($errors->any())
    <script>
        Swal.fire({ icon: 'error', title: 'Error', text: "{{ $errors->first() }}" });
    </script>
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <h2 class="form-title">Editar Horario</h2>

    <form action="{{ route('horarios.update', $horario) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Fecha</label>
            <input type="date" name="fecha" class="form-input" value="{{ old('fecha', \Carbon\Carbon::parse($horario->fecha)->format('Y-m-d')) }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">Hora</label>
            <select name="hora" class="form-select" required>
                <option value="">Seleccione hora</option>
                @for($h = 7; $h <= 22; $h++)
                    @php $val = sprintf('%02d:00', $h); @endphp
                    <option value="{{ $val }}" {{ \Carbon\Carbon::parse($horario->hora)->format('H:i') == $val ? 'selected' : '' }}>
                        {{ $val }}
                    </option>
                @endfor
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Estado</label>
            <select name="estado" class="form-select" required>
                <option value="Disponible" {{ $horario->estado == 'Disponible' ? 'selected' : '' }}>Disponible</option>
                <option value="No Disponible" {{ $horario->estado == 'No Disponible' ? 'selected' : '' }}>No Disponible</option>
            </select>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn-submit">Guardar Cambios</button>
            <a href="{{ route('horarios.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
