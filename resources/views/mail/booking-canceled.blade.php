<p>Отель {{ $booking->room->hotel->name }} отказал в бронирование {{ $booking->room->type }} номера с {{ $booking->started_at }} по {{ $booking->finished_at }}.</p>
<br>
<p>С уважением,<br>{{ config('app.name') }}</p>
