<?php
/**
 * clay-backend-assessment
 * AuditEvent.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 09/09/18, 18:42
 */

namespace Clay;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Access
 * @package Clay
 *
 * @property string $id
 * @property string $lock_id
 * @property string $accessor_id
 * @property string $access_type
 * @property bool $is_completed
 * @property bool $is_successful
 * @property \stdClass|null $clp_response
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Lock $lock;
 * @property Accessor $accessor;
 */
class Access extends Model {


	const LOCK = 'lock';
	const UNLOCK = 'unlock';

	const VALID_TYPES = [self::LOCK, self::UNLOCK];

	protected $table = 'accesses';

	protected $fillable = [
		'lock_id',
		'accessor_id',
		'access_type',
		'is_completed',
		'is_successful',
		'clp_response',
	];

	protected $casts = [
		'is_completed' => 'boolean',
		'is_successful' => 'boolean',
		'clp_response' => 'object',
	];

	// ------------------------------------------------------------------------------------------------------------

	public function lock() {
		return $this->hasOne(Lock::class, 'id', 'lock_id');
	}

	public function accessor() {
		return $this->hasOne(Accessor::class, 'id', 'accessor_id');
	}

	// ------------------------------------------------------------------------------------------------------------

	/**
	 * Called when the access request succeeds.
	 * Changes the internal state of the lock.
	 */
	public function handleSuccess() {
		$this->is_completed = true;
		$this->is_successful = true;
		$this->save();

		$this->lock->handleStateChange($this);
	}

	/**
	 * Called when the access request fails.
	 */
	public function handleFailure() {
		$this->is_completed = true;
		$this->is_successful = false;
		$this->save();
	}

	// ------------------------------------------------------------------------------------------------------------

	/**
	 * Records an access attempt.
	 * Will validate the access type.
	 * Will not actually mutate any lock state.
	 *
	 * @param string $accessType @see Access::* consts.
	 * @param Lock $lock
	 * @param Accessor $accessor
	 * @return Access
	 */
	public static function fromAccessAttempt(string $accessType, Lock $lock, Accessor $accessor) : Access {

		if(!in_array($accessType, self::VALID_TYPES)) {
			throw new \InvalidArgumentException("Invalid access type: {$accessType}");
		}

		$access = new Access();
		$access->lock_id = $lock->id;
		$access->accessor_id = $accessor->id;
		$access->access_type = $accessType;
		$access->is_completed = false;
		$access->is_successful = false;
		$access->clp_response = null;
		$access->save();

		return $access;
	}

}