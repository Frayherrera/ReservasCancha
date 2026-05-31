<div class="sidebar">
    <div class="logo">
        <img style="margin: 0 auto;width: fit-content;" src="/img/logo.png">
    </div>
    <nav class="nav-menu">

        @if (auth()->check())
        <a href="{{route('home')}}" class="nav-item">Inicio</a>
        <a href="{{route('horarios.index')}}" class="nav-item">Horario cancha</a>
        @if(auth()->user()->hasRole('administrador'))
        <a href="{{route('horarios.create')}}" class="nav-item">Crear horarios</a>
        <a href="{{route('reservas.index')}}" class="nav-item">Reservas</a>

        @endif

        <a href="{{route('user.edit')}}" class="nav-item">Configurar</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <a class="nav-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Cerrar Sesión
        </a>

        @else
        <a href="{{url('/')}}" class="nav-item">Inicio</a>
        <a href="{{route('horarios.index')}}" class="nav-item">Horario cancha</a>
        @endif
    </nav>
</div>