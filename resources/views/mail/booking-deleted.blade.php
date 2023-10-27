<h2>Отмена бронирования в отеле {{ $booking->room->hotel->name }}</h2>
<br>
<p>Вы отменили Бронирование №{{ $booking->id }} с {{ $booking->started_at }} по {{ $booking->finished_at }}.</p>
<br>
<p>С уважением,<br>{{ config('app.name') }}</p>
