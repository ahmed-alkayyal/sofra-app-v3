<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('client_id')->unsigned();
			$table->decimal('total_price')->default(0);
			$table->enum('state', array('pending', 'accepted', 'rejected', 'delivered', 'decliened'));
			$table->string('address');
			$table->decimal('price')->default(0);
			$table->decimal('delivery_price')->default(0);
			// $table->decimal('site_commission');
			$table->integer('restaurant_id')->unsigned();
			// $table->integer('payment_type')->nullable();
            $table->integer('payment_id')->unsigned()->nullable();
			$table->text('note');
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}
