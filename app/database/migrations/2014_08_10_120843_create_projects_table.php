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
            Schema::create('projects', function(Blueprint $table)
            {
                //Create initial projects table 
                $table->increments('id');
                $table->integer('user_id');
                $table->integer('sequence');
                $table->integer('parent_project');
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
            //Drop projects table
            Schema::drop('projects');
	}

}
