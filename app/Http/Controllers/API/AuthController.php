<?php
/**
 * clay-backend-assessment
 * AuthController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 09/09/18, 22:13
 */

namespace Clay\Http\Controllers\API;


class AuthController extends APIController {

	public function authenticate() {

		$credentials = request()->only(['email', 'password']);
		$token = auth()->guard('api')->attempt($credentials);

		if(!$token) {
			return $this->notAuthorized('invalid_credentials');
		}

		return $this->response([
			'token' => $token,
		]);
	}

	public function identity() {

		return $this->response([
			'user' => auth()->guard('api')->user(),
		]);

	}

}