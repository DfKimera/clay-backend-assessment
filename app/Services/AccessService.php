<?php
/**
 * clay-backend-assessment
 * AccessService.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 10/09/18, 00:17
 */

namespace Clay\Services;


use Clay\Access;

interface AccessService {

	public function requestAccess(Access $access) : bool;

}