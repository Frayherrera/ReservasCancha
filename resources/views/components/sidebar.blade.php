<div class="sidebar">
    <div class="logo">
        <img style="margin: 0 auto;width: fit-content;" src="{{ asset('img/logo.png') . '?v=' . filemtime(public_path('img/logo.png')) }}" alt="Logo">
    </div>
    <nav class="nav-menu">

        @if (auth()->check())
        <a href="{{route('home')}}" class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">Inicio</a>
        <a href="{{route('horarios.index')}}" class="nav-item {{ request()->routeIs('horarios.index') ? 'active' : '' }}">Horario cancha</a>
        @if(auth()->user()->hasRole('administrador'))
        <a href="{{route('admin.dashboard')}}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{route('horarios.create')}}" class="nav-item {{ request()->routeIs('horarios.create') ? 'active' : '' }}">Crear horarios</a>
        <a href="{{route('reservas.index')}}" class="nav-item {{ request()->routeIs('reservas.index') ? 'active' : '' }}">Reservas</a>
        <a href="{{route('admin.finances.index')}}" class="nav-item {{ request()->routeIs('admin.finances.*') ? 'active' : '' }}">Finanzas</a>
        <a href="{{route('admin.pagos.index')}}" class="nav-item {{ request()->routeIs('admin.pagos.*') ? 'active' : '' }}">Pagos</a>
        <a href="{{route('admin.users.index')}}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Usuarios</a>
        @endif
        <a href="{{route('resenas.index')}}" class="nav-item {{ request()->routeIs('resenas.*') ? 'active' : '' }}">Reseñas</a>

        <a href="{{route('user.edit')}}" class="nav-item {{ request()->routeIs('user.edit') ? 'active' : '' }}">Configurar</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <a class="nav-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Cerrar Sesión
        </a>

        @else
        <a href="{{url('/')}}" class="nav-item {{ request()->is('/') || request()->routeIs('home') ? 'active' : '' }}">Inicio</a>
        <a href="{{route('horarios.index')}}" class="nav-item {{ request()->routeIs('horarios.*') ? 'active' : '' }}">Horario cancha</a>
        @endif
    </nav>
</div>
