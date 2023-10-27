<x-app-layout>
    <div class="py-14 px-4 md:px-6 2xl:px-20 2xl:container 2xl:mx-auto">

        <form method="get" action="{{ url()->current() }}" class="flex flex-col md:flex-row pb-4">
            <div class="pr-4">
                <div class="relative pr-4">
                    <div class="mb-1">Удобства</div>
                    <select class="py-2.5 mt-1 h-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2"
                            size="6" multiple name="hotelFacilities[]">
                        @foreach(App\Services\ProjectEnumsService::facilities() as $hotel_facility)
                            <option
                                @if(request()->has('hotelFacilities') && in_array($hotel_facility, request()->get('hotelFacilities'))) selected @endif
                                value="{{ $hotel_facility }}"
                            >{{ $hotel_facility }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="relative pr-4">
                    <div class="pt-2">Сортировать по</div>
                    <select class="py-2.5 mt-1 h-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2"
                            size="1" name="sortType">
                        <option @if(!request()->has('sortType')) selected @endif disabled>Выбрать</option>
                        <option value="sortPriceASC"
                                @if(request()->has('sortType') && request()->get('sortType') === 'sortPriceASC') selected @endif
                        >По возрастанию цены</option>
                        <option value="sortPriceDEST"
                                @if(request()->has('sortType') && request()->get('sortType') === 'sortPriceDEST') selected @endif
                        >По убыванию цены</option>
                    </select>
                </div>
            </div>
            <div>
                <div class="flex pb-2">
                    <div class="relative pr-4">
                        <div class="mb-1">Класс отеля</div>
                        <div class="flex flex-wrap py-1">
                            @foreach(App\Services\ProjectEnumsService::hotelType() as $key => $hotel_type)
                                <div class="flex pr-4 items-top">
                                    <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block"
                                           type="checkbox" name="{{ $key }}" value="yes"
                                           @if(isset($hotelTypes) && array_key_exists($key, $hotelTypes)) checked @endif>
                                    <span class="text-gray-900 text-sm px-1">{{ $hotel_type }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="flex pb-2">
                    <div class="relative pr-4">
                        <div class="mb-1">В отеле есть номера</div>
                        <div class="flex flex-wrap py-1">
                            @foreach(App\Services\ProjectEnumsService::roomType() as $key => $room_type)
                                <div class="flex pr-4 items-top">
                                    <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block"
                                           type="checkbox" name="{{ $key }}" value="yes"
                                           @if(isset($roomTypes) && array_key_exists($key, $roomTypes)) checked @endif>
                                    <span class="text-gray-900 text-sm px-1">{{ $room_type }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="flex items-end flex-wrap pb-2">
                    <div class="relative pr-4">
                        <div class="mb-1">Стоимость</div>
                        <div class="flex items-center">
                            <span class="mx-4 text-gray-500">от</span>
                            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2"
                                   name="minPrice" value="{{ request()->get('minPrice') }}" type="number">
                            <span class="mx-4 text-gray-500">до</span>
                            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2"
                                   name="maxPrice" value="{{ request()->get('maxPrice') }}" type="number">
                        </div>
                    </div>
                    <div class="relative pr-4">
                        <div class="mb-1">Найти по адресу или названию</div>
                        <div>
                            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2"
                                   name="hotelSearch" type="input" value="{{ request()->get('hotelSearch') }}">
                        </div>
                    </div>
                </div>
                <div class="relative pr-4 pt-4">
                    <x-the-button type="submit" class="mb-2">Применить</x-the-button>
                    <x-the-button type="reset" class="mb-2" onclick="document.location='/hotels/'">Сбросить</x-the-button>
                </div>
            </div>

        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 pt-4">
            @foreach($hotels as $hotel)
                <x-hotels.hotel-card :hotel="$hotel"></x-hotels.hotel-card>
            @endforeach
        </div>
        <div class="py-4">
            {{ $hotels->onEachSide(2)->links() }}
        </div>
    </div>
</x-app-layout>
