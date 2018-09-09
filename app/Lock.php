<?php
/**
 * clay-backend-assessment
 * Lock.php
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
use Clay\Exceptions\LockIsBusyException;
use Clay\Exceptions\NotAllowedException;
use Clay\Jobs\ChangeLockStateOverCLP;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Class Lock
 * @package Clay
 *
 * @property string $id
 * @property string $name
 * @property bool $is_locked
 * @property bool $is_busy
 * @property bool $allow_unlocking
 * @property string $clp_id
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property Accessor[]|Collection $authorizedAccessors
 */
class Lock extends Model {

	use SoftDeletes;

	protected $table = 'locks';
	protected $fillable = [
		'name',
		'location',

		'is_locked',
		'is_busy',
		'allow_unlocking',

		'clp_id',
	];

	protected $casts = [
		'is_locked' => 'boolean',
		'allow_unlocking' => 'boolean',
		'is_busy' => 'boolean',
	];

	// ------------------------------------------------------------------------------------------------------------

	public function authorizedAccessors() {
		return $this->belongsToMany(Accessor::class, 'lock_accessors');
	}

	// ------------------------------------------------------------------------------------------------------------

	/**
	 * Is this lock locked?
	 * @return bool
	 */
	public function isLocked() {
		return $this->is_locked;
	}

	/**
	 * Handles a change in the lock state.
	 * @param Access $access
	 */
	public function handleStateChange(Access $access) : void {
		$this->is_locked = ($access->access_type === Access::LOCK);
		$this->save();
	}

	/**
	 * Adds an accessor to the list of authorized accessors.
	 * @param Accessor $accessor
	 */
	public function authorizeAccessor(Accessor $accessor) : void {
		$this->authorizedAccessors()->syncWithoutDetaching([$accessor->id]);
	}

	/**
	 * Removes an accessor from the list of authorized accessor, if they exist.
	 * @param Accessor $accessor
	 */
	public function deauthorizeAccessor(Accessor $accessor) : void {
		$this->authorizedAccessors()->detach([$accessor->id]);
	}

	/**
	 * Flags this lock as busy.
	 * Busy means there's an ongoing access operation waiting to complete.
	 */
	public function flagAsBusy() : void {
		$this->is_busy = true;
		$this->save();
	}

	/**
	 * Flags this lock as idle.
	 * Idle means there's no access operation waiting to complete.
	 */
	public function flagAsIdle() : void {
		$this->is_busy = false;
		$this->save();
	}

	/**
	 * Attempts to access (lock or unlock) this lock through an accessor.
	 * Will log an Access event.
	 * Will validate accessor permission.
	 * If accessor is authorized, will queue a call to change the lock state remotely.
	 *
	 * @param string $accessType Which access type is being attempted (lock or unlock?) @see Access::* consts
	 * @param Accessor $accessor Who is trying to access the lock?
	 *
	 * @return Access Returns an Access event, if the access was authorized.
	 *
	 * @throws LockIsBusyException If the lock is busy (there's an incomplete access operation)
	 * @throws NotAllowedException If the accessor is not authorized
	 */
	public function attemptAccess(string $accessType, Accessor $accessor) : Access {

		if(!$accessor->canAccessLock($this)) {
			throw new NotAllowedException($this, $accessor);
		}

		if($this->is_busy) {
			throw new LockIsBusyException($this);
		}

		$this->flagAsBusy();

		$access = Access::fromAccessAttempt($accessType, $this, $accessor);

		dispatch(new ChangeLockStateOverCLP($access));

		return $access;

	}

	/**
	 * @return string
	 */
	public function __toString() {
		return "Lock #{$this->id}";
	}

}