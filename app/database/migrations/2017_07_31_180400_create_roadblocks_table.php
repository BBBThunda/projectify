<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoadblocksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::dropIfExists('project_roadblock');
		Schema::dropIfExists('roadblocks');
        Schema::create('roadblocks', function(Blueprint $table)
        {
            //Create initial roadblocks table
            $table->increments('id');
			$table->integer('project_id');
            $table->integer('type');
            $table->integer('blocker_project_id')->nullable();
			$table->dateTime('blocker_date')->nullable();
			$table->string('blocker_person')->nullable();
            $table->timestamps();
        });
    }

	/**
	 * Reverse the migrations.
	 * roadblocks table was not used before this point, so just drop it
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('roadblocks');
	}

}
