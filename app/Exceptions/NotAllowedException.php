<?php
/**
 * clay-backend-assessment
 * NotAllowedException.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 09/09/18, 18:59
 */

namespace Clay\Exceptions;


use Clay\Accessor;
use Clay\Lock;

class NotAllowedException extends \Exception {

	private $lock;
	private $accessor;

	public function __construct(Lock $lock, Accessor $accessor) {
		$this->lock = $lock;
		$this->accessor = $accessor;

		parent::__construct("Accessor {$accessor} not allowed to access lock {$lock}");
	}

}