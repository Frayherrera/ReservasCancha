@extends('layouts.app')


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ReservaFutbol - Reserva tu cancha</title>
    <link rel="stylesheet" href="css/stylesWelcome.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


</head>

<body>
    <div class="container">

        @section('main')

        <div style="margin: 0; padding-top: 0;" class="main-content">
            <header class="headerw">
                @if (auth()->check())
                <!-- Mostrar botón de logout -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline">Cerrar Sesión</button>
                </form>
                @else
                <!-- Mostrar botón de iniciar sesión -->
                <button class="btn btn-outline" data-bs-toggle="modal" data-bs-target="#registerModal">Registrarse</button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Iniciar sesión</button>
                @endif

            </header>

            <main class="content">
                <h1 class="title">
                    Que horario le gustaria <span>reservar</span>?
                </h1>
                <p class="description">
                    ¡Reserva tu espacio para jugar fútbol con tus amigos! Consulta la
                    disponibilidad de nuestra cancha y asegurate de disfrutar de un gran partido.
                </p>

                <div class="illustration">
                    <img src="./img/fondo.png" alt="">
                </div>
            </main>
        </div>
    </div>
    <!-- Modal de Login -->
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

    <!-- Modal de Registro -->
    <div class="modal fade " id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
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

    @endsection


</body>

</html>