<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Facility;
use App\Models\Hotel;
use App\Models\Review;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FakeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1)->create([
            'name' => 'manager@manager.ru',
            'email' => 'manager@manager.ru',
            'role_id' => 3,
            'password' => bcrypt('manager'),
            'remember_token' => Str::random(10),
        ]);

        Hotel::factory(rand(55, 62))->create()->each(function (Hotel $hotel) {
            $hotel->facilities()->saveMany(Facility::all()->random(rand(2,6)));
            $hotel->rooms()->saveMany(Room::factory(rand(2,10))->create()->each(function (Room $room) {
                $room->facilities()->saveMany(Facility::all()->random(rand(3,7)));
            }));
        });

        $hotelWithManager = Hotel::find(1);
        $hotelWithManager->manager_id = User::where('role_id', 3)->first()->getKey();
        $hotelWithManager->save();

        User::factory(10)->create()->each(function (User $user) {
            $user->bookings()->saveMany(Booking::factory(rand(1,3))->create([
                'status' => 'reviewed',
                'user_id' => $user->id,
            ])->each(function (Booking $booking) {
                $booking->review()->saveMany(Review::factory(1)->create([
                    'booking_id' => $booking->id,
                    'user_id' => $booking->user_id,
                ]));
            }));
        });
    }
}
