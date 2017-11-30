<?php

use Faker\Generator as Faker;

$factory->define(App\Track::class, function (Faker $faker) {

    $startdate = $faker->dateTimeBetween('today', 'today + 12 Hour');
    $startdateformatted = $startdate->format('Y-m-d H:i:s');
    $enddate = $faker->dateTimeBetween($startdateformatted . '+ 15 Minutes', $startdateformatted . '+ 2 Hour');

    $total = totalCalculation($startdate->getTimestamp(), $enddate->getTimestamp());

    return [
        'user_id' => 1,
        'comment' => $faker->sentence(),
        'category' =>  $faker->creditCardType(),
        'start' => $startdate,
        'end' => $enddate,
        'total' => $total,
    ];
});
