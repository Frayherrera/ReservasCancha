@extends('layouts.app')

@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ReservaFutbol - Crear Horarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --pitch-green: #00f593;
            --pitch-green-glow: rgba(0, 245, 147, 0.3);
            --pitch-green-dim: rgba(0, 245, 147, 0.08);
            --stadium-bg: #0b0f1c;
            --card-bg: rgba(12, 16, 30, 0.92);
            --card-border: rgba(255, 255, 255, 0.06);
            --input-bg: rgba(255, 255, 255, 0.04);
            --input-border: rgba(255, 255, 255, 0.08);
            --text-primary: #f0f4ff;
            --text-secondary: rgba(240, 244, 255, 0.55);
            --text-muted: rgba(240, 244, 255, 0.3);
            --danger: #ff4466;
            --radius: 16px;
            --radius-sm: 10px;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--stadium-bg) !important;
        }

        .crear-horario-container {
            max-width: 580px;
            margin: 32px auto;
            padding: 0 16px;
            position: relative;
        }

        .crear-horario-container::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                repeating-linear-gradient(0deg, transparent, transparent 60px, rgba(0, 245, 147, 0.012) 60px, rgba(0, 245, 147, 0.012) 61px),
                repeating-linear-gradient(90deg, transparent, transparent 60px, rgba(0, 245, 147, 0.012) 60px, rgba(0, 245, 147, 0.012) 61px);
            pointer-events: none;
            z-index: 0;
        }

        .form-card {
            position: relative;
            z-index: 1;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: var(--radius);
            padding: 32px;
            backdrop-filter: blur(16px);
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.4);
        }

        .form-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--pitch-green), transparent);
            opacity: 0.3;
        }

        .form-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2.4rem;
            letter-spacing: 1.5px;
            color: var(--text-primary);
            margin: 0 0 4px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-title i {
            color: var(--pitch-green);
            font-size: 1.8rem;
        }

        .form-subtitle {
            color: var(--text-secondary);
            font-size: 0.85rem;
            font-weight: 300;
            margin: 0 0 28px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .form-input,
        .form-select {
            width: 100%;
            padding: 12px 16px;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            font-family: 'Outfit', sans-serif;
            color: var(--text-primary);
            transition: border-color 0.25s, box-shadow 0.25s;
            outline: none;
            appearance: none;
        }

        .form-input:focus,
        .form-select:focus {
            border-color: var(--pitch-green);
            box-shadow: 0 0 0 3px var(--pitch-green-dim);
        }

        .form-input::placeholder {
            color: var(--text-muted);
        }

        .form-select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='rgba(240,244,255,0.4)' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px;
            cursor: pointer;
        }

        .form-select option {
            background: #12182f;
            color: var(--text-primary);
        }

        .form-select:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .alert {
            position: relative;
            z-index: 1;
            padding: 14px 20px;
            border-radius: var(--radius-sm);
            margin-bottom: 20px;
            font-size: 0.9rem;
            font-weight: 400;
            border: 1px solid transparent;
            backdrop-filter: blur(8px);
        }

        .alert-danger {
            background: rgba(255, 68, 102, 0.1);
            color: var(--danger);
            border-color: rgba(255, 68, 102, 0.15);
        }

        .alert-danger ul {
            margin: 0;
            list-style: none;
            padding: 0;
        }

        /* Preview */
        .preview-section {
            margin-top: 24px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: var(--radius-sm);
            display: none;
        }

        .preview-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.2rem;
            letter-spacing: 1px;
            color: var(--text-secondary);
            margin: 0 0 12px;
        }

        .preview-list {
            list-style: none;
            padding: 0;
            margin: 0;
            max-height: 220px;
            overflow-y: auto;
        }

        .preview-list::-webkit-scrollbar {
            width: 4px;
        }

        .preview-list::-webkit-scrollbar-track {
            background: transparent;
        }

        .preview-list::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 4px;
        }

        .preview-item {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.04);
            border-radius: 8px;
            margin-bottom: 6px;
            padding: 10px 14px;
            transition: background 0.2s;
        }

        .preview-item:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .preview-item-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .preview-date {
            font-weight: 500;
            color: var(--text-secondary);
            font-size: 0.85rem;
        }

        .preview-time {
            color: var(--text-primary);
            font-size: 0.85rem;
            font-weight: 600;
        }

        .preview-status {
            padding: 3px 12px;
            border-radius: 100px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .preview-status.disponible {
            background: rgba(0, 245, 147, 0.1);
            color: var(--pitch-green);
            border: 1px solid rgba(0, 245, 147, 0.12);
        }

        .preview-status.no.disponible,
        .preview-status.ocupado {
            background: rgba(255, 68, 102, 0.1);
            color: var(--danger);
            border: 1px solid rgba(255, 68, 102, 0.12);
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            margin-top: 8px;
            background: var(--pitch-green);
            color: #0b0f1c;
            border: none;
            border-radius: var(--radius-sm);
            font-weight: 700;
            font-size: 0.9rem;
            font-family: 'Outfit', sans-serif;
            cursor: pointer;
            transition: transform 0.25s, box-shadow 0.25s;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px var(--pitch-green-glow);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        @media (max-width: 600px) {
            .form-card {
                padding: 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .form-title {
                font-size: 1.8rem;
            }
        }

        @media (max-width: 400px) {
            .crear-horario-container {
                margin: 16px auto;
                padding: 0 12px;
            }

            .form-card {
                padding: 16px;
            }
        }
    </style>
@endpush

@section('main')
<div class="crear-horario-container">
    @if(session('error'))
    <script>
        Swal.fire({ icon: 'error', title: 'Error', text: "{{ session('error') }}" });
    </script>
    @endif

    @if($errors->any())
    <script>
        Swal.fire({ icon: 'error', title: 'Error', text: "{{ $errors->first('general') ?: 'Error en los datos ingresados.' }}" });
    </script>
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="form-card">
        <h2 class="form-title">
            <i class='bx bx-plus-circle'></i> Crear Horarios
        </h2>
        <p class="form-subtitle">Agrega nuevos horarios disponibles para reserva</p>

        <form action="{{ route('horarios.store') }}" method="POST" id="horariosForm">
            @csrf
            <div class="form-group">
                <label class="form-label">Fecha</label>
                <input type="date" name="fecha" class="form-input" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Hora inicio</label>
                    <select name="hora_inicio" id="horaInicio" class="form-select" required>
                        <option value="">Seleccionar</option>
                        @for($hora = 7; $hora <= 22; $hora++)
                            <option value="{{ sprintf('%02d:00', $hora) }}">
                                {{ sprintf('%02d:00', $hora) }}
                            </option>
                        @endfor
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Hora fin</label>
                    <select name="hora_fin" id="horaFin" class="form-select">
                        <option value="">Seleccionar</option>
                        @for($hora = 8; $hora <= 22; $hora++)
                            <option value="{{ sprintf('%02d:00', $hora) }}">
                                {{ sprintf('%02d:00', $hora) }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-select" required>
                    <option value="Disponible">Disponible</option>
                    <option value="No Disponible">No Disponible</option>
                </select>
            </div>

            <div id="previewSection" class="preview-section" style="display: none;">
                <h3 class="preview-title">Vista previa</h3>
                <ul class="preview-list" id="previewList"></ul>
            </div>

            <button type="submit" class="btn-submit">
                <i class='bx bx-calendar-plus'></i> Crear Horarios
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('horariosForm');
    const previewSection = document.getElementById('previewSection');
    const previewList = document.getElementById('previewList');
    const horaInicioSelect = form.hora_inicio;
    const horaFinSelect = form.hora_fin;
    const fechaInput = form.fecha;

    const today = new Date();
    const formattedToday = today.getFullYear() + '-' +
                          String(today.getMonth() + 1).padStart(2, '0') + '-' +
                          String(today.getDate()).padStart(2, '0');

    fechaInput.min = formattedToday;
    fechaInput.value = formattedToday;

    Swal.fire({
        title: 'Información',
        text: 'Los horarios disponibles son de 7:00 a 22:00',
        icon: 'info',
        confirmButtonText: 'Entendido',
        background: '#12182f',
        color: '#f0f4ff',
        iconColor: '#00f593',
        confirmButtonColor: '#00f593'
    });

    function formatDate(date) {
        return date.getFullYear() + '-' +
               String(date.getMonth() + 1).padStart(2, '0') + '-' +
               String(date.getDate()).padStart(2, '0');
    }

    function getHoraActual() {
        return new Date().getHours();
    }

    function esMismoDia(fecha1, fecha2) {
        return formatDate(fecha1) === formatDate(fecha2);
    }

    function actualizarHorasDisponibles() {
        const fechaSeleccionada = new Date(fechaInput.value + 'T00:00:00');
        const hoy = new Date();
        const esHoy = esMismoDia(fechaSeleccionada, hoy);
        const horaActual = getHoraActual();

        horaInicioSelect.value = '';
        horaFinSelect.value = '';

        Array.from(horaInicioSelect.options).forEach(option => {
            if (option.value === '') {
                option.disabled = false;
                return;
            }
            const horaOpcion = parseInt(option.value);
            option.disabled = esHoy ? horaOpcion <= horaActual : false;
        });

        if (esHoy) {
            const hayHorasDisponibles = Array.from(horaInicioSelect.options)
                .some(option => !option.disabled && option.value !== '');
            if (!hayHorasDisponibles) {
                Swal.fire({
                    title: 'Información',
                    text: 'No hay más horarios disponibles para hoy. Por favor seleccione otra fecha.',
                    icon: 'info',
                    confirmButtonText: 'Entendido',
                    background: '#12182f',
                    color: '#f0f4ff',
                    iconColor: '#00f593',
                    confirmButtonColor: '#00f593'
                });
            }
        }

        actualizarHorasFin();
    }

    function actualizarHorasFin() {
        const horaInicio = horaInicioSelect.value;
        horaFinSelect.value = '';
        Array.from(horaFinSelect.options).forEach(option => {
            if (option.value === '') {
                option.disabled = false;
                return;
            }
            const horaFinNum = parseInt(option.value);
            const horaInicioNum = parseInt(horaInicio);
            option.disabled = !horaInicio || horaFinNum <= horaInicioNum;
        });
    }

    fechaInput.addEventListener('change', function() {
        actualizarHorasDisponibles();
        updatePreview();
    });

    horaInicioSelect.addEventListener('change', function() {
        actualizarHorasFin();
        updatePreview();
    });

    horaFinSelect.addEventListener('change', updatePreview);

    actualizarHorasDisponibles();
});

function generarIntervalos(horaInicio, horaFin) {
    const intervalos = [];
    let inicio = parseInt(horaInicio.split(':')[0]);
    const fin = parseInt(horaFin.split(':')[0]);
    while (inicio < fin) {
        const horaActual = `${String(inicio).padStart(2, '0')}:00`;
        const horaSiguiente = `${String(inicio + 1).padStart(2, '0')}:00`;
        intervalos.push(`${horaActual} - ${horaSiguiente}`);
        inicio++;
    }
    return intervalos;
}

function updatePreview() {
    const previewSection = document.getElementById('previewSection');
    const previewList = document.getElementById('previewList');
    const fecha = document.querySelector('input[name="fecha"]').value;
    const horaInicio = document.querySelector('select[name="hora_inicio"]').value;
    const horaFin = document.querySelector('select[name="hora_fin"]').value;
    const estado = document.querySelector('select[name="estado"]').value;

    previewList.innerHTML = '';

    if (fecha && horaInicio && horaFin) {
        const intervalos = generarIntervalos(horaInicio, horaFin);
        previewSection.style.display = 'block';
        intervalos.forEach(intervalo => {
            const li = document.createElement('li');
            li.className = 'preview-item';
            const partes = fecha.split('-');
            const fechaFormateada = partes[2] + '/' + partes[1] + '/' + partes[0];
            li.innerHTML = `
                <div class="preview-item-content">
                    <span class="preview-date">${fechaFormateada}</span>
                    <span class="preview-time">${intervalo}</span>
                    <span class="preview-status ${estado.toLowerCase().replace(' ', '.')}">${estado}</span>
                </div>
            `;
            previewList.appendChild(li);
        });
    } else {
        previewSection.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('horariosForm');
    form.querySelectorAll('input, select').forEach(element => {
        element.addEventListener('change', updatePreview);
    });
});

document.getElementById('horariosForm').addEventListener('submit', function(event) {
    event.preventDefault();

    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Deseas agregar este horario al sistema?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#00f593',
        cancelButtonColor: 'rgba(255, 255, 255, 0.08)',
        confirmButtonText: 'Sí, agregar',
        cancelButtonText: 'Cancelar',
        background: '#12182f',
        color: '#f0f4ff',
        iconColor: '#ffb400'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        } else {
            Swal.fire({
                title: 'Cancelado',
                text: 'El horario no fue agregado',
                icon: 'info',
                background: '#12182f',
                color: '#f0f4ff',
                confirmButtonColor: '#00f593'
            });
        }
    });
});
</script>
@endpush
