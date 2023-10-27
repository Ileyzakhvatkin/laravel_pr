<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class FacilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $days = rand(1,60);

        return [
            'name' => '',
            'created_at' => Carbon::now()->subDays($days),
            'updated_at' => Carbon::now()->subDays($days - rand(0,9)),
        ];
    }
}
