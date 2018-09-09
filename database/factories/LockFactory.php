<?php

use Faker\Generator as Faker;

$factory->define(Clay\Lock::class, function (Faker $faker) {
	return [
		'name' => "{$faker->firstName}'s office",
		'location' => $faker->company,
		'is_locked' => false,
		'is_busy' => false,
		'allow_unlocking' => true,
		'clp_id' => $faker->uuid,
		'created_at' => date('Y-m-d H:i:s'),
		'updated_at' => date('Y-m-d H:i:s'),
		'deleted_at' => null,
	];
});

$factory->state(Clay\Lock::class, 'locked', [
	'is_locked' => true,
]);

$factory->state(Clay\Lock::class, 'unlocked', [
	'is_locked' => false,
]);

$factory->state(Clay\Lock::class, 'busy', [
	'is_busy' => true,
]);

$factory->state(Clay\Lock::class, 'idle', [
	'is_busy' => false,
]);

$factory->state(Clay\Lock::class, 'blocked', [
	'allow_unlocking' => false,
]);