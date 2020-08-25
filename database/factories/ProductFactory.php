<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Product;
use Illuminate\Support\Facades\DB;

$factory->define(Product::class, function (Faker $faker) {
    //$nature = DB::table('natures')->select('id')->get();
    //$subcat = DB::table('subcategories')->select('id')->get();

    return [
        'reference' => rand(10000,100000),
        'name' => $faker->word,
        'brand' => $faker->lastName,
        //'subcategory_id' => $faker->randomElement($subcat)->id,
        'description' => $faker->paragraph(),
        //'nature_id' => $faker->randomElement($nature)->id,
        'quantity' => rand(1,20),
        'measure' => 'Un',
        //'colour' => $faker->colorName,
        'cost' => rand(1000, 300000),
        'to_sell' => $faker->boolean,
        'price' => rand(1000, 300000),
        'img1' => 'img/',
        'img2' => 'img/',
        'prom' => rand(1,2)
        //'price_min' => rand(1000, 300000)
    ];
});
