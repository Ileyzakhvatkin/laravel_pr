@php
    $startDate = request()->get('start_date', \Carbon\Carbon::now()->addDay()->format('Y-m-d'));
    $endDate = request()->get('end_date', \Carbon\Carbon::now()->addDays(2)->format('Y-m-d'));
@endphp

<x-app-layout>
    <div class="py-14 px-4 md:px-6 2xl:px-20 2xl:container 2xl:mx-auto">
        <div class="flex flex-wrap mb-12">
            <div class="w-full flex justify-start md:w-1/3 mb-8 md:mb-0">
                <img class="h-full rounded-l-sm" src="/storage/{{ $hotel->poster_url }}" alt="{{ $hotel->name }}">
            </div>
            <div class="w-full md:w-2/3 px-4">
                <div class="text-2xl font-bold">{{ $hotel->name }} - {{ \App\Services\ProjectEnumsService::hotelType()[$hotel->type] }}</div>
                <div class="flex items-center py-4">
{{--                    <x-gmdi-pin-drop-ox-gmdi-pin-drop-o class="w-5 h-5 mr-1 text-blue-700"/>--}}
                    <span class="font-bold pr-2">Адрес:</span> {{ $hotel->address }}
                </div>
                <div>{!! $hotel->description !!}</div>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="text-2xl text-center md:text-start font-bold">Забронировать комнату</div>

            <form method="get" action="{{ url()->current() }}" class="my-6">
                <div class="flex">
                    <div class="flex items-center mr-5">
                        <div class="relative">
                            <input name="start_date" min="{{ date('Y-m-d') }}" value="{{ $startDate }}"
                                   placeholder="Дата заезда" type="date"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                        <span class="mx-4 text-gray-500">по</span>
                        <div class="relative">
                            <input name="end_date" type="date" min="{{ date('Y-m-d') }}" value="{{ $endDate }}"
                                   placeholder="Дата выезда"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        </div>
                    </div>
                    <div>
                        <x-the-button type="submit" class=" h-full w-full">Загрузить номера</x-the-button>
                    </div>
                </div>
                <div>
                    @foreach($errors->all() as $error)
                        <span class="text-red-600">{{$error}}</span>
                    @endforeach
                </div>
            </form>
            @if($startDate && $endDate)
                <div class="flex flex-col w-full">
                    @foreach($rooms as $room)
                        <x-rooms.room-list-item :room="$room" class="mb-4"/>
                    @endforeach
                </div>
            @else
                <div></div>
            @endif
        </div>
        @if(count($reviews) > 0)
            <div class="text-2xl text-center md:text-start font-bold pt-4 pb-2">Отзывы об отеле</div>
            <div>
                @foreach($reviews as $review)
                    <div class="p-4 shadow-md mb-4 bg-gray-50">
                        <div class="pb-2">
                            <span class="font-bold pr-2">{{$review->created_at}}</span>
                            <span class="pr-1">Автор:</span>
                            <span>{{$review->user->name}}</span>
                        </div>
                        <div class="pb-2">
                            <div>{{$review->text}}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
