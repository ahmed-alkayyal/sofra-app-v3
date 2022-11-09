<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration {

	public function up()
	{
		Schema::create('settings', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->mediumText('about_app');
			$table->string('phone');
			$table->string('email');
			$table->string('fb_link');
			$table->string('inst_link');
            $table->decimal('site_commission')->default('5.20');
		});
	}

	public function down()
	{
		Schema::drop('settings');
	}
}
