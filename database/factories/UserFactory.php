<?php

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

/**
 * Fonction permettant de retourner un identifiant existant s'il existe au moins une occurence de la classe demandée
 * en base de données.
 * Dans le cas contraire, on crée une nouvelle occurence en base en retournant son identifiant.
 * @param $class
 * @return mixed
 */
function getId ($class) {
    if($class::count() > 0)
        return $class::inRandomOrder()->first()->id;
    else
        return factory($class)->create()->id;
}

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Playlist::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->realText(),
        'user_id' => getId(\App\User::class)
    ];
});

$factory->define(App\Music::class, function (Faker $faker) {
    return [
        'title' => $faker->colorName,
        'author' => $faker->firstName.' '.$faker->lastName,
        'rank' => $faker->numberBetween(1, 5),
        'cover' => $faker->imageUrl(),
        'url' => $faker->url,
        'playlist_id' => getId(\App\Playlist::class)
    ];
});