<?php

use Faker\Generator as Faker;

$factory->define(App\Track::class, function (Faker $faker) {

    $startdate = $faker->dateTimeBetween('today', 'today');
    $enddate = $faker->dateTimeBetween($startdate, '4h');
    return [
        'user_id' => 1,
        'comment' => $faker->sentence(),
        'category' =>  $faker->word(),
        'start' => $startdate,
        'end' => $enddate,
    ];
});
