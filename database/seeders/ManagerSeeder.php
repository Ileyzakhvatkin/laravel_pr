<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(1)->create([
            'name' => 'manager0@ya.ru',
            'email' => 'manager0@ya.ru',
            'role_id' => 3,
            'password' => bcrypt('managermanager'),
            'remember_token' => Str::random(10),
        ]);
    }
}
