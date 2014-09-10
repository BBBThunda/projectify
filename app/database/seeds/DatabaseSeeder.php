<?php

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Eloquent::unguard();

        $this->command->info('SEEDING DATABASE');

        $tablesSeeded = 0;

        if (Schema::hasTable('users'))
        {
            $this->call('UserTableSeeder');
            $tablesSeeded++;
            $this->command->info('users table seeded!');
        }

        if (Schema::hasTable('roadblocks'))
        {
            $this->call('RoadblockTableSeeder');
            $tablesSeeded++;
            $this->command->info('roadblocks table seeded!');
        }

        if (Schema::hasTable('tags'))
        {
            $this->call('TagTableSeeder');
            $tablesSeeded++;
            $this->command->info('tags table seeded!');
        }

        if (Schema::hasTable('contexts'))
        {
            $this->call('ContextTableSeeder');
            $tablesSeeded++;
            $this->command->info('contexts table seeded!');
        }

        $this->command->info('SEEDING COMPLETE: ' . $tablesSeeded . ' tables seeded.');

    }

}
