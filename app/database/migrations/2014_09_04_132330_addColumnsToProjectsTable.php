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
                $table->boolean('projectified')->default(false);
                $table->timestamp('completed_at')->nullable();
                $table->boolean('deleted')->default(false);
                $table->timestamp('deleted_at')->nullable();
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
            && Schema::hasColumn('projects', 'completed_at')
            && Schema::hasColumn('projects', 'deleted')
            && Schema::hasColumn('projects', 'deleted_at')) {
        
            //Drop added columns
            Schema::table('projects', function(Blueprint $table)
            {
                $table->dropColumn('projectified');
                $table->dropColumn('completed_at');
                $table->dropColumn('deleted');
                $table->dropColumn('deleted_at');
            });

        }
    }

}
