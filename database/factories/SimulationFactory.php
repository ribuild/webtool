<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Simulation;
use Faker\Generator as Faker;

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

$factory->define(Simulation::class, function (Faker $faker) {
    return [
        'id' => $faker->uuid,
        'orientation' => $faker->numberBetween(0, 360),
        'wall_width' => $faker->numberBetween(100, 400),
        'wall_material' => $faker->randomElement(['brick', 'stone']),
        'ext_plaster' => $faker->boolean,
        'int_plaster' => $faker->boolean,
//        'country' => $faker->country,
        'city' => $faker->city,
        'heat_loss' => $faker->numberBetween(500, 5000),
        'mould' => $faker->randomFloat(5, 0, 5),
        'u_value' => $faker->randomFloat(5, 0, 3),
//        'algae' => $faker->randomFloat(5, 0, 5),
//        'environment_impact' => $faker->numberBetween(0, 100),
        'insulation_system' => $faker->randomElement(['A', 'B', 'C', 'D']),
        'insulation_thickness' => $faker->numberBetween(10, 100),
//        'surface_temp_' => $faker->numberBetween(0, 30),
    ];
});
