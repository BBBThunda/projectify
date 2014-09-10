<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoadblockTagAndContextTables extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('roadblocks'))
        {
            Schema::create('roadblocks', function(Blueprint $table)
            {
                $table->increments('id');
                $table->string('description');
                $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id')->references('id')->on('users');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('project_roadblock'))
        {
            Schema::create('project_roadblock', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('project_id')->unsigned();
                $table->foreign('project_id')->references('id')->on('projects');
                $table->integer('roadblock_id')->unsigned();
                $table->foreign('roadblock_id')->references('id')->on('roadblocks');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('tags'))
        {
            Schema::create('tags', function(Blueprint $table)
            {
                $table->increments('id');
                $table->string('description');
                $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id')->references('id')->on('users');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('project_tag'))
        {
            Schema::create('project_tag', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('project_id')->unsigned();
                $table->foreign('project_id')->references('id')->on('projects');
                $table->integer('tag_id')->unsigned();
                $table->foreign('tag_id')->references('id')->on('tags');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('contexts'))
        {
            Schema::create('contexts', function(Blueprint $table)
            {
                $table->increments('id');
                $table->string('description');
                $table->integer('user_id')->unsigned()->nullable();
                $table->foreign('user_id')->references('id')->on('users');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('project_context'))
        {
            Schema::create('project_context', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('project_id')->unsigned();
                $table->foreign('project_id')->references('id')->on('projects');
                $table->integer('context_id')->unsigned();
                $table->foreign('context_id')->references('id')->on('contexts');
                $table->timestamps();
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

        if (Schema::hasTable('project_roadblock'))
        {
            Schema::drop('project_roadblock');
        }

        if (Schema::hasTable('roadblocks'))
        {
            Schema::drop('roadblocks');
        }

        if (Schema::hasTable('project_tag'))
        {
            Schema::drop('project_tag');
        }

        if (Schema::hasTable('tags'))
        {
            Schema::drop('tags');
        }

        if (Schema::hasTable('project_context'))
        {
            Schema::drop('project_context');
        }

        if (Schema::hasTable('contexts'))
        {
            Schema::drop('contexts');
        }

    }

}
