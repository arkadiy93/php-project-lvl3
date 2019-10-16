<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Domains::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->url,
        'content_length' => '1000',
        'status_code' => $faker->numberBetween($min = 200, $max = 500) ,
        'body' => '<!DOCTYPE html> <html> <body><h1>My First Heading</h1><p>My first paragraph.</p></body></html>',
        'keywords' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'description' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'heading' => 'fake heading'
    ];
});
