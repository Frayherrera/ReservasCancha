@component('mail::message')
# Recordatorio: ¡Tu partido es mañana!

Hola **{{ $reserva->user->name }}**,

Te recordamos que tienes un partido programado para **mañana**.

**Detalles del partido:**
- 📅 **Fecha:** {{ \Carbon\Carbon::parse($reserva->horario->fecha)->format('d/m/Y') }}
- ⏰ **Hora:** {{ \Carbon\Carbon::parse($reserva->horario->hora)->format('H:i') }} hrs

¡No olvides llevar tu equipo y muchas ganas de jugar!

@component('mail::button', ['url' => route('home')])
Ver mis reservas
@endcomponent

¡Nos vemos en la cancha!<br>
**ReservaFutbol**
@endcomponent
