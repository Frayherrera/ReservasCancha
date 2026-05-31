<!-- resources/views/components/header.blade.php -->

<div class="header">
    <h1 class="title">Nombre de la Aplicación</h1>
    <div class="user-info">
        <span class="username">{{-- {{ Auth::user()->name }} --}}Luis FM</span> <!-- Descomenta esto -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Cerrar sesión</button>
        </form>
    </div>
</div>