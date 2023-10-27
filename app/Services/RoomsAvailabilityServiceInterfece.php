<?php

namespace App\Services;

use Illuminate\Http\Request;

interface RoomsAvailabilityServiceInterfece
{
    public function check(Request $request, $rooms);
}
