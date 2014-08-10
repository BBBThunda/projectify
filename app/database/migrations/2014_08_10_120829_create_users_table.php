<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
        {
            Schema::create('users', function(Blueprint $table)
            {
                //Create initial users table
                $table->increments('id');
                $table->string('email')->unique();
                $table->string('passhash');
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
            // Drop the table
            Schema::drop('users');
	}

}
