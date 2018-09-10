<?php
/**
 * clay-backend-assessment
 * AccessorTest.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 09/09/18, 20:37
 */

namespace Tests\Unit;


use Clay\Accessor;
use Clay\Lock;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AccessorTest extends TestCase {

	use DatabaseMigrations;

	public function test_cannot_access_unauthorized_lock() {
		$lock = factory(Lock::class)->create(); /* @var $lock Lock */
		$accessor = factory(Accessor::class)->Create(); /* @var $accessor Accessor */

		$this->assertFalse($accessor->canAccessLock($lock));
	}

	public function test_can_access_authorized_lock() {
		$lock = factory(Lock::class)->create(); /* @var $lock Lock */
		$accessor = factory(Accessor::class)->Create(); /* @var $accessor Accessor */

		$this->assertFalse($accessor->canAccessLock($lock));

		$lock->authorize($accessor);

		$this->assertTrue($accessor->canAccessLock($lock));
	}

}