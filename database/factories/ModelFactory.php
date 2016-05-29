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

$factory->define(\Rcs\Bot\Database\Models\Command::class, function (\Faker\Generator $faker) {
    return [
        'command' => config('bot.delimiters.command', '!') . $faker->word,
        'action'  => $faker->sentence(6, true),
        'reply'   => $faker->boolean(),
    ];
});

$factory->define(\Rcs\Bot\Database\Models\Message::class, function (\Faker\Generator $faker) {
    return [
        'content' => $faker->sentence(2, true),
    ];
});

$factory->define(\Rcs\Bot\Database\Models\Schedule::class, function (\Faker\Generator $faker) {
    return [
        'name'       => $faker->words(1, true),
        'repeat'     => $faker->randomElement(['daily', 'weekly', 'monthly']),
        'channel_id' => $faker->randomNumber(random_int(4, 8)),
        'start_at'   => $faker->dateTime->format('U'),
        'end_at'     => $faker->dateTime->format('U'),
    ];
});

$factory->define(\Rcs\Bot\Database\Models\Script::class, function (\Faker\Generator $faker) {
    return [
        'name'     => $faker->words(1, true),
    ];
});

$factory->define(\Rcs\Bot\Database\Models\Message::class, function (\Faker\Generator $faker) {
    return [
        'content' => $faker->sentences(random_int(1, 3), true),
    ];
});
