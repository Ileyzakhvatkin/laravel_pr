<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $days = rand(1,60);
        $booksDays = rand(10,60);
        $started_at = Carbon::now()->addDays($booksDays);
        $finished_at = Carbon::now()->addDays($booksDays + rand(1,15));

        return [
            'room_id' => Room::all()->random()->id,
            'user_id' => User::where('id', "<>", "1")->get()->random()->id,
            'status' => 'created',
            'started_at' => $started_at,
            'finished_at' => $finished_at,
            'days' => $finished_at->diff($started_at)->format('%d'),
            'price' => rand(10,300) * 100,
            'created_at' => Carbon::now()->subDays($days),
            'updated_at' => Carbon::now()->subDays($days - rand(0,9)),
        ];
    }
}
