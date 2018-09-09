<?php
/**
 * clay-backend-assessment
 * LockIsBusyException.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 09/09/18, 19:02
 */

namespace Clay\Exceptions;


use Clay\Lock;

class LockIsBusyException extends \Exception {

	private $lock;

	public function __construct(Lock $lock) {
		$this->lock = $lock;

		parent::__construct("Requested lock {$lock} is busy!");
	}

}