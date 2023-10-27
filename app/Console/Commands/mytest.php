<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\Facility;
use App\Models\Hotel;
use App\Models\Review;
use App\Models\Room;
use App\Models\User;
use Illuminate\Console\Command;

class mytest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mytest';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        User::factory(1)->create()->each(function (User $user) {
            $user->bookings()->saveMany(Booking::factory(rand(1,2))->create([
                'status' => 'reviewed',
                'user_id' => $user->id,
            ])->each(function (Booking $booking) {
                $booking->review()->saveMany(Review::factory(1)->create([
                    'booking_id' => $booking->id,
                    'user_id' => $booking->user_id,
                ]));
            }));
        });

        return 0;
    }
}
