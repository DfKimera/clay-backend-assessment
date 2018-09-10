<?php
/**
 * clay-backend-assessment
 * DashboardController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 09/09/18, 21:17
 */

namespace Clay\Http\Controllers\Admin;


use Clay\Access;
use Clay\Http\Controllers\Controller;

class DashboardController extends Controller {

	public function index() {
		$recentAccesses = Access::fetchRecentSuccesfullAccesses();

		return view('admin.dashboard', compact('recentAccesses'));
	}

}