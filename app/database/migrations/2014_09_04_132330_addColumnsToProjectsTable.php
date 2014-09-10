<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToProjectsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('projects', 'projectified')
            && !Schema::hasColumn('projects', 'completed_time'))
        {
            //Add columns ['description', 'completed', 'projectified', 'completed_time']
            Schema::table('projects', function(Blueprint $table)
            {
                $table->tinyInteger('projectified')->default('0');
                $table->timestamp('completed_time')->nullable();
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
        if (Schema::hasColumn('projects', 'projectified')
            && Schema::hasColumn('projects', 'completed_time'))
        {
            //Drop added columns
            Schema::table('projects', function(Blueprint $table)
            {
                $table->dropColumn('projectified');
                $table->dropColumn('completed_time');
            });
        }
    }

}
