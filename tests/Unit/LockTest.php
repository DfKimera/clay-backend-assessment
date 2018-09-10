<?php
/**
 * clay-backend-assessment
 * LockTest.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 09/09/18, 20:05
 */

namespace Tests\Unit;


use Clay\Access;
use Clay\Accessor;
use Clay\Exceptions\NotAllowedException;
use Clay\Jobs\ChangeLockStateOverCLP;
use Clay\Lock;
use Clay\Services\AccessService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LockTest extends TestCase {

	use DatabaseMigrations;

	public function test_successful_unlock_attempt() {

		$accessor = factory(Accessor::class)->create(); /* @var $accessor Accessor */
		$lock = factory(Lock::class)->state('locked')->create(); /* @var $lock Lock */
		$service = app()->make(AccessService::class);

		$this->assertTrue($lock->isLocked());
		$this->assertFalse($accessor->canAccessLock($lock));

		$lock->authorize($accessor);

		$this->assertTrue($accessor->canAccessLock($lock));

		$access = $lock->attemptAccess($service, Access::UNLOCK, $accessor);

		$lock->refresh();

		$this->assertFalse($lock->isLocked());

	}

	public function test_unauthorized_unlock_attempt() {

		$accessor = factory(Accessor::class)->create(); /* @var $accessor Accessor */
		$lock = factory(Lock::class)->state('locked')->create(); /* @var $lock Lock */
		$service = app()->make(AccessService::class);

		$this->assertTrue($lock->isLocked());
		$this->assertFalse($accessor->canAccessLock($lock));

		$this->expectException(NotAllowedException::class);

		$lock->attemptAccess($service, Access::UNLOCK, $accessor);

		$this->assertTrue($lock->isLocked());

	}

	public function test_successful_lock_attempt() {

		$accessor = factory(Accessor::class)->create(); /* @var $accessor Accessor */
		$lock = factory(Lock::class)->state('unlocked')->create(); /* @var $lock Lock */
		$service = app()->make(AccessService::class);

		$this->assertFalse($lock->isLocked());
		$this->assertFalse($accessor->canAccessLock($lock));

		$lock->authorize($accessor);

		$this->assertTrue($accessor->canAccessLock($lock));

		$access = $lock->attemptAccess($service, Access::LOCK, $accessor);

		$access->handleSuccess();
		$lock->refresh();

		$this->assertTrue($lock->isLocked());

	}

	public function test_unauthorized_lock_attempt() {

		$accessor = factory(Accessor::class)->create(); /* @var $accessor Accessor */
		$lock = factory(Lock::class)->state('unlocked')->create(); /* @var $lock Lock */
		$service = app()->make(AccessService::class);

		$this->assertFalse($lock->isLocked());
		$this->assertFalse($accessor->canAccessLock($lock));

		$this->expectException(NotAllowedException::class);

		$lock->attemptAccess($service, Access::LOCK, $accessor);

		$this->assertFalse($lock->isLocked());

	}

	public function test_invalid_attempt_access() {
		$accessor = factory(Accessor::class)->create(); /* @var $accessor Accessor */
		$lock = factory(Lock::class)->state('locked')->create(); /* @var $lock Lock */
		$service = app()->make(AccessService::class);

		$this->assertTrue($lock->isLocked());
		$this->assertFalse($accessor->canAccessLock($lock));

		$lock->authorize($accessor);

		$this->expectException(\InvalidArgumentException::class);

		$lock->attemptAccess($service, 'open', $accessor);

		$this->assertTrue($lock->isLocked());
	}

}