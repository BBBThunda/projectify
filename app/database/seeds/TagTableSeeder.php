<?php

class TagTableSeeder extends Seeder {

    public function run()
    {

        // List of tags 
        // DO NOT change the order of existing tags.  Append only.
        $tags = array('career', 'health', 'finances', 'customerX', 'education');

        // Empty the table first
        DB::table('tags')->delete();

        // Update autoincrement value to 1 in case table was not dropped
        DB::statement('ALTER TABLE tags AUTO_INCREMENT = 1');

        foreach($tags as $description)
        {
            Tag::create(array(
                'description' => $description
            ));
        }

    }
}

