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
use Clay\Services\AccessService;
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
 * @property bool $allow_unlocking
 * @property string $clp_id
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 *
 * @property Accessor[]|Collection $authorizedAccessors
 * @property Access[]|Collection $accesses
 */
class Lock extends Model {

	use SoftDeletes;

	protected $table = 'locks';
	protected $fillable = [
		'name',
		'location',

		'is_locked',
		'allow_unlocking',

		'clp_id',
	];

	protected $casts = [
		'is_locked' => 'boolean',
		'allow_unlocking' => 'boolean',
	];

	// ------------------------------------------------------------------------------------------------------------

	public function authorizedAccessors() {
		return $this->belongsToMany(Accessor::class, 'lock_accessors');
	}

	public function accesses() {
		return $this->hasMany(Access::class, 'lock_id', 'id');
	}

	// ------------------------------------------------------------------------------------------------------------

	/**
	 * Gets recent access entries for this lock
	 * @param int $maxResults
	 * @return \Illuminate\Database\Eloquent\Collection|Collection
	 */
	public function getAccessActivity($maxResults) {
		return $this
			->accesses()
			->with(['accessor'])
			->take($maxResults)
			->orderBy('created_at', 'desc')
			->get();
	}

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
	public function authorize(Accessor $accessor) : void {
		$this->authorizedAccessors()->syncWithoutDetaching([$accessor->id]);
	}

	/**
	 * Removes an accessor from the list of authorized accessor, if they exist.
	 * @param Accessor $accessor
	 */
	public function deauthorize(Accessor $accessor) : void {
		$this->authorizedAccessors()->detach([$accessor->id]);
	}

	/**
	 * Updates the list of accessors allowed to access this lock.
	 * Will remove accessors not in the list of given IDs, and add the ones that are new.
	 * @param array $accessorIDs An array of accessor IDs allowed to access.
	 */
	public function syncAccessors(array $accessorIDs) : void {
		$this->authorizedAccessors()->sync($accessorIDs);
	}

	/**
	 * Gets a list of accessor IDs that are authorized to access this lock.
	 * @return array
	 */
	public function getAllowedAccessorIDs() : array {
		return $this->authorizedAccessors()
			->get(['accessor_id'])
			->pluck('accessor_id')
			->toArray();
	}

	/**
	 * Attempts to access (lock or unlock) this lock through an accessor.
	 * Will log an Access event.
	 * Will validate accessor permission.
	 * If accessor is authorized, will queue a call to change the lock state remotely.
	 *
	 * @param AccessService $service
	 * @param string $accessType Which access type is being attempted (lock or unlock?) @see Access::* consts
	 * @param Accessor $accessor Who is trying to access the lock?
	 *
	 * @return Access Returns an Access event, if the access was authorized.
	 *
	 * @throws NotAllowedException If the accessor is not authorized
	 */
	public function attemptAccess(AccessService $service, string $accessType, Accessor $accessor) : Access {

		if(!$accessor->canAccessLock($this)) {
			throw new NotAllowedException($this, $accessor);
		}

		$access = Access::fromAccessAttempt($accessType, $this, $accessor);

		$service->requestAccess($access);

		return $access;

	}

	/**
	 * @return string
	 */
	public function __toString() {
		return "Lock #{$this->id}";
	}

}