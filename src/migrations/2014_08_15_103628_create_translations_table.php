<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranslationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('translations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('account_id');
            $table->integer('foreign_id');
            $table->string('language')->index();
            $table->string('resource');
            $table->string('field');
            $table->string('value');

            // now setup the required index
            $table->index(['account_id', 'foreign_id', 'language', 'resource', 'field']);
            $table->index(['account_id', 'foreign_id', 'resource', 'field']);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('translations');
	}

}
