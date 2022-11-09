<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOffersTable extends Migration {

	public function up()
	{
		Schema::create('offers', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('restaurant_id')->unsigned();
			$table->string('offer');
			$table->string('img');
			$table->text('description');
			$table->date('time_from');
			$table->date('time_to');
		});
	}

	public function down()
	{
		Schema::drop('offers');
	}
}
