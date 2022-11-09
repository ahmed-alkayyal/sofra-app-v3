<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRestaurantsTable extends Migration {

	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('image')->nullable();
			$table->integer('status');
			$table->string('email');
			$table->string('phone');
			$table->string('password');
			$table->string('minimum_order');
			$table->string('mobile');
			$table->decimal('delivery');
			$table->string('whatsapp');
			$table->string('api_token')->unique()->nullable();
			$table->integer('region_id')->unsigned();
			$table->string('pin_code')->nullable();
		});
	}

	public function down()
	{
		Schema::drop('restaurants');
	}
}
