<?php

use Faker\Generator as Faker;

$factory->define(Clay\Accessor::class, function (Faker $faker) {
	return [
		'name' => $faker->name,
		'email' => $faker->safeEmail,
		'password' => password_hash('secret', PASSWORD_DEFAULT),
		'clp_id' => $faker->uuid,
	];
});