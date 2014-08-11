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
                $table->string('display_name')->unique();
                $table->string('email')->unique();
                $table->string('password');
                $table->tinyInteger('is_admin');
                $table->rememberToken();
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
