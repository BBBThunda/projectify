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
                $table->integer('project_id')->unsigned();
                $table->foreign('project_id')->references('id')->on('projects');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('roadblock_list'))
        {
            Schema::create('roadblock_list', function(Blueprint $table)
            {
                $table->increments('id');
                $table->string('description');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('tags'))
        {
            Schema::create('tags', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('project_id')->unsigned();
                $table->foreign('project_id')->references('id')->on('projects');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('tag_list'))
        {
            Schema::create('tag_list', function(Blueprint $table)
            {
                $table->increments('id');
                $table->string('description');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('contexts'))
        {
            Schema::create('contexts', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('project_id')->unsigned();
                $table->foreign('project_id')->references('id')->on('projects');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('context_list'))
        {
            Schema::create('context_list', function(Blueprint $table)
            {
                $table->increments('id');
                $table->string('description');
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

        if (Schema::hasTable('roadblocks'))
        {
            Schema::drop('roadblocks');
        }

        if (Schema::hasTable('roadblock_list'))
        {
            Schema::drop('roadblock_list');
        }

        if (Schema::hasTable('tags'))
        {
            Schema::drop('tags');
        }

        if (Schema::hasTable('tag_list'))
        {
            Schema::drop('tag_list');
        }

        if (Schema::hasTable('contexts'))
        {
            Schema::drop('contexts');
        }

        if (Schema::hasTable('context_list'))
        {
            Schema::drop('context_list');
        }

    }

}
