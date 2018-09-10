<?php
/**
 * clay-backend-assessment
 * TokenAPITest.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 09/09/18, 22:30
 */

namespace Tests\Feature;


use Clay\Accessor;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TokenAPITest extends TestCase {

	use DatabaseMigrations;

	public function test_can_generate_token() {

		$accessor = factory(Accessor::class)->create();

		$response = $this->json(
			'POST',
			'/api/auth',
			['email' => $accessor->email, 'password' => 'secret'],
			['Content-type' => 'application/json', 'Accept' => 'application/json']
		);

		$response->assertSuccessful();

		$response->assertJson(['status' => 'ok']);
		$response->assertJsonStructure(['status', 'token']);

	}

	public function test_can_use_token_to_authorize_request() {

		$accessor = factory(Accessor::class)->create();

		$authResponse = $this->json(
			'POST',
			'/api/auth',
			['email' => $accessor->email, 'password' => 'secret'],
			['Content-type' => 'application/json', 'Accept' => 'application/json']
		);

		$authResponse->assertSuccessful();
		$token = $authResponse->json('token');

		$response = $this->json(
			'GET',
			'/api/me',
			[],
			['Authorization' => 'Bearer ' . $token, 'Content-type' => 'application/json', 'Accept' => 'application/json']
		);

		$response->assertSuccessful();

		$response->assertJson(['status' => 'ok']);
		$response->assertJsonStructure(['status', 'user']);

		$this->assertEquals($accessor->id, $response->json('user.id'));
		$this->assertEquals($accessor->name, $response->json('user.name'));
		$this->assertEquals($accessor->email, $response->json('user.email'));

	}

	public function test_cannot_use_invalid_token_on_protected_resource() {

		$accessor = factory(Accessor::class)->create();

		$response = $this->json(
			'GET',
			'/api/me',
			[],
			[
				'Authorization' => 'Bearer ' . str_random(32),
				'Content-type' => 'application/json',
				'Accept' => 'application/json'
			]
		);

		$response->assertStatus(403);

		$response->assertExactJson(['status' => 'failed', 'reason' => 'not_allowed']);

	}

	public function test_cannot_authenticate_with_invalid_credentials() {

		$accessor = factory(Accessor::class)->create();

		$response = $this->json(
			'POST',
			'/api/auth',
			['email' => $accessor->email, 'password' => 'invalid'],
			['Content-type' => 'application/json', 'Accept' => 'application/json']
		);

		$response->assertStatus(401);
		$response->assertExactJson(['status' => 'failed', 'reason' => 'invalid_credentials']);

	}

}