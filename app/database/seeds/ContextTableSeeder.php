<?php

class ContextTableSeeder extends Seeder {

    public function run()
    {
        DB::table('contexts')->delete();

        // Update autoincrement value to 1 in case table was not dropped
        DB::statement('ALTER TABLE tags AUTO_INCREMENT = 1');


        // List of contexts
        // DO NOT change the order of existing contexts.  Append only.
        $contexts = array('Home', 'Work', 'Phone', 'Computer');

        foreach($contexts as $description)
        {
            Context::create(array(
                'description' => $description
            ));
        }

        // Update autoincrement value to 100 so we can add/remove default system tags
        DB::statement('ALTER TABLE tags AUTO_INCREMENT = 1');


    }
}

