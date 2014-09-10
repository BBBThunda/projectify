<?php

class RoadblockTableSeeder extends Seeder {

    public function run()
    {

        DB::table('roadblocks')->delete();

        //TODO: Add query to update autoincrement value to 0

        // List of roadblocks
        // DO NOT change the order of existing roadblocks.  Append only.
        $roadblocks = array(
            'Waiting on Contact', 
            'Waiting on Project', 
            'Waiting on Event'
        );

        foreach($roadblocks as $description)
        {
            Roadblock::create(array(
                'description' => $description
            ));
        }

        //TODO: Add query to update autoincrement value to 100

    }
}

