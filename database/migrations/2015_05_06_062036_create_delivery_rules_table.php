<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDeliveryRulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('delivery_rules', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('company_id', false)->nullable();
			$table->boolean('pickup')->nullable();
			$table->boolean('dropoff')->nullable();
			$table->integer('pickup_limit',false,true)->nullable();
			$table->text('pickup_limit_inc')->nullable();
			$table->text('dropoff_tat')->nullable();
			$table->integer('dropoff_limit',false,true)->nullable();
			$table->text('dropoff_limit_inc')->nullable();
			$table->text('delivery_ranges')->nullable();
			$table->text('delivery_schedules')->nullable();
			$table->text('blackout_dates')->nullable();
			$table->text('requested_range')->nullable();
			$table->boolean('pay_start')->nullable();
			$table->boolean('pay_end')->nullable();
			$table->tinyInteger('status');
			$table->softDeletes();
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
		Schema::drop('delivery_rules');
	}

}
