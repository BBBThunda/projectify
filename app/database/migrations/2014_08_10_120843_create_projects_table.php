<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
        {
            if (!Schema::hasTable('projects'))
            {
                Schema::create('projects', function(Blueprint $table)
                {
                    //Create initial projects table 
                    $table->increments('id');
                    $table->integer('user_id')->unsigned();
                    $table->foreign('user_id')->references('id')->on('users');
                    $table->integer('parent_project_id')->unsigned()->nullable();
                    $table->foreign('parent_project_id')->references('id')->on('projects');
                    $table->integer('sequence');
                    $table->timestamps();
                });
            }
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
            if (Schema::hasTable('projects'))
            {
                //Drop projects table
                Schema::drop('projects');
            }
	}

}
