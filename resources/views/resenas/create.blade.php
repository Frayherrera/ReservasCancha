@extends('layouts.app')

@push('styles')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Calificar Reserva</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
        --radius: 16px;
        --radius-sm: 10px;
    }

    body {
        font-family: 'Outfit', sans-serif;
        background: var(--stadium-bg) !important;
    }

    .form-page {
        padding: 28px 32px;
        max-width: 560px;
        margin: 0 auto;
        position: relative;
    }

    .form-page::before {
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
        font-size: 2.2rem;
        letter-spacing: 2px;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-header h1 i {
        color: var(--amber);
        font-size: 1.8rem;
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

    .form-card {
        position: relative;
        z-index: 1;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius);
        padding: 28px;
        backdrop-filter: blur(12px);
    }

    .info-box {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: var(--radius-sm);
        padding: 14px 18px;
        margin-bottom: 20px;
        font-size: 0.88rem;
        color: var(--text-secondary);
    }

    .info-box strong {
        color: var(--pitch-green);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--text-primary);
        font-size: 0.9rem;
    }

    .form-group textarea {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: var(--radius-sm);
        background: rgba(255, 255, 255, 0.04);
        color: var(--text-primary);
        font-family: 'Outfit', sans-serif;
        font-size: 0.9rem;
        resize: vertical;
        transition: border-color 0.25s, box-shadow 0.25s;
        outline: none;
    }

    .form-group textarea:focus {
        border-color: var(--pitch-green);
        box-shadow: 0 0 0 3px rgba(0, 245, 147, 0.06);
    }

    .form-group textarea::placeholder {
        color: var(--text-muted);
    }

    .star-rating {
        display: flex;
        gap: 6px;
        font-size: 2rem;
        cursor: pointer;
        direction: rtl;
    }

    .star-rating i {
        color: var(--text-muted);
        transition: color 0.2s;
    }

    .star-rating i:hover,
    .star-rating i:hover ~ i,
    .star-rating input:checked ~ i {
        color: var(--amber);
    }

    .star-rating input {
        display: none;
    }

    .btn-submit {
        background: var(--pitch-green);
        color: #0b0f1c;
        border: none;
        padding: 12px 28px;
        border-radius: var(--radius-sm);
        font-weight: 700;
        font-family: 'Outfit', sans-serif;
        cursor: pointer;
        width: 100%;
        font-size: 0.95rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px var(--pitch-green-glow);
    }

    .error-text {
        color: #ff4466;
        font-size: 0.85rem;
        display: block;
        margin-top: 4px;
    }

    @media (max-width: 768px) {
        .form-page {
            padding: 16px;
        }
        .page-header h1 {
            font-size: 1.6rem;
        }
    }
</style>
@endpush

@section('main')
<div class="form-page">
    <div class="page-header">
        <div>
            <h1>
                <i class='bx bx-star'></i>
                Calificar reserva
            </h1>
            <span class="header-accent"></span>
        </div>
    </div>

    <div class="form-card">
        <div class="info-box">
            <strong>Reserva #{{ $reserva->id }}</strong><br>
            {{ \Carbon\Carbon::parse($reserva->horario->fecha)->format('d/m/Y') }}
            a las {{ \Carbon\Carbon::parse($reserva->horario->hora)->format('H:i') }} hrs
        </div>

        <form method="POST" action="{{ route('resenas.store') }}">
            @csrf
            <input type="hidden" name="reserva_id" value="{{ $reserva->id }}">

            <div class="form-group">
                <label>Puntuación</label>
                <div class="star-rating" id="starRating">
                    <input type="radio" name="puntuacion" value="5" id="star5">
                    <i class='bx bx-star' data-value="5"></i>
                    <input type="radio" name="puntuacion" value="4" id="star4">
                    <i class='bx bx-star' data-value="4"></i>
                    <input type="radio" name="puntuacion" value="3" id="star3">
                    <i class='bx bx-star' data-value="3"></i>
                    <input type="radio" name="puntuacion" value="2" id="star2">
                    <i class='bx bx-star' data-value="2"></i>
                    <input type="radio" name="puntuacion" value="1" id="star1">
                    <i class='bx bx-star' data-value="1"></i>
                </div>
                @error('puntuacion')
                <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="comentario">Comentario (opcional)</label>
                <textarea name="comentario" id="comentario" rows="4" placeholder="Cuéntanos tu experiencia...">{{ old('comentario') }}</textarea>
            </div>

            <button type="submit" class="btn-submit">
                <i class='bx bx-send'></i> Enviar calificación
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('#starRating i');
    const inputs = document.querySelectorAll('#starRating input');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const value = this.dataset.value;
            document.getElementById('star' + value).checked = true;

            stars.forEach(s => s.className = 'bx bx-star');
            let found = false;
            stars.forEach(s => {
                if (s.dataset.value === value || found) {
                    s.className = 'bx bxs-star';
                    s.style.color = '#ffb400';
                    found = true;
                } else {
                    s.style.color = 'rgba(240, 244, 255, 0.3)';
                }
            });
        });

        star.addEventListener('mouseenter', function() {
            const value = this.dataset.value;
            stars.forEach(s => {
                if (s.dataset.value <= value) {
                    s.style.color = '#ffb400';
                } else {
                    s.style.color = 'rgba(240, 244, 255, 0.3)';
                }
            });
        });

        star.addEventListener('mouseleave', function() {
            const checked = document.querySelector('#starRating input:checked');
            stars.forEach(s => {
                if (checked && s.dataset.value <= checked.value) {
                    s.style.color = '#ffb400';
                } else {
                    s.style.color = 'rgba(240, 244, 255, 0.3)';
                }
            });
        });
    });
});
</script>
@endpush
@endsection
