<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ReviewFactory extends Factory
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
            'active' => true,
            'booking_id' => Booking::get('id')->random(1)->first()->id,
            'user_id' => User::where('id', '>', 2)->get('id')->random(1)->first()->id,
            'text' => $this->faker->realText(rand(100,250)),
            'created_at' => Carbon::now()->subDays($days),
            'updated_at' => Carbon::now()->subDays($days - rand(0,9)),
        ];
    }
}
