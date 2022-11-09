<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentsTable extends Migration {

	public function up()
	{
		Schema::create('comments', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('client_id')->unsigned();
			$table->text('comment');
			$table->integer('restaurant_id')->unsigned();
			$table->integer('emoji');
		});
	}

	public function down()
	{
		Schema::drop('comments');
	}
}