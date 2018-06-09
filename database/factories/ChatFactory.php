<?php

use Faker\Generator as Faker;

$factory->define(App\Room::class, function ($faker) {
    $owner = factory(App\User::class)->create();

    return [
        'name' => $faker->name,
        'owner_id' => $owner->id
    ];
});