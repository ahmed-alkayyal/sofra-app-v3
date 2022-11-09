<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationTokensTable extends Migration {

	public function up()
	{
		Schema::create('notification_tokens', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->text('token');
			$table->integer('tokenable_id');
			$table->string('tokenable_type');
		});
	}

	public function down()
	{
		Schema::drop('notification_tokens');
	}
}