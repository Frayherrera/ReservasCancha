@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ReservaFutbol</title>
    <link rel="stylesheet" href="/css/stylesWelcome.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>



<style>
    .user-config-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 0 1rem;
    }

    .config-header {
        margin-bottom: 0.5rem;
    }

    .config-subheader {
        color: #6B7280;
        margin-bottom: 2rem;
    }

    .config-card {
        background: white;
        border-radius: 0.75rem;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .form-label {
        font-weight: 500;
        color: #4B5563;
        margin-bottom: 0.5rem;
    }

    .form-control {
        border: 1px solid #E5E7EB;
        border-radius: 0.5rem;
        padding: 0.625rem;
    }

    .input-group-text {
        background-color: #F3F4F6;
        border: 1px solid #E5E7EB;
        color: #6B7280;
        cursor: pointer;
    }

    .input-group-text:hover {
        background-color: #E5E7EB;
    }

    .btn-cancel {
        color: #6B7280;
        background-color: white;
        border: 1px solid #E5E7EB;
        border-radius: 0.5rem;
        padding: 0.625rem 1.25rem;
        transition: all 0.2s;
    }

    .btn-cancel:hover {
        background-color: #F3F4F6;
    }

    .btn-save {
        background-color: #0066FF;
        color: white;
        border: none;
        border-radius: 0.5rem;
        padding: 0.625rem 1.25rem;
        transition: all 0.2s;
    }

    .btn-save:hover {
        background-color: #0052CC;
    }
</style>


@section('main')
<div class="user-config-container">
    <h2 class="config-header">Configuración de usuario</h2>
    <p class="config-subheader">Mis datos personales:</p>

    <form action="{{ route('user.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="config-card">
            <div class="row g-4">
                <div class="col-md-6">
                    <label for="name" class="form-label">Nombre completo</label>
                    <div class="input-group">
                        <input type="text"
                            class="form-control"
                            id="name"
                            name="name"
                            value="{{ old('name', $user->name) }}"
                            required>
                        <span class="input-group-text">
                            <i class='bx bx-edit-alt'></i>
                        </span>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Correo</label>
                    <div class="input-group">
                        <input type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            required>
                        <span class="input-group-text">
                            <i class='bx bx-edit-alt'></i>
                        </span>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label">Nueva Contraseña</label>
                    <input type="password"
                        class="form-control"
                        id="password"
                        name="password">
                </div>

                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                    <input type="password"
                        class="form-control"
                        id="password_confirmation"
                        name="password_confirmation">
                </div>
            </div>

            <div class="d-flex justify-content-end gap-3 mt-4">
                <button type="button" class="btn btn-cancel">
                    Cancelar cambios
                </button>
                <button type="submit" class="btn btn-save">
                    Guardar cambios
                </button>
            </div>
        </div>
    </form>
</div>
@endsection