<?php

namespace App\Admin\Widgets;

use App\Models\Hotel;
use Arrilot\Widgets\AbstractWidget;

class HotelsWidget extends AbstractWidget
{
    protected $config = [];

    public  function run()
    {
        $count = Hotel::count();

        return view('voyager::dimmer', array_merge($this->config, [
            'icon' => 'voyager-photos',
            'title' => 'Счетчик отелей',
            'text' => "Всего отелей в системе:  {$count}",
            'button' => [
                'text' => 'Перейти к списку',
                'link' => 'admin/hotels',
            ],
            'image' => 'hotel-bg.jpg',
        ]));
    }

    public function shouldBeDisplayed()
    {
        return true;
    }
}
