<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accessors', function (Blueprint $table) {
        	$table->increments('id');

        	$table->string('name');
        	$table->string('email')->index();
        	$table->string('password');

        	$table->string('clp_id')->index();

        	$table->timestamps();
        	$table->softDeletes();
        });

        Schema::create('locks', function (Blueprint $table) {
        	$table->increments('id');

        	$table->string('name');
        	$table->string('location')->nullable();

        	$table->boolean('is_locked')->default(false)->index();
        	$table->boolean('allow_unlocking')->default(false)->index();

        	$table->string('clp_id')->index();

        	$table->timestamps();
        	$table->softDeletes();
        });

        Schema::create('accesses', function (Blueprint $table) {
        	$table->increments('id');

        	$table->string('access_type')->index();
        	$table->integer('lock_id')->index();
        	$table->integer('accessor_id')->index();

        	$table->boolean('is_completed')->default(false);
        	$table->boolean('is_successful')->default(false);

	        $table->string('clp_id')->index()->nullable();
        	$table->longText('clp_response')->nullable();

        	$table->timestamps();
        });

        Schema::create('lock_accessors', function (Blueprint $table) {
        	$table->increments('id');

        	$table->integer('lock_id')->index();
        	$table->integer('accessor_id')->index();

        	$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accessors');
        Schema::dropIfExists('locks');
        Schema::dropIfExists('accesses');
        Schema::dropIfExists('lock_accessors');
    }
}
