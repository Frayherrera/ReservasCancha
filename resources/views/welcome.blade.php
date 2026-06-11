@extends('layouts.app')

@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ReservaFutbol - Reserva tu cancha</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --pitch-green: #00f593;
            --pitch-green-glow: rgba(0, 245, 147, 0.35);
            --spotlight: rgba(255, 200, 50, 0.06);
            --modal-bg: rgba(12, 16, 30, 0.96);
            --modal-border: rgba(255, 255, 255, 0.06);
            --input-bg: rgba(255, 255, 255, 0.04);
            --input-border: rgba(255, 255, 255, 0.08);
            --text-primary: #f0f4ff;
            --text-secondary: rgba(240, 244, 255, 0.55);
            --text-muted: rgba(240, 244, 255, 0.3);
            --radius: 16px;
            --radius-sm: 10px;
        }

        .welcome-page {
            display: flex;
            flex-direction: column;
            background-color: #12182f;
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            padding: 0;
        }

        .welcome-page::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.05) 0%, transparent 60%);
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-30px, -30px); }
        }

        .headerw {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 24px 40px;
            gap: 12px;
        }

        .headerw .btn-header {
            padding: 10px 26px;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 0.85rem;
            font-family: 'Outfit', sans-serif;
            transition: transform 0.25s, box-shadow 0.25s, background 0.25s;
            cursor: pointer;
            border: none;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .headerw .btn-header:hover {
            transform: translateY(-2px);
        }

        .headerw .btn-header-outline {
            background: transparent;
            border: 1.5px solid rgba(255, 255, 255, 0.2);
            color: var(--text-primary);
        }

        .headerw .btn-header-outline:hover {
            border-color: var(--pitch-green);
            color: var(--pitch-green);
            box-shadow: 0 0 20px var(--pitch-green-glow);
        }

        .headerw .btn-header-primary {
            background: var(--pitch-green);
            color: #0b0f1c;
        }

        .headerw .btn-header-primary:hover {
            box-shadow: 0 4px 20px var(--pitch-green-glow);
        }

        .hero {
            position: relative;
            z-index: 1;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            gap: 40px;
        }

        .hero-content {
            flex: 1;
            max-width: 520px;
        }

        .hero-content .logo-img {
            max-width: 72px;
            margin-bottom: 20px;
            filter: drop-shadow(0 0 20px rgba(0, 245, 147, 0.15));
        }

        .hero-content h1 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 3.6rem;
            font-weight: 400;
            letter-spacing: 2px;
            line-height: 1.1;
            margin-bottom: 16px;
            color: var(--text-primary);
            text-transform: uppercase;
        }

        .hero-content h1 span {
            background: linear-gradient(135deg, var(--pitch-green), #00c97a);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .hero-content p {
            font-size: 1rem;
            color: var(--text-secondary);
            line-height: 1.7;
            margin-bottom: 28px;
            font-weight: 300;
            max-width: 440px;
        }

        .hero-content .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--pitch-green);
            color: #0b0f1c;
            padding: 14px 32px;
            border-radius: var(--radius-sm);
            font-weight: 700;
            font-size: 0.9rem;
            font-family: 'Outfit', sans-serif;
            text-decoration: none;
            transition: transform 0.25s, box-shadow 0.25s;
            border: none;
            cursor: pointer;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .hero-content .cta-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 28px var(--pitch-green-glow);
        }

        .hero-carousel {
            flex: 1;
            max-width: 480px;
        }

        .hero-carousel .carousel {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .hero-carousel .carousel img {
            width: 100%;
            height: 320px;
            object-fit: cover;
        }

        .hero-carousel .carousel-caption {
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            left: 0;
            right: 0;
            bottom: 0;
            padding: 20px;
            text-align: left;
        }

        .hero-carousel .carousel-caption h5 {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 1.4rem;
            letter-spacing: 1px;
        }

        .hero-carousel .carousel-caption p {
            font-size: 0.8rem;
            opacity: 0.8;
        }

        .features-strip {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            padding: 0 40px 40px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .feature-item {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border-radius: var(--radius);
            padding: 20px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.06);
            transition: transform 0.3s, border-color 0.3s;
        }

        .feature-item:hover {
            transform: translateY(-4px);
            border-color: rgba(0, 245, 147, 0.15);
        }

        .feature-item i {
            font-size: 1.8rem;
            color: var(--pitch-green);
            margin-bottom: 8px;
        }

        .feature-item h4 {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .feature-item p {
            font-size: 0.78rem;
            color: var(--text-secondary);
            margin: 0;
        }

        /* ===== MODALS ===== */
        .modal-backdrop.show {
            opacity: 0.6 !important;
        }

        .modal-content {
            background: var(--modal-bg) !important;
            border: 1px solid var(--modal-border) !important;
            border-radius: var(--radius) !important;
            box-shadow: 0 32px 80px rgba(0, 0, 0, 0.7) !important;
            backdrop-filter: blur(24px);
            overflow: hidden;
            position: relative;
        }

        /* Spotlight effect */
        .modal-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 280px;
            background: radial-gradient(ellipse 80% 280px at 50% 0%, rgba(255, 200, 50, 0.04) 0%, transparent 70%);
            pointer-events: none;
        }

        .modal-content::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--pitch-green), transparent);
            opacity: 0.3;
        }

        .modal-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.04) !important;
            padding: 18px 24px 0 !important;
            position: relative;
            z-index: 1;
        }

        .modal-header .btn-close {
            filter: invert(1) brightness(200%);
            opacity: 0.4;
            transition: opacity 0.2s, transform 0.2s;
        }

        .modal-header .btn-close:hover {
            opacity: 1;
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 24px 28px 20px !important;
            position: relative;
            z-index: 1;
        }

        .auth-modal-icon {
            display: flex;
            justify-content: center;
            margin-bottom: 16px;
        }

        .auth-modal-icon .icon-circle {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: rgba(0, 245, 147, 0.08);
            border: 1px solid rgba(0, 245, 147, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            color: var(--pitch-green);
        }

        .auth-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2rem;
            letter-spacing: 1.5px;
            color: var(--text-primary);
            text-align: center;
            margin-bottom: 4px;
        }

        .auth-subtitle {
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.85rem;
            font-weight: 300;
            margin-bottom: 24px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .form-control {
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
        }

        .form-control:focus {
            border-color: var(--pitch-green);
            box-shadow: 0 0 0 3px rgba(0, 245, 147, 0.06);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .form-control.is-invalid {
            border-color: #ff4466;
        }

        .invalid-feedback {
            display: block;
            font-size: 0.78rem;
            color: #ff4466;
            margin-top: 4px;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 20px;
        }

        .forgot-password a {
            color: var(--text-muted);
            font-size: 0.8rem;
            text-decoration: none;
            transition: color 0.2s;
        }

        .forgot-password a:hover {
            color: var(--pitch-green);
        }

        .btn-submit {
            width: 100%;
            padding: 13px;
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
            transform: translateY(-1px);
            box-shadow: 0 6px 24px var(--pitch-green-glow);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .auth-switch {
            text-align: center;
            margin-top: 16px;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .auth-switch a {
            color: var(--pitch-green);
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .auth-switch a:hover {
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .hero {
                flex-direction: column-reverse;
                text-align: center;
                padding: 20px 16px;
                gap: 24px;
            }

            .hero-content {
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .hero-content p {
                max-width: 100%;
            }

            .hero-content h1 {
                font-size: 2.4rem;
            }

            .hero-carousel {
                max-width: 100%;
            }

            .hero-carousel .carousel img {
                height: 200px;
            }

            .headerw {
                padding: 16px;
            }

            .features-strip {
                grid-template-columns: repeat(2, 1fr);
                padding: 0 16px 24px;
                gap: 10px;
            }

            .feature-item {
                padding: 14px;
            }

            .feature-item i {
                font-size: 1.4rem;
            }

            .modal-body {
                padding: 20px 20px 16px !important;
            }
        }

        @media (max-width: 400px) {
            .features-strip {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('main')
<div class="welcome-page">
    <header class="headerw">
        @if (auth()->check())
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-header btn-header-outline">Cerrar Sesión</button>
        </form>
        @else
        <button class="btn-header btn-header-outline" data-bs-toggle="modal" data-bs-target="#registerModal">
            <i class='bx bx-user-plus' style="margin-right: 4px;"></i> Registrarse
        </button>
        <button class="btn-header btn-header-primary" data-bs-toggle="modal" data-bs-target="#loginModal">
            <i class='bx bx-log-in' style="margin-right: 4px;"></i> Iniciar sesión
        </button>
        @endif
    </header>

    <div class="hero">
        <div class="hero-content">
            <img src="{{ asset('img/logo.png') . '?v=' . filemtime(public_path('img/logo.png')) }}" alt="Logo" class="logo-img">
            <h1>¿Qué horario te gustaría <span>reservar</span>?</h1>
            <p>
                Reserva tu espacio para jugar fútbol con tus amigos. Consulta la
                disponibilidad de nuestra cancha y asegura tu partido.
            </p>
            <a href="{{ route('horarios.index') }}" class="cta-btn">
                <i class='bx bx-calendar-check'></i> Ver horarios
            </a>
        </div>

        <div class="hero-carousel">
            <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="./img/fondo.png" class="d-block" alt="Cancha de fútbol 1">
                        <div class="carousel-caption">
                            <h5>Cancha profesional</h5>
                            <p>Césped sintético de última generación</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="./img/fondo.png" class="d-block" alt="Cancha de fútbol 2">
                        <div class="carousel-caption">
                            <h5>Iluminación LED</h5>
                            <p>Partidos nocturnos con la mejor visibilidad</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="./img/fondo.png" class="d-block" alt="Cancha de fútbol 3">
                        <div class="carousel-caption">
                            <h5>Vestidores y duchas</h5>
                            <p>Comodidad completa para tu equipo</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
        </div>
    </div>

    <div class="features-strip">
        <div class="feature-item">
            <i class='bx bx-calendar'></i>
            <h4>Reserva online</h4>
            <p>Elige fecha y hora en segundos</p>
        </div>
        <div class="feature-item">
            <i class='bx bx-shield'></i>
            <h4>Pago seguro</h4>
            <p>Múltiples métodos de pago</p>
        </div>
        <div class="feature-item">
            <i class='bx bx-time'></i>
            <h4>Horario flexible</h4>
            <p>Disponible de 7:00 a 22:00</p>
        </div>
        <div class="feature-item">
            <i class='bx bx-group'></i>
            <h4>Para todos</h4>
            <p>Partidos 5vs5, 7vs7 y más</p>
        </div>
    </div>
</div>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="auth-modal-icon">
                    <div class="icon-circle">
                        <i class='bx bx-football'></i>
                    </div>
                </div>
                <h2 class="auth-title">Bienvenido de vuelta</h2>
                <p class="auth-subtitle">Ingresa para reservar tu cancha</p>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <input type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            autofocus
                            placeholder="tucorreo@ejemplo.com">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            id="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="••••••••">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    @if (Route::has('password.request'))
                    <div class="forgot-password">
                        <a href="{{ route('password.request') }}">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                    @endif

                    <button type="submit" class="btn-submit">
                        <i class='bx bx-log-in-circle'></i> Iniciar sesión
                    </button>
                </form>

                <div class="auth-switch">
                    ¿No tienes cuenta? <a data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">Regístrate</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="auth-modal-icon">
                    <div class="icon-circle">
                        <i class='bx bx-user-plus'></i>
                    </div>
                </div>
                <h2 class="auth-title">Únete al partido</h2>
                <p class="auth-subtitle">Crea tu cuenta y empieza a reservar</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <label for="reg-name">Nombre completo</label>
                        <input type="text"
                            id="reg-name"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            required
                            autocomplete="name"
                            autofocus
                            placeholder="Tu nombre">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="reg-email">Correo electrónico</label>
                        <input type="email"
                            id="reg-email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            placeholder="tucorreo@ejemplo.com">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="reg-password">Contraseña</label>
                        <input type="password"
                            id="reg-password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required
                            autocomplete="new-password"
                            placeholder="Mínimo 8 caracteres">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="reg-password-confirm">Confirmar contraseña</label>
                        <input type="password"
                            id="reg-password-confirm"
                            name="password_confirmation"
                            class="form-control"
                            required
                            autocomplete="new-password"
                            placeholder="Repite tu contraseña">
                    </div>

                    <button type="submit" class="btn-submit">
                        <i class='bx bx-check'></i> Crear cuenta
                    </button>
                </form>

                <div class="auth-switch">
                    ¿Ya tienes cuenta? <a data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Inicia sesión</a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if ($errors->isNotEmpty())
            @if(old('name'))
                var modalEl = document.getElementById('registerModal');
            @elseif($errors->has('email'))
                var modalEl = document.getElementById('loginModal');
            @else
                var modalEl = document.getElementById('loginModal');
            @endif
            if (modalEl) {
                new bootstrap.Modal(modalEl).show();
            }
        @endif
    });
</script>
@endpush
@endsection
