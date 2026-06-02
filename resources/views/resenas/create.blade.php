@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calificar Reserva</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .form-page {
            padding: 16px;
            max-width: 500px;
            margin: 0 auto;
        }
        .form-page h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 24px;
        }
        .form-card {
            background: white;
            border-radius: 14px;
            padding: 28px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        }
        .form-card .form-group {
            margin-bottom: 20px;
        }
        .form-card label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
        }
        .form-card textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            resize: vertical;
            font-size: 0.95rem;
        }
        .form-card textarea:focus {
            outline: none;
            border-color: #4facfe;
        }
        .star-rating {
            display: flex;
            gap: 8px;
            font-size: 2rem;
            cursor: pointer;
            direction: rtl;
        }
        .star-rating i {
            color: #d1d5db;
            transition: color 0.2s;
        }
        .star-rating i:hover,
        .star-rating i:hover~i,
        .star-rating input:checked~i {
            color: #f59e0b;
        }
        .star-rating input {
            display: none;
        }
        .btn-submit {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: white;
            border: none;
            padding: 12px 28px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
        }
        .info-box {
            background: #f0f7ff;
            border-radius: 10px;
            padding: 14px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
    </style>
</head>

@section('main')
<div class="form-page">
    <h1><i class='bx bx-star'></i> Calificar reserva</h1>

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
                <span style="color:#ef4444; font-size:0.85rem;">{{ $message }}</span>
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
                        s.style.color = '#f59e0b';
                        found = true;
                    } else {
                        s.style.color = '#d1d5db';
                    }
                });
            });

            star.addEventListener('mouseenter', function() {
                const value = this.dataset.value;
                stars.forEach(s => {
                    if (s.dataset.value <= value) {
                        s.style.color = '#f59e0b';
                    } else {
                        s.style.color = '#d1d5db';
                    }
                });
            });

            star.addEventListener('mouseleave', function() {
                const checked = document.querySelector('#starRating input:checked');
                stars.forEach(s => {
                    if (checked && s.dataset.value <= checked.value) {
                        s.style.color = '#f59e0b';
                    } else {
                        s.style.color = '#d1d5db';
                    }
                });
            });
        });
    });
</script>
@endsection
