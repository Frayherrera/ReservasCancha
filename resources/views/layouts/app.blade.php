<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    @stack('styles')
    <title>ReservaFutbol</title>
    <meta name="theme-color" content="#0b0f1c">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="ReservasCancha">

    <link rel="manifest" href="/manifest.json">

    <link rel="apple-touch-icon" href="/pwa/icons/ios/180.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/pwa/icons/ios/152.png">
    <link rel="apple-touch-icon" sizes="167x167" href="/pwa/icons/ios/167.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/pwa/icons/ios/120.png">

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