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
 * Created at: 09/09/18, 21:13
 */

namespace Clay\Http\Controllers\Admin;


use Clay\Accessor;
use Clay\Http\Controllers\Controller;
use Clay\Lock;

class LocksController extends Controller {

	public function index() {
		$locks = Lock::query()->paginate(24);
		return view('admin.locks_index', compact('locks'));
	}

	public function create() {
		$lock = new Lock();
		return view('admin.locks_edit', compact('lock'));
	}

	public function edit(Lock $lock) {
		$accessors = Accessor::all();
		$allowedAccessorIDs = $lock->getAllowedAccessorIDs();

		return view('admin.locks_edit', compact('lock', 'allowedAccessorIDs', 'accessors'));
	}

	public function save(?Lock $lock = null) {
		if(!$lock) {
			$lock = new Lock();
		}

		$lock->fill(request()->all());
		$lock->save();

		return redirect()->route('admin.locks.edit', [$lock->id]);
	}

	public function update_authorized_accessors(Lock $lock) {

		$accessorIDs = (array) request('accessor_ids', []);
		$lock->syncAuthorizedAccessors($accessorIDs);

		return redirect()->route('admin.locks.edit', [$lock->id]);
	}

	public function destroy(Lock $lock) {
		$lock->destroy();
		return redirect()->route('admin.locks.index');
	}

}