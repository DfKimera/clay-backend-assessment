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
		return $this->response([
			'lock' => $lock,
		]);
	}

	public function update(Lock $lock) {
		$accessor = auth()->guard('api')->user(); /* @var $accessor Accessor */

		try {

			$accessType = request('access_type', '');
			$access = $lock->attemptAccess($accessType, $accessor);

			return $this->response(['access_id' => $access->id]);

		} catch (NotAllowedException $ex) {
			return $this->notAllowed();
		} catch (LockIsBusyException $ex) {
			return $this->failedWithException('lock_is_busy', 503, $ex);
		} catch (\InvalidArgumentException $ex) {
			return $this->failedWithException('invalid_parameters', 422, $ex);
		} catch (\Exception $ex) {
			return $this->failedWithException('unexpected_error', 500, $ex);
		}

	}

}