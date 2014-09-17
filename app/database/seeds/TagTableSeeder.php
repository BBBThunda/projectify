<?php

class TagTableSeeder extends Seeder {

    public function run()
    {

        // List of tags 
        // DO NOT change the order of existing tags.  Append only.
        $tags = array('career', 'health', 'finances', 'customerX', 'education');

        // Update autoincrement value to 1 in case table was not dropped
        DB::statement('ALTER TABLE tags AUTO_INCREMENT = 1');

        // Insert seed records
        foreach($tags as $description)
        {
            Tag::create(array(
                'description' => $description
            ));
        }

        // Update autoincrement value to 101 to separate user-defined values from system defaults
        DB::statement('ALTER TABLE tags AUTO_INCREMENT = 101');

    }
}

