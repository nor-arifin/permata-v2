<?php

use Faker\Generator as Faker;

$factory->define(Loinc::class, function (Faker $faker) {
    return [
        'loinc_code' => $faker->word,
        'loinc_display' => $faker->word,
        'loinc_component' => $faker->word,
        'loinc_property' => $faker->word,
        'loinc_tim' => $faker->word,
        'loinc_system' => $faker->word,
        'loinc_scale' => $faker->word,
        'loinc_method' => $faker->word,
        // ... other fields
    ];
});
