<?php
/**
 * clay-backend-assessment
 * LocksController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 09/09/18, 22:18
 */

namespace Clay\Http\Controllers\API;

use Clay\Accessor;
use Clay\Exceptions\LockIsBusyException;
use Clay\Exceptions\NotAllowedException;
use Clay\Lock;
use Clay\Services\AccessService;

class LocksController extends APIController {

	public function index() {
		$accessor = auth()->guard('api')->user(); /* @var $accessor Accessor */
		$locks = $accessor->allowedLocks;

		return response()->json([
			'status' => 'ok',
			'locks' => $locks,
		]);
	}

	public function show(Lock $lock) {

		$maxEntries = max(intval(request('max', 24)), 64);
		$activity = $lock->getAccessActivity($maxEntries);

		return $this->response([
			'lock' => $lock,
			'activity' => $activity,
		]);
	}

	public function update(Lock $lock, AccessService $service) {
		$accessor = auth()->guard('api')->user(); /* @var $accessor Accessor */

		try {

			$accessType = request('access_type', '');
			$access = $lock->attemptAccess($service, $accessType, $accessor);

			return $this->response(['access_id' => $access->id]);

		} catch (NotAllowedException $ex) {
			return $this->notAllowed();
		} catch (\InvalidArgumentException $ex) {
			return $this->failedWithException('invalid_parameters', 422, $ex);
		} catch (\Exception $ex) {
			return $this->failedWithException('unexpected_error', 500, $ex);
		}

	}

}