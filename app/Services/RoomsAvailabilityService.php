<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RoomsAvailabilityService implements RoomsAvailabilityServiceInterfece
{
    static public function check(Request $request, $rooms)
    {
        $startPlan  = Carbon::now()->addDay();
        $endPlan= Carbon::now()->addDays(2);
        if ($request->has('start_date') && $request->has('end_date')) {
            $startPlan = Carbon::parse($request->input('start_date'));
            $endPlan = Carbon::parse($request->input('end_date'));
            if ($startPlan > $endPlan) {
                $endPlan = $startPlan->addDay();
            }
        }
        $days = $endPlan->diff($startPlan)->format('%d');

        $periodPlan = [];
        while ($startPlan->toDateString() !== $endPlan->toDateString()) {
            $periodPlan[] = $startPlan->toDateString();
            $startPlan->addDay();
        }

        foreach ($rooms as $room) {
            $allPeriodBook = [];
            foreach ($room->bookings as $booking) {
                while ($booking->started_at !== $booking->finished_at) {
                    $allPeriodBook[] = Carbon::parse($booking->started_at)->toDateString();
                    $booking->started_at = Carbon::parse($booking->started_at)->addDay()->toDateTimeString();
                }
            }
            $res = 0;
            foreach ($allPeriodBook as $day) {
                in_array($day, $periodPlan) ? $res++ : $res;
            }
            if ($res > 0) $room->availability = false;
        }

        return $days;
    }
}
