<?php

namespace Database\Factories;

use App\Models\User;
use App\Services\ProjectEnumsService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class HotelFactory extends Factory
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
            'name' => $this->faker->company(),
            'type' => array_rand(ProjectEnumsService::hotelType()),
            'description' => $this->faker->realText(rand(400,500)),
            'poster_url' => 'demo/hotel-' . rand(1,30) . '.jpeg',
            'address' => $this->faker->address(),
            'created_at' => Carbon::now()->subDays($days),
            'updated_at' => Carbon::now()->subDays($days - rand(0,9)),
        ];
    }
}
