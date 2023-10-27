<?php

namespace Database\Factories;

use App\Models\Hotel;
use App\Services\ProjectEnumsService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RoomFactory extends Factory
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
            'title' => $this->faker->realText(rand(10,15)),
            'description' => $this->faker->realText(rand(50,250)),
            'poster_url' => '/demo/hotel-' . rand(1,30) . '.jpeg',
            'floor_area' => round(rand(1000, 5000) / 100, 1),
            'type' => array_rand(ProjectEnumsService::roomType()),
            'price' => rand(10,300) * 100,
            'hotel_id' => Hotel::all()->random()->id,
            'created_at' => Carbon::now()->subDays($days),
            'updated_at' => Carbon::now()->subDays($days - rand(0,9)),
        ];
    }
}
