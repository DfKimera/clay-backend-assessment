<?php
/**
 * clay-backend-assessment
 * AuthController.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 09/09/18, 20:56
 */

namespace Clay\Http\Controllers\Admin;


use Clay\Http\Controllers\Controller;

class AuthController extends Controller {

	public function index() {
		return view('admin.login');
	}

	public function login() {

		$credentials = request()->only(['email', 'password']);
		$hasLoggedIn = auth()->attempt($credentials);

		if($hasLoggedIn) {
			return redirect()->route('admin.dashboard');
		}

		return redirect()->route('auth.index')
			->with('error', 'invalid_credentials');

	}

	public function logout() {
		auth()->logout();

		return redirect()->route('auth.index')
			->with('error', 'logged_out');
	}

}