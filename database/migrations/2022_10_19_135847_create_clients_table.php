<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email');
			$table->string('phone');
			$table->string('password');
			$table->string('api_token',60)->unique()->nullable();
			$table->integer('region_id')->unsigned();
			$table->string('pin_code')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}
