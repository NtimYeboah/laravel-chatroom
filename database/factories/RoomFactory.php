<?php

use App\User;
use App\Room;
use Faker\Generator as Faker;

$factory->define(Room::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->sentence
    ];
});
