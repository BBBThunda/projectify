<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordRemindersTable extends Migration {


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('password_reminders'))
        {
            Schema::create('password_reminders', function(Blueprint $table)
            {
                $table->increments('id');
                $table->string('email')->index();
                $table->string('token')->index();
                $table->timestamps('created_at');
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
        if (!Schema::hasTable('password_reminders'))
        {
            Schema::drop('password_reminders');
        }
    }

}
