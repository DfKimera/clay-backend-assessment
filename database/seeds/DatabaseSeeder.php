<?php

use Clay\Lock;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {

    	$accessors = factory(\Clay\Accessor::class, 10)->create();
    	$locks = factory(\Clay\Lock::class, 8)->create();

    	foreach($locks as $i => $lock) { /* @var $lock Lock */

	        $allowedAccessorsIDs = collect($accessors)
			    ->pluck('id')
			    ->take(5 - $i)
			    ->toArray();

    		$lock->syncAccessors($allowedAccessorsIDs);

	    }


    }
}
