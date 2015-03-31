<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnabledColumnToContextsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasColumn('contexts', 'enabled'))
        {
            //Add column 'enabled'
            Schema::table('contexts',function(Blueprint $table) {
                $table->boolean('enabled')->after('user_id')->default(true);
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

        if (Schema::hasColumn('contexts', 'enabled'))
        {
            //Drop 'enabled' column
            Schema::table('contexts', function(Blueprint $table) {
                $table->dropColumn('enabled');
            });
        }

    }

}
