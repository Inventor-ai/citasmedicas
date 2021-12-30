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
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'identity_card' => mt_Rand(10000000, 99999999),          // Done!! - Size may vary among countries
        // 'identity_card' => Str::random(8),                    // Size may vary among countries - Alphanumeric
        // 'identity_card' => Str::randomNumber(8),              // Fail Obsolete Up to Laravel v6
        // 'identity_card' => randomNumber(8),                   // Fail Obsolete Up to Laravel v5.7
        // 'remember_token' => FLOOR(RAND()*100000000),          // Fail
        // 'remember_token' => rand(1, 5),                       // Fail
        // 'identity_card' => Str::mt_Rand(10000000, 99999999),  // Fail
        // 'identity_card' => Num::random(8),                    // Fail
        // 'identity_card' => Integer::random(8),                // Fail
        // 'identity_card' => Int::random(8),                    // Fail        
        // 'identity_card' => Number::random(8),                 // Fail
        'address' => $faker->address,
        'phone' => $faker->e164PhoneNumber,
        'role' => $faker->randomElement(['patient', 'doctor'])
    ];
});
