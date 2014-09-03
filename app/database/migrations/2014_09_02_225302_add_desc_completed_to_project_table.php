<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDescCompletedToProjectTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function(Blueprint $table)
        {
            //Add columns ['description', 'completed']
            $table->string('description')->after('parent_project');
            $table->boolean('completed')->after('description');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function(Blueprint $table)
        {
            //Drop columns
            $table->dropColumn('description');
            $table->dropColumn('completed');
        });
    }

}
