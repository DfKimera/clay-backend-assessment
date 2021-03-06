<?php

use Faker\Generator as Faker;

$factory->define(Clay\Lock::class, function (Faker $faker) {

	$name = $faker->randomElement([
		"{$faker->firstName}'s office",
		ucfirst($faker->colorName) . ' meeting room',
		ucfirst($faker->colorName) . ' room',
		'Kitchen',
		'Back door',
		'Street gate',
		'Street gate',
	]);

	return [
		'name' => $name,
		'location' => $faker->company,
		'is_locked' => false,
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

$factory->state(Clay\Lock::class, 'blocked', [
	'allow_unlocking' => false,
]);