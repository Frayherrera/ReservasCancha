@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calificaciones y Reseñas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .resenas-page {
            padding: 16px;
            max-width: 800px;
            margin: 0 auto;
        }
        .resenas-page h1 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1a1a2e;
        }
        .resenas-page .subtitle {
            color: #6b7280;
            margin-bottom: 24px;
        }
        .stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 14px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 18px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }
        .stat-card h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            color: #f59e0b;
        }
        .stat-card p {
            margin: 4px 0 0;
            font-size: 0.8rem;
            color: #6b7280;
        }
        .resena-card {
            background: white;
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }
        .resena-card .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }
        .resena-card .user-name {
            font-weight: 600;
            color: #1a1a2e;
        }
        .resena-card .stars {
            color: #f59e0b;
            font-size: 1.1rem;
        }
        .resena-card .comentario {
            color: #4b5563;
            font-size: 0.9rem;
        }
        .resena-card .meta {
            font-size: 0.78rem;
            color: #9ca3af;
            margin-top: 8px;
        }
        .empty {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 14px;
            color: #6b7280;
        }
    </style>
</head>

@section('main')
<div class="resenas-page">
    <h1><i class='bx bx-star'></i> Calificaciones y Reseñas</h1>
    <p class="subtitle">Opiniones de nuestros clientes</p>

    <div class="stats-row">
        <div class="stat-card">
            <h3>{{ number_format($promedio, 1) }}</h3>
            <p>Puntuación promedio</p>
        </div>
        <div class="stat-card">
            <h3>{{ $total }}</h3>
            <p>Total reseñas</p>
        </div>
    </div>

    @if(session('success'))
    <script>
        Swal.fire({ icon: 'success', title: 'Éxito', text: "{{ session('success') }}", confirmButtonText: 'Aceptar' });
    </script>
    @endif

    @if($resenas->isEmpty())
    <div class="empty">
        <i class='bx bx-message-square-x' style="font-size:48px; color:#d1d5db;"></i>
        <p>Aún no hay reseñas</p>
    </div>
    @else
    @foreach($resenas as $resena)
    <div class="resena-card">
        <div class="header">
            <span class="user-name">
                <i class='bx bx-user-circle' style="color:#4facfe;"></i>
                {{ $resena->user->name }}
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
            {{ $resena->created_at->format('d/m/Y') }}
            @if(auth()->id() === $resena->user_id || auth()->user()?->hasRole('administrador'))
            &middot;
            <form action="{{ route('resenas.destroy', $resena) }}" method="POST" style="display:inline" onsubmit="event.preventDefault(); Swal.fire({title:'¿Eliminar?', icon:'warning', showCancelButton:true, confirmButtonColor:'#d33', confirmButtonText:'Sí', cancelButtonText:'Cancelar'}).then(r=>r.isConfirmed&&this.submit())">
                @csrf @method('DELETE')
                <button type="submit" style="background:none; border:none; color:#ef4444; cursor:pointer; font-size:0.78rem;">Eliminar</button>
            </form>
            @endif
        </div>
    </div>
    @endforeach
    <div class="d-flex justify-content-center mt-4">
        {{ $resenas->links('pagination::bootstrap-4') }}
    </div>
    @endif
</div>
@endsection
