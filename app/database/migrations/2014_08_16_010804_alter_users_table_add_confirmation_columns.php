<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTableAddConfirmationColumns extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('users', 'confirmed')
            && !Schema::hasColumn('users', 'confirmation_code'))
        {
            //Add columns ['confirmed', 'confirmation_code']
            Schema::table('users', function($table) {
                $table->boolean('confirmed')->default(0)->after('remember_token');
                $table->string('confirmation_code')->nullable()->after('confirmed');
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
        if (Schema::hasColumn('users', 'confirmed')
            && Schema::hasColumn('users', 'confirmation_code'))
        {
            //Drop columns ['confirmed', 'confirmation_code']
            Schema::table('users', function($table)
            {
                $table->dropColumn('confirmed');
                $table->dropColumn('confirmation_code');
            });
        }
    }

}
