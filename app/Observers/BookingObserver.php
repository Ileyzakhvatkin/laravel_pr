<?php

namespace App\Observers;

use App\Mail\BookingCreated;
use App\Mail\BookingDeleted;
use App\Mail\BookingUpdaded;
use App\Models\Booking;
use Illuminate\Support\Facades\Mail;

class BookingObserver
{
    /**
     * Handle the Booking "created" event.
     *
     * @param  \App\Models\Booking  $booking
     * @return void
     */
    public function created(Booking $booking)
    {
        Mail::to($booking->user->email)->send(new BookingCreated($booking));
    }

    /**
     * Handle the Booking "updated" event.
     *
     * @param  \App\Models\Booking  $booking
     * @return void
     */
    public function updated(Booking $booking)
    {
        Mail::to($booking->user->email)->send(new BookingUpdaded($booking));
    }

    /**
     * Handle the Booking "deleted" event.
     *
     * @param  \App\Models\Booking  $booking
     * @return void
     */
    public function deleted(Booking $booking)
    {
        Mail::to($booking->user->email)->send(new BookingDeleted($booking));
    }
}
