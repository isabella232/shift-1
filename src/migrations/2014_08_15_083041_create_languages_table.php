<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('languages', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('language');           // English (Great Britain)
            $table->string('code')->index();    // en_GB
        });

        DB::table('languages')->insert(array('language' => 'English (Great Britain)', 'code' => 'en_GB'));
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('languages');
	}

}
