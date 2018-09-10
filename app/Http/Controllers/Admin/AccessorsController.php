<?php
/**
 * clay-backend-assessment
 * AccessorsController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 09/09/18, 21:52
 */

namespace Clay\Http\Controllers\Admin;


use Clay\Accessor;
use Clay\Http\Controllers\Controller;

class AccessorsController extends Controller {

	public function index() {
		$accessors = Accessor::query()->paginate(24);
		return view('admin.accessors_index', compact('accessors'));
	}

	public function create() {
		$accessor = new Accessor();
		return view('admin.accessors_edit', compact('accessor'));
	}

	public function edit(Accessor $accessor) {
		return view('admin.accessors_edit', compact('accessor'));
	}

	public function save(?Accessor $accessor = null) {
		if(!$accessor) {
			$accessor = new Accessor();
		}

		$accessor->fill(request()->all());

		if(request()->has('password')) {
			$accessor->setPassword(request('password'));
		}

		$accessor->save();

		return redirect()->route('admin.accessors.edit', [$accessor->id]);
	}

	public function destroy(Accessor $accessor) {
		$accessor->destroy();
		return redirect()->route('admin.accessors.index');
	}

}