<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Services\ProjectEnumsService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class BookingsController extends Controller
{
    public function index()
    {
        $bookings = collect([]);

        switch (auth()->user()->role->name) {
            case 'admin':
                $bookings = Booking::with('room.hotel')->latest()->paginate(6);
                break;
            case 'manager':
                 $bookings = Booking::with('room.hotel')->whereHas('room', function ($q) {
                        $q->whereHas('hotel', function ($q1) {
                            $q1->where('manager_id', auth()->id());
                        });
                    })->latest()->paginate(6);
                break;
            case 'user':
                $bookings = Booking::where('user_id', auth()->id())->with('room.hotel')->latest()->paginate(6);
                break;
        }

        return view('bookings.index', [
            'bookings' => $bookings,
        ]);
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);
        return view('bookings.show', [
            'booking' => $booking,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|max:5',
            'started_at' => 'required|date',
            'finished_at' => 'required|date|after:started_at',
        ]);

        $booking = new Booking();
        $booking->status = 'created';
        $booking->user_id = auth()->id(); // Исправить по готовности авторизации
        $booking->room_id = $request->input('room_id');
        $booking->started_at = Carbon::parse($request->input('started_at'));
        $booking->finished_at = Carbon::parse($request->input('finished_at'));
        $days = $booking->finished_at->diff($booking->started_at)->format('%d');
        $booking->days = $days > 0 ? $days : 1;
        $booking->price = Room::find($request->input('room_id'))->price * $booking->days;
        $booking->save();

        return redirect()->route('bookings.index');
    }

    public function deleted($id)
    {
        $booking = Booking::find($id);
        $this->authorize('delete', $booking);
        $booking->delete();

        return redirect()->route('bookings.index');

    }

    public function updated($id, Request $request)
    {
        $status = $request->get('status');

        if ( array_key_exists($status, ProjectEnumsService::bookingStatus()) ) {
            $booking = Booking::find($id);
            $this->authorize('update', $booking);
            $booking->status = $status;
            $booking->save();

            return redirect()->route('bookings.index');
        } else {

            return response()->json(['error' => 'Not authorized. Wrong status.'],403);
        }
    }
}
