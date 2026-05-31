@extends('layouts.app')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ReservaFutbol - Reserva tu cancha</title>
    <link rel="stylesheet" href="css/stylesWelcome.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

@section('main')
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Operación Exitosa',
        text: "{{ session('success') }}",
        confirmButtonText: 'Aceptar'
    });
</script>
@endif
<main class="content">
    <h1 class="title">
        Que horario le gustaria <span>reservar</span>?
    </h1>
    <p class="description">
        ¡Reserva tu espacio para jugar fútbol con tus amigos! Consulta la
        disponibilidad de nuestra cancha y asegurate de disfrutar de un gran partido.
        <br>
        <br>
        <br>
        Precio de la reserva: $60.000
    </p>


    <div class="illustration">
        <img src="./img/fondo.png" alt="">
    </div>
</main>
</div>
@endsection