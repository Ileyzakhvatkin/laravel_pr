<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use App\Services\ProjectEnumsService;
use App\Services\RoomsAvailabilityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HotelsController extends Controller
{
    public function index(Request $request)
    {
        $hotelSearch = $request->input('hotelSearch');
        $minPrice = $request->input('minPrice');
        $maxPrice = $request->input('maxPrice');
        $hotelFacilities = $request->input('hotelFacilities');
        $sortType = $request->input('sortType');
        $hotelTypes = [];
        foreach (ProjectEnumsService::hotelType() as $key => &$hotelType) {
            if ($request->input($key)) $hotelTypes[$key] = $hotelType;
        }
        $roomTypes = [$hotelTypes];
        foreach (ProjectEnumsService::roomType() as $key => &$type) {
            if ($request->input($key)) $roomTypes[$key] = $type;
        }

        // Вычисление минимальной цены комнаты в отеле
        $minPriceRoom = Room::select('hotel_id', DB::raw('MIN(price) as price'))->groupBy('hotel_id');

        $hotels = Hotel::joinSub($minPriceRoom, 'price', function ($join) {
            $join->on('hotels.id', '=', 'price.hotel_id');
        })->with('facilities')
        ->when($hotelSearch, function ($q) use ($hotelSearch) {
            $q->where('name', 'like', "%$hotelSearch%")->orWhere('address', 'like', "%$hotelSearch%");
        })->when($hotelTypes, function ($q) use ($hotelTypes) {
            $q->whereIn('type', array_keys($hotelTypes));
        })->when($minPrice, function ($q) use ($minPrice) {
            $q->where('price', '>=', $minPrice);
        })->when($maxPrice, function ($q) use ($maxPrice) {
            $q->where('price', '<=', $maxPrice);
        })->when($roomTypes, function ($q) use ($roomTypes) {
            $q->whereHas('rooms', function ($q2) use ($roomTypes) {
                $q2->whereIn('type', array_keys($roomTypes));
            });
        })->when($hotelFacilities, function ($q) use ($hotelFacilities) {
            foreach ($hotelFacilities as $hotelFacility) {
                $q->whereHas('facilities', function ($q2) use ($hotelFacility) {
                    $q2->where('name', $hotelFacility);
                });
            }
        })->when($sortType, function ($q) use ($sortType) {
            $direction = $sortType === 'sortPriceASC' ? 'ASC' : 'DESC';
            $q->orderBy('price', $direction);
        })->paginate(10)->appends($request->all());

        return view('hotels.index', [
            'hotels' => $hotels,
            'hotelTypes' => $hotelTypes,
            'roomTypes' => $roomTypes,
        ]);
    }

    public function show(Hotel $hotel, Request $request)
    {
        $request->validate([
            'finished_at' => 'after:started_at',
        ]);

        $rooms = $hotel->rooms()->with('bookings.review','facilities')->get();

        $days = (new RoomsAvailabilityService())->check($request, $rooms);

        $rooms = $rooms->sortBy(function ($room) {
            return ($room['price']);
        });

        foreach ($rooms as $room) {
            $room->total_price = $room->price * $days;
            $room->total_days = $days;
        }

        $reviews = [];
        foreach ($rooms as $room) {
            foreach ($room->bookings as $booking) {
                if (isset($booking->review)) $reviews[] = $booking->review;
            }
        }

        return view('hotels.show', [
            'rooms' => $rooms,
            'hotel' => $hotel,
            'reviews' => $reviews,
        ]);
    }
}
