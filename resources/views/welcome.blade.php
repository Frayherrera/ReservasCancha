@extends('layouts.app')

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ReservaFutbol - Reserva tu cancha</title>
    <link rel="stylesheet" href="css/stylesWelcome.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        .welcome-page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
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
            0%,
            100% {
                transform: translate(0, 0);
            }
            50% {
                transform: translate(-30px, -30px);
            }
        }

        .headerw {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 20px 40px;
            gap: 12px;
        }

        .headerw .btn {
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: transform 0.2s;
        }

        .headerw .btn:hover {
            transform: translateY(-2px);
        }

        .headerw .btn-outline {
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.6);
            color: white;
        }

        .headerw .btn-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: white;
        }

        .headerw .btn-primary {
            background: white;
            border: none;
            color: #667eea;
        }

        .headerw .btn-primary:hover {
            background: #f0f0f0;
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
            color: white;
        }

        .hero-content .logo-img {
            max-width: 80px;
            margin-bottom: 16px;
        }

        .hero-content h1 {
            font-size: 2.4rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 16px;
        }

        .hero-content h1 span {
            background: linear-gradient(90deg, #f093fb, #f5576c);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .hero-content p {
            font-size: 1.05rem;
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 28px;
        }

        .hero-content .cta-btn {
            display: inline-block;
            background: linear-gradient(135deg, #f093fb, #f5576c);
            color: white;
            padding: 14px 36px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            text-decoration: none;
            transition: transform 0.2s, box-shadow 0.2s;
            border: none;
            cursor: pointer;
        }

        .hero-content .cta-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(245, 87, 108, 0.4);
        }

        .hero-carousel {
            flex: 1;
            max-width: 480px;
        }

        .hero-carousel .carousel {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .hero-carousel .carousel img {
            width: 100%;
            height: 320px;
            object-fit: cover;
        }

        .hero-carousel .carousel-caption {
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
            left: 0;
            right: 0;
            bottom: 0;
            padding: 20px;
            text-align: left;
        }

        .features-strip {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            padding: 20px 40px 40px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .feature-item {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 14px;
            padding: 20px;
            text-align: center;
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: transform 0.2s, background 0.2s;
        }

        .feature-item:hover {
            transform: translateY(-4px);
            background: rgba(255, 255, 255, 0.15);
        }

        .feature-item i {
            font-size: 2rem;
            margin-bottom: 8px;
        }

        .feature-item h4 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .feature-item p {
            font-size: 0.8rem;
            opacity: 0.8;
            margin: 0;
        }

        @media (max-width: 768px) {
            .hero {
                flex-direction: column-reverse;
                text-align: center;
                padding: 20px 16px;
            }

            .hero-content h1 {
                font-size: 1.8rem;
            }

            .hero-carousel {
                max-width: 100%;
            }

            .hero-carousel .carousel img {
                height: 220px;
            }

            .headerw {
                padding: 16px;
            }

            .features-strip {
                grid-template-columns: repeat(2, 1fr);
                padding: 16px;
                gap: 10px;
            }

            .feature-item {
                padding: 14px;
            }

            .feature-item i {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 400px) {
            .features-strip {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="welcome-page">
        <header class="headerw">
            @if (auth()->check())
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline">Cerrar Sesión</button>
            </form>
            @else
            <button class="btn btn-outline" data-bs-toggle="modal" data-bs-target="#registerModal">Registrarse</button>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Iniciar sesión</button>
            @endif
        </header>

        <div class="hero">
            <div class="hero-content">
                <img src="./img/logo.png" alt="Logo" class="logo-img">
                <h1>¿Qué horario te gustaría <span>reservar</span>?</h1>
                <p>
                    ¡Reserva tu espacio para jugar fútbol con tus amigos! Consulta la
                    disponibilidad de nuestra cancha y asegurate de disfrutar de un gran partido.
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
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="login-card">
                        <h1 class="welcome-text">¡Hola nos alegra verte!</h1>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group">
                                <label for="email">Correo</label>
                                <input type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email"
                                    autofocus>
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
                                    autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="forgot-password">
                                @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">
                                    ¿Olvidaste tu contraseña?
                                </a>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Iniciar sesión
                            </button>

                            @if (Route::has('register'))
                            <a data-bs-toggle="modal" data-bs-target="#registerModal" class="btn btn-register">
                                Registrarse
                            </a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="register-card">
                        <h1 class="welcome-text">¡Regístrate con nosotros!</h1>
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
                                    autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="reg-email">Correo</label>
                                <input type="email"
                                    id="reg-email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="email">
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
                                    autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="reg-password-confirm">Confirmar Contraseña</label>
                                <input type="password"
                                    id="reg-password-confirm"
                                    name="password_confirmation"
                                    class="form-control"
                                    required
                                    autocomplete="new-password">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Registrarse
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @if ($errors->isNotEmpty())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(old('name'))
            var modalEl = document.getElementById('registerModal');
            @elseif($errors->has('email'))
            var modalEl = document.getElementById('loginModal');
            @endif
            if (modalEl) {
                new bootstrap.Modal(modalEl).show();
            }
        });
    </script>
    @endif

    @section('main')
    @show
</body>

</html>
