<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConnectesTable extends Migration {

	public function up()
	{
		Schema::create('connectes', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email');
			$table->string('phone');
			$table->text('message');
			$table->enum('type', array('complaint', 'suggestion', 'enquiry'));
		});
	}

	public function down()
	{
		Schema::drop('connectes');
	}
}