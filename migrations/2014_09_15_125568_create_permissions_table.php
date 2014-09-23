<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permissions', function(Blueprint $table)
		{
			$table->bigInteger('role_id')->unsigned()->index();
			$table->string('action');
			$table->string('resource');
			$table->string('type'); // allow or deny
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('permissions');
	}

}
