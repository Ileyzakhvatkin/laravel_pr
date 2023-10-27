<div class="flex flex-col justify-start items-start w-full space-y-4 md:space-y-6 xl:space-y-8">
    <div class="flex flex-col justify-start items-start bg-gray-50 px-4 py-4 md:px-6 xl:px-8 w-full">
        <div class="flex justify-between w-full py-2 border-b border-gray-200">
            <div class="w-full">
                <p class="text-lg md:text-xl font-semibold leading-6 xl:leading-5 text-gray-800">Бронирование
                    #{{ $booking->id }} ({{ \App\Services\ProjectEnumsService::bookingStatus()[$booking->status] }})</p>
                <p class="text-base font-medium leading-6 text-gray-600 ">{{ $booking->created_at->format('d-m-y H:i') }}</p>
            </div>
            @if($booking->status === 'created' && auth()->user()->role->name === 'user')
                <form method="post" action="{{ route('bookings.deleted', ['booking' => $booking]) }}" class="flex px-4">
                    @method('DELETE')
                    @csrf
                    <x-the-button type="submit" class=" h-full w-full">Отменить</x-the-button>
                </form>
            @endif
            @if($booking->status === 'created' && auth()->user()->role->name === 'manager')
                <form method="post" action="{{ route('bookings.updated', ['booking' => $booking]) }}" class="flex px-4">
                    @method('PATCH')
                    @csrf
                    <input type="hidden" name="status" value="approved" />
                    <x-the-button type="submit" class=" h-full w-full">Подтвердить</x-the-button>
                </form>
            @endif
            @if($booking->status === 'approved' && auth()->user()->role->name === 'manager')
                <form method="post" action="{{ route('bookings.updated', ['booking' => $booking]) }}" class="flex px-4">
                    @method('PATCH')
                    @csrf
                    <input type="hidden" name="status" value="checkin" />
                    <x-the-button type="submit" class=" h-full w-full">Заселяется</x-the-button>
                </form>
            @endif
            @if($booking->status === 'checkin' && auth()->user()->role->name === 'manager')
                <form method="post" action="{{ route('bookings.updated', ['booking' => $booking]) }}" class="flex px-4">
                    @method('PATCH')
                    @csrf
                    <input type="hidden" name="status" value="used" />
                    <x-the-button type="submit" class=" h-full w-full">Номер сдан</x-the-button>
                </form>
            @endif
            @if($showLink ?? false)
            <div class="flex">
                <x-link-button href="{{ route('bookings.show', ['booking' => $booking]) }}">Подробнее</x-link-button>
            </div>
            @endif
        </div>
        <div class="mt-4 md:mt-6 flex flex-col md:flex-row justify-start items-start md:space-x-6 w-full">
            <div class="pb-4 w-full md:w-2/5">
                <img class="w-full block" src="/storage/{{ $booking->room->poster_url }}" alt="image"/>
            </div>
            <div
                class="md:flex-row flex-col flex justify-between items-start w-full md:w-3/5 pb-8 space-y-4 md:space-y-0">
                <div class="w-full flex flex-col justify-start items-start space-y-8">
                    <h3 class="text-xl xl:text-2xl font-semibold leading-6 text-gray-800">
                        {{ \App\Services\ProjectEnumsService::roomType()[$booking->room->type] }} номер в отеле {{ $booking->room->hotel->name }} ({{ \App\Services\ProjectEnumsService::hotelType()[$booking->room->hotel->type] }})
                    </h3>
                    <div class="flex justify-start items-start flex-col space-y-2">
                        <p class="text-sm leading-none text-gray-800"><span>Даты: </span>
                            {{ \Carbon\Carbon::parse($booking->started_at)->format('d.m.Y') }}
                            по
                            {{ \Carbon\Carbon::parse($booking->finished_at)->format('d.m.Y') }}</p>
                        <p class="text-sm leading-none text-gray-800"><span>Кол-во ночей: </span> {{ $booking->days }}
                        </p>
                    </div>
                </div>
                <div class="flex justify-end space-x-8 items-end w-full">
                    <p class="text-base xl:text-lg font-semibold leading-6 text-gray-800">
                        Стоимость: {{ number_format($booking->price, 0, '.', ' ') }} руб</p>
                </div>
            </div>
        </div>
        @if($booking->status === 'reviewed' && isset($booking->review))
            <p class="py-4 text-lg md:text-xl font-semibold leading-6 xl:leading-5 text-gray-800 border-b mb-4">Отзывы клиента</p>
            <div class="p-4 w-full shadow-md mb-4 bg-gray-50">
                <div class="pb-2">
                    <span class="font-bold pr-2">{{ $booking->review->created_at }}</span>
                </div>
                <div class="pb-2">
                    <div>{{ $booking->review->text }}</div>
                </div>
            </div>
        @elseif($booking->status === 'used' && auth()->user()->role->name === 'user')
            <form method="post" action="{{ route('review.store') }}" class="pb-4 w-full">
                @csrf
                <label for="reviewText">
                    <div class="text-1xl text-center md:text-start font-bold pt-4 pb-2">Пожалуйста, напишите Ваш отзыв о нашем отеле!</div>
                    <div>
                        <input class="mb-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2"
                               name="reviewText" type="input" value="">
                    </div>
                </label>
                <input type="hidden" name="bookingId" value="{{ $booking->id }}">
                <div>
                    @foreach($errors->all() as $error)
                        <span class="text-red-600">{{$error}}</span>
                    @endforeach
                </div>
                <x-the-button type="submit" class="">Отправить</x-the-button>
            </form>
        @else
            <div></div>
        @endif
    </div>
</div>
