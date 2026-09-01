@extends('layouts.app')

@push('styles')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mis Reseñas</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --pitch-green: #00f593;
        --pitch-green-glow: rgba(0, 245, 147, 0.25);
        --amber: #ffb400;
        --stadium-bg: #0b0f1c;
        --card-bg: rgba(12, 16, 30, 0.88);
        --card-border: rgba(255, 255, 255, 0.05);
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

    .mis-resenas-page {
        padding: 28px 32px;
        max-width: 900px;
        margin: 0 auto;
        position: relative;
    }

    .mis-resenas-page::before {
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
        font-size: 2.6rem;
        letter-spacing: 2px;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-header h1 i {
        color: var(--amber);
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

    .stats-row {
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 14px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius);
        padding: 20px;
        text-align: center;
        backdrop-filter: blur(12px);
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), border-color 0.3s;
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
        background: var(--amber);
        opacity: 0.2;
    }

    .stat-card:hover {
        transform: translateY(-3px);
    }

    .stat-card h3 {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 2rem;
        letter-spacing: 1px;
        margin: 0;
        line-height: 1;
        color: var(--amber);
    }

    .stat-card p {
        margin: 4px 0 0;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-secondary);
    }

    .section-title {
        position: relative;
        z-index: 1;
        font-family: 'Bebas Neue', sans-serif;
        font-size: 1.5rem;
        letter-spacing: 1.5px;
        color: var(--text-primary);
        margin: 0 0 16px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: var(--pitch-green);
    }

    .card {
        position: relative;
        z-index: 1;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius);
        backdrop-filter: blur(12px);
    }

    .pending-card {
        padding: 18px 20px;
        margin-bottom: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1), border-color 0.25s;
    }

    .pending-card:hover {
        transform: translateY(-2px);
        border-color: rgba(0, 245, 147, 0.2);
    }

    .pending-info {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
    }

    .pending-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: var(--radius-sm);
        background: rgba(0, 245, 147, 0.1);
        color: var(--pitch-green);
        font-size: 1.4rem;
        flex-shrink: 0;
    }

    .pending-id {
        font-weight: 700;
        color: var(--text-primary);
        font-size: 0.95rem;
    }

    .pending-date {
        color: var(--text-secondary);
        font-size: 0.82rem;
    }

    .pending-date i {
        color: var(--text-muted);
        margin-right: 4px;
    }

    .btn-rate {
        background: var(--pitch-green);
        color: #0b0f1c;
        border: none;
        padding: 10px 22px;
        border-radius: var(--radius-sm);
        font-weight: 700;
        font-family: 'Outfit', sans-serif;
        font-size: 0.82rem;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-rate:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px var(--pitch-green-glow);
        color: #0b0f1c;
    }

    .resena-card {
        padding: 20px;
        margin-bottom: 12px;
    }

    .resena-card .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
        flex-wrap: wrap;
        gap: 8px;
    }

    .resena-card .reserva-ref {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.9rem;
    }

    .resena-card .reserva-ref i {
        color: var(--pitch-green);
        margin-right: 6px;
    }

    .resena-card .stars {
        color: var(--amber);
        font-size: 1.05rem;
    }

    .resena-card .comentario {
        color: var(--text-secondary);
        font-size: 0.88rem;
        line-height: 1.6;
    }

    .resena-card .meta {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px solid rgba(255, 255, 255, 0.04);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
    }

    .resena-card .meta form button {
        background: none;
        border: none;
        color: var(--danger);
        cursor: pointer;
        font-size: 0.75rem;
        font-family: 'Outfit', sans-serif;
        transition: opacity 0.2s;
    }

    .resena-card .meta form button:hover {
        opacity: 0.7;
    }

    .empty {
        position: relative;
        z-index: 1;
        text-align: center;
        padding: 48px 20px;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius);
        backdrop-filter: blur(12px);
        margin-bottom: 12px;
    }

    .empty i {
        font-size: 44px;
        color: var(--text-muted);
        margin-bottom: 12px;
    }

    .empty p {
        color: var(--text-secondary);
        margin-bottom: 16px;
    }

    .empty .btn-rate {
        margin: 0 auto;
    }

    @media (max-width: 768px) {
        .mis-resenas-page {
            padding: 16px;
        }

        .page-header h1 {
            font-size: 1.8rem;
        }

        .pending-card {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-rate {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('main')
<div class="mis-resenas-page">
    <div class="page-header">
        <div>
            <h1>
                <i class='bx bx-star'></i>
                Mis reseñas
            </h1>
            <p class="subtitle">Califica tus reservas y consulta tus opiniones</p>
            <span class="header-accent"></span>
        </div>
    </div>

    @if(session('success'))
    <script>
        Swal.fire({ icon: 'success', title: 'Éxito', text: "{{ session('success') }}", confirmButtonText: 'Aceptar', background: '#12182f', color: '#f0f4ff', iconColor: '#00f593', confirmButtonColor: '#00f593' });
    </script>
    @endif

    @if(session('error'))
    <script>
        Swal.fire({ icon: 'error', title: 'Error', text: "{{ session('error') }}", confirmButtonText: 'Aceptar', background: '#12182f', color: '#f0f4ff', iconColor: '#ff4466', confirmButtonColor: '#ff4466' });
    </script>
    @endif

    <div class="stats-row">
        <div class="stat-card">
            <h3>{{ number_format((float) $promedioPersonal, 1) }}</h3>
            <p>Mi puntuación promedio</p>
        </div>
        <div class="stat-card">
            <h3>{{ $misResenas->count() }}</h3>
            <p>Reseñas publicadas</p>
        </div>
        <div class="stat-card">
            <h3>{{ $pendientes->count() }}</h3>
            <p>Por calificar</p>
        </div>
    </div>

    <h2 class="section-title">
        <i class='bx bx-pencil'></i> Reservas por calificar
    </h2>

    @if($pendientes->isEmpty())
    <div class="empty">
        <i class='bx bx-happy-beaming'></i>
        <p>No tienes reservas pendientes de calificar.</p>
        <a href="{{ route('horarios.index') }}" class="btn-rate">
            <i class='bx bx-calendar-check'></i> Reservar ahora
        </a>
    </div>
    @else
        @foreach($pendientes as $reserva)
        <div class="card pending-card">
            <div class="pending-info">
                <span class="pending-badge"><i class='bx bx-calendar-check'></i></span>
                <div>
                    <span class="pending-id">Reserva #{{ $reserva->id }}</span>
                    <div class="pending-date">
                        <i class='bx bx-calendar'></i>
                        {{ \Carbon\Carbon::parse($reserva->horario->fecha)->format('d/m/Y') }}
                        a las {{ \Carbon\Carbon::parse($reserva->horario->hora)->format('H:i') }} hrs
                    </div>
                </div>
            </div>
            <a href="{{ route('resenas.create', $reserva) }}" class="btn-rate">
                <i class='bx bx-star'></i> Calificar
            </a>
        </div>
        @endforeach
    @endif

    <h2 class="section-title" style="margin-top: 32px;">
        <i class='bx bx-book-content'></i> Mis reseñas publicadas
    </h2>

    @if($misResenas->isEmpty())
    <div class="empty">
        <i class='bx bx-message-square-x'></i>
        <p>Aún no has publicado ninguna reseña.</p>
    </div>
    @else
        @foreach($misResenas as $resena)
        <div class="card resena-card">
            <div class="header">
                <span class="reserva-ref">
                    <i class='bx bx-check-double'></i>
                    Reserva #{{ $resena->reserva_id }}
                    &middot;
                    {{ \Carbon\Carbon::parse($resena->reserva->horario->fecha)->format('d/m/Y') }}
                </span>
                <span class="stars">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $resena->puntuacion)
                        <i class='bx bxs-star'></i>
                        @else
                        <i class='bx bx-star'></i>
                        @endif
                    @endfor
                </span>
            </div>
            @if($resena->comentario)
            <div class="comentario">{{ $resena->comentario }}</div>
            @endif
            <div class="meta">
                <span>{{ $resena->created_at->format('d/m/Y') }}</span>
                <form action="{{ route('resenas.destroy', $resena) }}" method="POST" onsubmit="event.preventDefault(); Swal.fire({title:'¿Eliminar reseña?', text:'Esta acción no se puede deshacer.', icon:'warning', showCancelButton:true, confirmButtonColor:'#ff4466', cancelButtonColor:'rgba(255,255,255,0.08)', confirmButtonText:'Sí, eliminar', cancelButtonText:'Cancelar', background:'#12182f', color:'#f0f4ff', iconColor:'#ffb400'}).then(r=>r.isConfirmed&&this.submit())">
                    @csrf @method('DELETE')
                    <button type="submit"><i class='bx bx-trash'></i> Eliminar</button>
                </form>
            </div>
        </div>
        @endforeach
    @endif
</div>
@endsection