<?php

namespace Database\Seeders;

use App\Models\Facility;
use App\Models\Hotel;
use App\Models\Role;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class testSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        User::factory(1)->create([
//            'name' => 'manager@ya.ru',
//            'email' => 'manager@ya.ru',
//            'role_id' => 3,
//            'password' => bcrypt('managermanager'),
//            'remember_token' => Str::random(10),
//        ]);

        Hotel::factory(1)->create()->each(function (Hotel $hotel) {
            $hotel->facilities()->saveMany(Facility::all()->random(rand(2,6)));
            $hotel->rooms()->saveMany(Room::factory(rand(2,10))->create()->each(function (Room $room) {
                $room->facilities()->saveMany(Facility::all()->random(rand(3,7)));
            }));
        });
    }
}
