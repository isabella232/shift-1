<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomFieldsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('custom_fields', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('group')->default('custom');
            $table->string('resource');
            $table->string('type');
            $table->string('field_title');
            $table->string('field_code');
            $table->string('label');
            $table->text('options');
            $table->text('validation');
            $table->text('settings');
            $table->boolean('required')->default(false);
            $table->boolean('registration');
            $table->integer('order');
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
		Schema::drop('custom_fields');
	}

}
