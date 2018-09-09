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
 * @property string $id;
 * @property string $lock_id;
 * @property string $accessor_id;
 * @property string $access_type;
 * @property bool $is_completed;
 * @property bool $is_successful;
 * @property \stdClass|null $clp_response;
 *
 * @property Carbon|null $created_at;
 * @property Carbon|null $updated_at;
 * @property Carbon|null $deleted_at;
 *
 * @property Lock $lock;
 * @property Accessor $accessor;
 */
class Access extends Model {

	use SoftDeletes;

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