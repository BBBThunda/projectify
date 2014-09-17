<?php

class RoadblockTableSeeder extends Seeder {

    public function run()
    {

        // List of roadblocks
        // DO NOT change the order of existing roadblocks.  Append only.
        $roadblocks = array(
            'Waiting on Contact', 
            'Waiting on Project', 
            'Waiting on Event'
        );

        // Update autoincrement value to 1 in case table was not dropped
        DB::statement('ALTER TABLE tags AUTO_INCREMENT = 1');

        // Insert seed records
        foreach($roadblocks as $description)
        {
            Roadblock::create(array(
                'description' => $description
            ));
        }

        // Update autoincrement value to 101 to separate user-defined values from system defaults
        // Not really necessary unless we begin supporting custom roadblocks
        DB::statement('ALTER TABLE tags AUTO_INCREMENT = 101');

    }
}

