<?php
/**
 * clay-backend-assessment
 * ClayPlatformService.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 10/09/18, 00:16
 */

namespace Clay\Services;


use Clay\Access;

class ClayPlatformService implements AccessService {

	public function requestAccess(Access $access) : bool {

		// TODO: integrate with CLP API
		$access->handleSuccess();

		return true;

	}

}