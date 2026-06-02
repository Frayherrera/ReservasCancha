@component('mail::message')
# Reserva Cancelada

Hola **{{ $reserva->user->name }}**,

Lamentamos informarte que tu reserva ha sido **cancelada**.

**Detalles de la reserva cancelada:**
- 📅 **Fecha:** {{ \Carbon\Carbon::parse($reserva->horario->fecha)->format('d/m/Y') }}
- ⏰ **Hora:** {{ \Carbon\Carbon::parse($reserva->horario->hora)->format('H:i') }} hrs

Si deseas, puedes realizar una nueva reserva desde nuestro sitio.

@component('mail::button', ['url' => route('horarios.index')])
Ver horarios disponibles
@endcomponent

Disculpa las molestias,<br>
**ReservaFutbol**
@endcomponent
