<?php
/**
 * clay-backend-assessment
 * AccessorAPITest.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 09/09/18, 19:59
 */

namespace Tests\Feature;


use Clay\Access;
use Clay\Accessor;
use Clay\Jobs\ChangeLockStateOverCLP;
use Clay\Lock;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LockAPITest extends TestCase {

	use DatabaseMigrations;

	/**
	 * @var Accessor
	 */
	private $accessor;

	/**
	 * @var Accessor
	 */
	private $otherAccessor;

	/**
	 * @var Lock
	 */
	private $lockedLock;

	/**
	 * @var Lock
	 */
	private $unlockedLock;

	public function setUp() {
		parent::setUp();

		$this->accessor = factory(Accessor::class)->create();
		$this->otherAccessor = factory(Accessor::class)->create();

		$this->unlockedLock = factory(Lock::class)->state('unlocked')->create();
		$this->unlockedLock->authorizeAccessor($this->accessor);

		$this->lockedLock = factory(Lock::class)->state('locked')->create();
		$this->lockedLock->authorizeAccessor($this->accessor);
	}

	public function test_can_list_locks() {

		$response = $this
			->actingAs($this->accessor, 'api')
			->json(
				'GET',
				'/api/locks'
			);

		$response->assertSuccessful();
		$response->assertJsonStructure(['status', 'locks']);

		$this->assertCount(2, $response->json('locks'));
		$this->assertEquals($this->unlockedLock->id, $response->json('locks.0.id'));
		$this->assertEquals($this->lockedLock->id, $response->json('locks.1.id'));

	}

	public function test_can_lock_a_lock() {

		$this->expectsJobs(ChangeLockStateOverCLP::class);

		$this->assertFalse($this->unlockedLock->isLocked());

		$response = $this
			->actingAs($this->accessor, 'api')
			->json(
				'PUT',
				'/api/locks/' . $this->unlockedLock->id,
				['access_type' => 'lock']
			);

		$response->assertSuccessful();
		$response->assertJsonStructure(['status', 'access_id']);

		$accessID = $response->json('access_id');

		$access = Access::find($accessID); /* @var $access Access */
		$this->assertNotNull($accessID);

		$access->handleSuccess();

		$this->unlockedLock->refresh();

		$this->assertTrue($this->unlockedLock->isLocked());

	}

	public function test_can_unlock_a_lock() {

		$this->expectsJobs(ChangeLockStateOverCLP::class);

		$this->assertTrue($this->lockedLock->isLocked());

		$response = $this
			->actingAs($this->accessor, 'api')
			->json(
				'PUT',
				'/api/locks/' . $this->lockedLock->id,
				['access_type' => 'unlock']
			);

		$response->assertSuccessful();
		$response->assertJsonStructure(['status', 'access_id']);

		$accessID = $response->json('access_id');

		$access = Access::find($accessID); /* @var $access Access */
		$this->assertNotNull($accessID);

		$access->handleSuccess();

		$this->lockedLock->refresh();

		$this->assertFalse($this->lockedLock->isLocked());

	}

	public function test_an_unauthorized_user_cannot_access() {

		$this->assertTrue($this->lockedLock->isLocked());

		$response = $this
			->actingAs($this->otherAccessor, 'api')
			->json(
				'PUT',
				'/api/locks/' . $this->lockedLock->id,
				['access_type' => 'unlock']
			);

		$response->assertStatus(403);
		$response->assertJsonStructure(['status', 'reason']);

		$response->assertJson(['reason' => 'not_allowed']);

		$this->doesntExpectJobs(ChangeLockStateOverCLP::class);

		$this->assertTrue($this->lockedLock->isLocked());

	}

}