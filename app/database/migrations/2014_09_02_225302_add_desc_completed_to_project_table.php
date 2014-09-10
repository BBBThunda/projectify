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
        if (!Schema::hasColumn('projects', 'description')
            && !Schema::hasColumn('projects', 'completed'))
        {
            Schema::table('projects', function(Blueprint $table)
            {
                //Add columns ['description', 'completed']
                $table->string('description')->before('sequence');
                $table->boolean('completed')->before('sequence')->default(0);

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
        if (!Schema::hasColumn('projects', 'description')
            && !Schema::hasColumn('projects', 'completed'))
        {
            Schema::table('projects', function(Blueprint $table)
            {
                //Drop columns
                $table->dropColumn('description');
                $table->dropColumn('completed');
            });
        }
    }

}
