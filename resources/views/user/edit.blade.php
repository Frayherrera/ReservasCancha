@extends('layouts.app')

@push('styles')
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Configuración de Usuario</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    .user-config-page {
        padding: 28px 32px;
        max-width: 720px;
        margin: 0 auto;
        position: relative;
    }

    .user-config-page::before {
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
        font-size: 2.4rem;
        letter-spacing: 2px;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-header h1 i {
        color: var(--pitch-green);
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

    .config-card {
        position: relative;
        z-index: 1;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: var(--radius);
        padding: 32px;
        backdrop-filter: blur(12px);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--text-primary);
        margin-bottom: 6px;
    }

    .form-control {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: var(--radius-sm);
        background: rgba(255, 255, 255, 0.04);
        color: var(--text-primary);
        font-family: 'Outfit', sans-serif;
        font-size: 0.9rem;
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

    .input-group {
        display: flex;
        align-items: stretch;
    }

    .input-group .form-control {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border-right: none;
    }

    .input-group-text {
        display: flex;
        align-items: center;
        padding: 0 14px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-left: none;
        border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
        color: var(--text-muted);
        cursor: pointer;
        transition: color 0.2s, background 0.2s;
    }

    .input-group-text:hover {
        color: var(--pitch-green);
        background: rgba(0, 245, 147, 0.04);
    }

    .error-text {
        color: #ff4466;
        font-size: 0.82rem;
        display: block;
        margin-top: 4px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 1px solid rgba(255, 255, 255, 0.04);
    }

    .btn-cancel {
        padding: 10px 24px;
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: var(--radius-sm);
        color: var(--text-secondary);
        background: transparent;
        font-weight: 600;
        font-family: 'Outfit', sans-serif;
        font-size: 0.85rem;
        cursor: pointer;
        transition: border-color 0.2s, color 0.2s;
    }

    .btn-cancel:hover {
        border-color: rgba(255, 255, 255, 0.15);
        color: var(--text-primary);
    }

    .btn-save {
        padding: 10px 28px;
        background: var(--pitch-green);
        color: #0b0f1c;
        border: none;
        border-radius: var(--radius-sm);
        font-weight: 700;
        font-family: 'Outfit', sans-serif;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px var(--pitch-green-glow);
    }

    @media (max-width: 768px) {
        .user-config-page {
            padding: 16px;
        }
        .page-header h1 {
            font-size: 1.6rem;
        }
        .config-card {
            padding: 20px;
        }
        .form-actions {
            flex-direction: column;
        }
        .form-actions .btn-cancel,
        .form-actions .btn-save {
            width: 100%;
            text-align: center;
        }
    }
</style>
@endpush

@section('main')
<div class="user-config-page">
    <div class="page-header">
        <div>
            <h1>
                <i class='bx bx-cog'></i>
                Configuración de usuario
            </h1>
            <p class="subtitle">Mis datos personales</p>
            <span class="header-accent"></span>
        </div>
    </div>

    <div class="config-card">
        <form action="{{ route('user.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Nombre completo</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            <span class="input-group-text"><i class='bx bx-edit-alt'></i></span>
                        </div>
                        @error('name') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Correo</label>
                        <div class="input-group">
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            <span class="input-group-text"><i class='bx bx-edit-alt'></i></span>
                        </div>
                        @error('email') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Nueva Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password">
                        @error('password') <span class="error-text">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password_confirmation">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-cancel" onclick="window.history.back()">Cancelar cambios</button>
                <button type="submit" class="btn-save"><i class='bx bx-save'></i> Guardar cambios</button>
            </div>
        </form>
    </div>
</div>
@endsection
