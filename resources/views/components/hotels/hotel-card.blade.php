<div class="bg-white rounded shadow-md flex card flex-col md:flex-row text-grey-darkest">
    <img class="h-full w-full md:w-2/5 rounded-l-sm" src="/storage/{{ $hotel->poster_url }}" alt="{{ $hotel->name }}">
    <div class="w-full flex flex-col justify-between p-4">
        <div>
            <a class="block text-grey-darkest mb-2 font-bold"
               href="{{ route('hotels.show', ['hotel' => $hotel]) }}">{{ $hotel->name }} ({{ \App\Services\ProjectEnumsService::hotelType()[$hotel->type] }})</a>
            <div class="text-xs">
                {{ $hotel->address }}
            </div>
        </div>
        <div class="pt-2">
            <span class="text-lg">от </span>
            <span class="text-2xl text-grey-darkest">{{ number_format($hotel->price, 0, '.', ' ') }} ₽</span>
            <span class="text-lg"> за ночь</span>
        </div>

        @if($hotel->facilities->isNotEmpty())
            <div class="flex items-center py-2 flex-wrap">
                @foreach($hotel->facilities as $facility)
                    <div class="pr-2 text-xs">
                        <span>•</span> {{ $facility->name }}
                    </div>
                @endforeach
            </div>
        @endif

        <div class="flex justify-end">
            <x-link-button href="{{ route('hotels.show', ['hotel' => $hotel]) }}">Подробнее</x-link-button>
        </div>
    </div>
</div>
