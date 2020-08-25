<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => 'hab',
        'email' => 'hab.borge@gmail.com',
        'email_verified_at' => now(),
        'password' => '$2y$10$o/bLSeU6DsJxv064SbGib.NfmR4t1HHI280g2u.oGW1b/0uGTVppG', // password: silverchair
        'remember_token' => Str::random(10),
    ];
});
