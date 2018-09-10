<?php
/**
 * clay-backend-assessment
 * APIController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 09/09/18, 22:23
 */

namespace Clay\Http\Controllers\API;


use Clay\Http\Controllers\Controller;

abstract class APIController extends Controller {

	protected function notAuthorized($reason) {
		return response()->json(['status' => 'failed', 'reason' => $reason], 401);
	}

	protected function notAllowed() {
		return response()->json(['status' => 'failed', 'reason' => 'not_allowed'], 403);
	}

	protected function failed($reason, $statusCode) {
		return response()->json(['status' => 'failed', 'reason' => $reason], $statusCode);
	}

	protected function failedWithException($reason, $statusCode, \Exception $ex) {
		return response()->json(['status' => 'failed', 'reason' => $reason, 'message' => $ex->getMessage()], $statusCode);
	}

	protected function response($data = []) {
		$data['status'] = 'ok';
		return response()->json($data);
	}

}