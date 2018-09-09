<?php
/**
 * clay-backend-assessment
 * Accessor.php
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
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Accessor
 * @package Clay
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $clp_id
 *
 * @property Lock[]|Collection $allowedLocks
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 */
class Accessor extends Model {

	use SoftDeletes;

	protected $table = "accessors";
	protected $fillable = [
		'name',

		'email',
		'password',

		'clp_id',
	];

	protected $hidden = [
		'password',
	];

	// ------------------------------------------------------------------------------------------------------------

	public function allowedLocks() {
		return $this->belongsToMany(Lock::class, 'lock_accessors');
	}

	// ------------------------------------------------------------------------------------------------------------

	/**
	 * Checks if the accessor is authorized to access a lock.
	 * @param Lock $lock
	 * @return bool
	 */
	public function canAccessLock(Lock $lock) : bool {
		return $this->allowedLocks()
			->where('lock_id', $lock->id)
			->exists();
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return "Accessor #{$this->id} ({$this->email})";
	}

}