<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'reviewText' => 'required|max:600',
            'bookingId' => 'required|max:5',
        ]);

        if (in_array((int) $request->get('bookingId'), Booking::where('user_id', auth()->id())->pluck('id')->toArray())) {
            $review = new Review();
            $review->booking_id = $request->get('bookingId');
            $review->user_id = auth()->id();
            $review->text = $request->get('reviewText');
            $review->save();

            $reviewBooking = Booking::find($request->get('bookingId'));
            $reviewBooking->status = 'reviewed';
            $reviewBooking->save();

            return redirect()->route('bookings.index');
        } else {
            return response()->json(['error' => 'Not authorized.'],403);
        }

    }
}
