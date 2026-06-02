@component('mail::message')
# ¡Reserva Confirmada!

Hola **{{ $reserva->user->name }}**,

Tu reserva ha sido **confirmada exitosamente**.

**Detalles de la reserva:**
- 📅 **Fecha:** {{ \Carbon\Carbon::parse($reserva->horario->fecha)->format('d/m/Y') }}
- ⏰ **Hora:** {{ \Carbon\Carbon::parse($reserva->horario->hora)->format('H:i') }} hrs
- 💰 **Monto:** ${{ number_format($reserva->precio->valor, 0, ',', '.') }}

@component('mail::button', ['url' => route('home')])
Ver mis reservas
@endcomponent

Gracias por preferirnos,<br>
**ReservaFutbol**
@endcomponent
