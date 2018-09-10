<?php
/**
 * clay-backend-assessment
 * ClientController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 09/09/18, 23:48
 */

namespace Clay\Http\Controllers\Client;


use Clay\Http\Controllers\Controller;

class ClientController extends Controller {

	public function index() {
		return view('client.client');
	}

}