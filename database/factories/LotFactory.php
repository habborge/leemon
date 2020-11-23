<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        //
    ];
});

$factory->define(App\Lot::class, function (Faker $faker, $attribues) {
    $max_id = $attribues['product_id'];
    return [

        'lot_code' => $faker->unique()->ean13,
		'quantity' => 0,
        'description' => $faker->text($maxNbChars = 100),
        'made_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'exp_date' => $faker->date($format = 'Y-m-d', $min = 'now'),
        'cost' => 0,
	];
});

$factory->define(App\LotDetails::class, function (Faker $faker, $attribues) {
    // $max_id = $attribues['product_id'];
    return [

        'product_lot_serial' => $faker->unique()->ean13,
		'status' => 1,
	];
});

$factory->define(App\Stock::class, function (Faker $faker, $attribues) {
    // $max_id = $attribues['product_id'];
    return [
        'quantity' => $faker->numberBetween($min = 5, $max = 50)
	];
});
