<?php

namespace App\Admin\Widgets;

use App\Models\Booking;
use Arrilot\Widgets\AbstractWidget;

class BookingsWidget extends AbstractWidget
{
    protected $config = [];

    public  function run()
    {
        $count = Booking::count();

        return view('voyager::dimmer', array_merge($this->config, [
            'icon' => 'voyager-calendar',
            'title' => 'Счетчик бронирований',
            'text' => "Всего бронирований в системе -  {$count} ",
            'button' => [
                'text' => 'Перейти к списку',
                'link' => 'admin/booking',
            ],
            'image' => 'bookings-bg.jpg',
        ]));
    }

    public function shouldBeDisplayed()
    {
        return true;
    }
}
