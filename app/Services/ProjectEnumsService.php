<?php

namespace App\Services;

class ProjectEnumsService implements ProjectEnumsServiceInterfece
{
    static public  function roomType():array
    {
        return [
            'room1' => 'Одноместный',
            'room2' => 'Двухместный',
            'room3' => 'Трехместный',
            'family' => 'Семейный',
            'married' => 'Для молодоженов',
        ];
    }

    static public  function hotelType():array
    {
        return [
            'hostel' => 'хостел',
            'apartment' => 'апартаменты',
            'star1' => 'одна звезда',
            'star2' => 'две звезды',
            'star3' => 'три звезды',
            'star4' => 'четыре звезды',
            'star5' => 'пять звезд',
        ];
    }

    static public function facilities():array
    {
        return [
            'Ванная',
            'Вид из окон',
            'Гардеробная',
            'Джакузи',
            'Душевая кабина',
            'Завтрак',
            'Интернет',
            'Мини бар',
            'Парковка',
            'Ресторан',
            'Сауна в отеле',
            'Теплый пол',
            'Холодильник',
        ];
    }

    static public  function bookingStatus():array
    {
        return [
            'created' => 'Забронирован',
            'approved' => 'Подтверждаем',
            'canceled' => 'Не подтверждаем',
            'checkin' => 'Заселение',
            'used' => 'Номер сдан',
            'reviewed' => 'Оставлен отзыв',
        ];
    }
}
