@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ReservaFutbol - Reserva tu cancha</title>
    <link rel="stylesheet" href="/css/stylesWelcome.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/stylescreate.css">
</head>
@section('main')
<div class="crear-horario-container">
    <h2 class="form-title">Crear Horarios</h2>

    <form action="{{ route('horarios.store') }}" method="POST" id="horariosForm">
        @csrf
        <div class="form-group">
            <label class="form-label">Fecha</label>
            <input type="date" name="fecha" class="form-input" required>
        </div>
    
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Hora Inicio</label>
                <select name="hora_inicio" id="horaInicio" class="form-select" required>
                    <option value="">Seleccione hora inicio</option>
                    @for($hora = 7; $hora <= 22; $hora++)
                        <option value="{{ sprintf('%02d:00', $hora) }}">
                            {{ sprintf('%02d:00', $hora) }}
                        </option>
                    @endfor
                </select>
            </div>
    
            <div class="form-group">
                <label class="form-label">Hora Fin</label>
                <select name="hora_fin" id="horaFin" class="form-select">
                    <option value="">Seleccione hora fin</option>
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
                <option value="Ocupado">Ocupado</option>
            </select>
        </div>
    
        <div id="previewSection" class="preview-section" style="display: none;">
            <h3 class="preview-title">Vista previa de horarios a crear:</h3>
            <ul class="preview-list" id="previewList"></ul>
        </div>
    
        <button type="submit" class="btn-submit">Crear Horarios</button>
    </form>
    
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('horariosForm');
    const previewSection = document.getElementById('previewSection');
    const previewList = document.getElementById('previewList');
    const horaInicioSelect = form.hora_inicio;
    const horaFinSelect = form.hora_fin;
    const fechaInput = form.fecha;

    // Asegurarse de que la fecha actual esté disponible
    const today = new Date();
    const formattedToday = today.getFullYear() + '-' + 
                          String(today.getMonth() + 1).padStart(2, '0') + '-' + 
                          String(today.getDate()).padStart(2, '0');
    
    fechaInput.min = formattedToday;
    fechaInput.value = formattedToday;

    // Mostrar alerta informativa al cargar la página
    Swal.fire({
        title: 'Información',
        text: 'Los horarios disponibles son de 7:00 a 22:00',
        icon: 'info',
        confirmButtonText: 'Entendido'
    });

    // Función para formatear fecha en YYYY-MM-DD
    function formatDate(date) {
        return date.getFullYear() + '-' + 
               String(date.getMonth() + 1).padStart(2, '0') + '-' + 
               String(date.getDate()).padStart(2, '0');
    }

    // Función para obtener la hora actual
    function getHoraActual() {
        return new Date().getHours();
    }

    // Función para comparar si dos fechas son el mismo día
    function esMismoDia(fecha1, fecha2) {
        return formatDate(fecha1) === formatDate(fecha2);
    }

    // Función para actualizar las horas disponibles según la fecha
    function actualizarHorasDisponibles() {
        const fechaSeleccionada = new Date(fechaInput.value + 'T00:00:00');
        const hoy = new Date();
        const esHoy = esMismoDia(fechaSeleccionada, hoy);
        const horaActual = getHoraActual();
        
        // Resetear valores
        horaInicioSelect.value = '';
        horaFinSelect.value = '';
        
        Array.from(horaInicioSelect.options).forEach(option => {
            if (option.value === '') {
                option.disabled = false;
                return;
            }

            const horaOpcion = parseInt(option.value);
            
            if (esHoy) {
                // Si es hoy, solo deshabilitar horas que ya pasaron
                option.disabled = horaOpcion <= horaActual;
            } else {
                // Si es fecha futura, habilitar todas las horas
                option.disabled = false;
            }
        });

        // Si es hoy y no hay opciones habilitadas disponibles, mostrar mensaje
        if (esHoy) {
            const hayHorasDisponibles = Array.from(horaInicioSelect.options)
                .some(option => !option.disabled && option.value !== '');
            
            if (!hayHorasDisponibles) {
                Swal.fire({
                    title: 'Información',
                    text: 'No hay más horarios disponibles para hoy. Por favor seleccione otra fecha.',
                    icon: 'info',
                    confirmButtonText: 'Entendido'
                });
            }
        }

        actualizarHorasFin();
    }

    // Función para actualizar las opciones de hora fin
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

    // Event listeners
    fechaInput.addEventListener('change', function() {
        actualizarHorasDisponibles();
        updatePreview();
    });

    horaInicioSelect.addEventListener('change', function() {
        actualizarHorasFin();
        updatePreview();
    });

    horaFinSelect.addEventListener('change', updatePreview);

    // Inicializar los campos
    actualizarHorasDisponibles();
});
// Función para generar intervalos de tiempo
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

// Función para actualizar la vista previa
function updatePreview() {
    const previewSection = document.getElementById('previewSection');
    const previewList = document.getElementById('previewList');
    const fecha = document.querySelector('input[name="fecha"]').value;
    const horaInicio = document.querySelector('select[name="hora_inicio"]').value;
    const horaFin = document.querySelector('select[name="hora_fin"]').value;
    const estado = document.querySelector('select[name="estado"]').value;

    // Limpiar la lista previa
    previewList.innerHTML = '';

    // Verificar si tenemos todos los datos necesarios
    if (fecha && horaInicio && horaFin) {
        const intervalos = generarIntervalos(horaInicio, horaFin);
        
        // Mostrar la sección de vista previa
        previewSection.style.display = 'block';
        
        // Crear elementos de la lista para cada intervalo
        intervalos.forEach(intervalo => {
            const li = document.createElement('li');
            li.className = 'preview-item';
            
            // Formatear la fecha para mostrar
            const fechaFormateada = new Date(fecha).toLocaleDateString('es-ES', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            
            li.innerHTML = `
                <div class="preview-item-content">
                    <span class="preview-date">${fechaFormateada}</span>
                    <span class="preview-time">${intervalo}</span>
                    <span class="preview-status ${estado.toLowerCase()}">${estado}</span>
                </div>
            `;
            
            previewList.appendChild(li);
        });
    } else {
        // Ocultar la sección de vista previa si faltan datos
        previewSection.style.display = 'none';
    }
}

// Agregar los event listeners necesarios
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('horariosForm');
    
    // Actualizar la vista previa cuando cambie cualquier campo
    form.querySelectorAll('input, select').forEach(element => {
        element.addEventListener('change', updatePreview);
    });
});
document.getElementById('horariosForm').addEventListener('submit', function (event) {
        event.preventDefault(); // Evita que el formulario se envíe de inmediato

        Swal.fire({
            title: '¿Estás seguro?',
            text: '¿Deseas agregar este horario al sistema?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, agregar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Si confirma, envía el formulario
                this.submit();
            } else {
                // Opcional: mensaje si se cancela la acción
                Swal.fire('Cancelado', 'El horario no fue agregado', 'info');
            }
        });
    });
</script>
<style>
    .preview-section {
    margin-top: 2rem;
    padding: 1rem;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
}

.preview-title {
    font-size: 1.2rem;
    color: #333;
    margin-bottom: 1rem;
}

.preview-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.preview-item {
    background-color: white;
    border: 1px solid #eee;
    border-radius: 6px;
    margin-bottom: 0.5rem;
    padding: 0.75rem;
}

.preview-item-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
}

.preview-date {
    font-weight: 500;
    color: #444;
}

.preview-time {
    color: #666;
}

.preview-status {
    padding: 0.25rem 0.75rem;
    border-radius: 999px;
    font-size: 0.875rem;
    font-weight: 500;
}

.preview-status.disponible {
    background-color: #dcfce7;
    color: #166534;
}

.preview-status.ocupado {
    background-color: #fee2e2;
    color: #991b1b;
}
</style>
@endsection