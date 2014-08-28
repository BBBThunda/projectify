<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTableAddConfirmationFields extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //Add columns ['confirmed', 'confirmation_code']
        Schema::table('users', function($table) {
            $table->boolean('confirmed')->default(0)->after('remember_token');
            $table->string('confirmation_code')->nullable()->after('confirmed');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        //Drop columns ['confirmed', 'confirmation_code']
        Schema::table('users', function($table)
        {
            $table->dropColumn('confirmed');
            $table->dropColumn('confirmation_code');
        });

    }

}
