<?php

class EmptyTablesSeeder extends Seeder {

    /**
     * Empty all tables but users in the proper order
     *
     * @return integer
     */
    public function run() {

        $tablesEmptied = 0;

        $tables = array( 
            'project_roadblock', 'roadblocks',
            'project_tag', 'tags',
            'context_project', 'contexts'
        );

        foreach ($tables as $table) {

            if (Schema::hasTable($table) && 
                DB::table($table)-count('id') > 0) {

                // Empty roadblocks table
                DB::table($table)->delete();

                $tablesEmptied++;
            }

        }

    }

}
