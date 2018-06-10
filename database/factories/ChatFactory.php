<?php

use Faker\Generator as Faker;

$factory->define(App\Room::class, function ($faker) {
    $owner = factory(App\User::class)->create();

    return [
        'name' => $faker->name,
        'description' => $faker->sentence,
        'owner_id' => $owner->id
    ];
});