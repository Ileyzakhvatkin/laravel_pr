<div class="flex flex-col md:flex-row shadow-md mb-4">
    <div class="h-full w-full md:w-2/5">
        <div class="h-64 w-full bg-cover bg-center bg-no-repeat" style="background-image: url('/storage{{ $room->poster_url }}')">
        </div>
    </div>
    <div class="p-4 w-full md:w-3/5 flex flex-col justify-between">
        <div class="pb-2">
            <div class="text-xl font-bold">
                {{ \App\Services\ProjectEnumsService::roomType()[$room->type] }} номер
            </div>
            <div class="py-2">
               <span class="pr-1">Площадь номера:</span> {{ $room->floor_area }} м
            </div>
            <div>
                <span class="pr-1">Удобства:</span>
                @foreach($room->facilities as $facility)
                    <span>• {{ $facility->name }} </span>
                @endforeach
            </div>
        </div>
        <hr>
        <div class="flex justify-end pt-2">
            @if(!$room->availability)
                <h4>На указанные даты мест нет</h4>
            @else
                <div>
                    <div class="flex">
                        <div class="flex flex-col">
                            <span class="text-lg font-bold">{{ number_format($room->total_price, 0, '.', ' ') }} руб.</span>
                            <span>за {{ $room->total_days }} ночей</span>
                        </div>
                        @if(!auth()->user() || (auth()->user() && !auth()->user()->isAdmin() && !auth()->user()->isManager()))
                            <form class="ml-4" method="POST" action="{{ route('bookings.store') }}">
                                @csrf
                                <input type="hidden" name="started_at" value="{{ request()->get('start_date', \Carbon\Carbon::now()->addDay()->format('d-m-Y')) }}">
                                <input type="hidden" name="finished_at" value="{{ request()->get('end_date', \Carbon\Carbon::now()->addDays(2)->format('d-m-Y')) }}">
                                <input type="hidden" name="room_id" value="{{ $room->id }}">
                                <x-the-button class=" h-full w-full">{{ __('Book') }}</x-the-button>
                            </form>
                        @endif
                    </div>
                    <div>
                        @foreach($errors->all() as $error)
                            <span class="pr-2 text-red-600">{{$error}}</span>
                        @endforeach
                    </div>

                </div>
            @endif
        </div>
    </div>
</div>
