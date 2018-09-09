<?php
/**
 * clay-backend-assessment
 * ChangeLockStateOverCLP.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 09/09/18, 19:11
 */

namespace Clay\Jobs;


use Clay\Access;
use Illuminate\Contracts\Queue\ShouldQueue;

final class ChangeLockStateOverCLP implements ShouldQueue {

	/**
	 * @var Access
	 */
	private $access;

	public function __construct(Access $access) {
		$this->access = $access;
	}

	public function handle() {

		// TODO: handle API request to CLP

		$this->access->handleSuccess();

	}

}