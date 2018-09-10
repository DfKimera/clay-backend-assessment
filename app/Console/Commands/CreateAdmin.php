<?php
/**
 * clay-backend-assessment
 * CreateAdmin.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2018
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 09/09/18, 21:32
 */

namespace Clay\Console\Commands;


use Clay\User;
use Illuminate\Console\Command;

class CreateAdmin extends Command {

	protected $signature = 'maintenance:create_admin';

	public function handle() {

		$name = $this->ask("Name", "Aryel");
		$email = $this->ask("E-mail", "aryel@tupinamba.me");
		$password = $this->ask("Password", "demo");

		$user = new User();
		$user->name = $name;
		$user->email = strtolower($email);
		$user->password = password_hash($password, PASSWORD_DEFAULT);
		$user->save();

		$this->info("Admin registered! ID: {$user->id}");

	}

}