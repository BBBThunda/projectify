<?php

class ContextTableSeeder extends Seeder {

    public function run()
    {
        
        // List of contexts to insert
        // DO NOT change the order of existing contexts.  Append only.
        $contexts = array('Home', 'Work', 'Phone', 'Computer');

        // Insert seed records
        foreach($contexts as $description)
        {
            Context::create(array(
                'description' => $description
            ));
        }

        // Update autoincrement value to 101 to separate user-defined values from system defaults
        DB::statement('ALTER TABLE tags AUTO_INCREMENT = 101');

    }
}

