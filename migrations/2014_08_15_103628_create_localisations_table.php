<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalisationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('localisations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('locale_id');
            $table->integer('foreign_id');
            $table->string('resource');
            $table->string('field');
            $table->string('value');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('localisations');
	}

}
