<?php

use App\User;
use App\Room;
use App\Message;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    return [
        'body' => $faker->sentence,
        'user_id' => factory(User::class)->create()->id,
        'room_id' => factory(Room::class)->create()->id
    ];
});
