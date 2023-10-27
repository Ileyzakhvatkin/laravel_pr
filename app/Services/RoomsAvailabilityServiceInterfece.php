<?php

namespace App\Services;

use Illuminate\Http\Request;

interface RoomsAvailabilityServiceInterfece
{
    static public function check(Request $request, $rooms);
}
