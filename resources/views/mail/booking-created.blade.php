<h2>Бронирование номера в отеле {{ $booking->room->hotel->name }}</h2>
<br>
<p>Вы забронировали {{ $booking->room->type }} номер с {{ $booking->started_at }} по {{ $booking->finished_at }}.</p>
<br>
<p>С уважением,<br>{{ config('app.name') }}</p>
