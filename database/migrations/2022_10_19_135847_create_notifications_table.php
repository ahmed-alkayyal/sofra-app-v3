<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	public function up()
	{
		Schema::create('notifications', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->text('content');
			$table->integer('notificationtable_id');
			$table->string('notificationtable_type');
		});
	}

	public function down()
	{
		Schema::drop('notifications');
	}
}