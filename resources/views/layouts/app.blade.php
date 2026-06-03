<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    @stack('styles')
    <title>Tu Aplicación</title>


</head>


<body>
    <div class="wrapper"> <!-- Contenedor para el sidebar y el contenido principal -->
        @include('components.sidebar') <!-- Sidebar aquí -->
        <div class="main-content"> <!-- Contenido principal -->
            @yield('main') <!-- Aquí se insertará el contenido de la vista -->
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')

</body>

</html>