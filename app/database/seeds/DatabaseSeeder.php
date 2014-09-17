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

        $tablesSeeded = 0;

        $this->command->info('SEEDING DATABASE');

        // For now we won't worry about deleting records... In the case of a migrate:refresh
        // or migrate:rollback a dropped/recreated table may result in an empty table anyway.
        // Keeping the code for now in case this changes.
        //
        // Empty all tables except users in proper order
        //$tablesEmptied = $this->call('EmptyTablesSeeder');
        //$this->command->info($tablesEmptied . ' tables emptied.');

        if (Schema::hasTable('roadblocks') && DB::table('roadblocks')->count('id') == 0) {
            $this->call('RoadblockTableSeeder');
            $tablesSeeded++;
            $this->command->info('roadblocks table seeded!');
        }

        if (Schema::hasTable('tags') && DB::table('tags')->count('id') == 0) {
            $this->call('TagTableSeeder');
            $tablesSeeded++;
            $this->command->info('tags table seeded!');
        }

        if (Schema::hasTable('contexts') && DB::table('contexts')->count('id') == 0) {
            $this->call('ContextTableSeeder');
            $tablesSeeded++;
            $this->command->info('contexts table seeded!');
        }

        if (Schema::hasTable('users') && DB::table('users')->count('id') == 0) {
            $this->call('UserTableSeeder');
            $tablesSeeded++;
            $this->command->info('users table seeded!');
        }

        $this->command->info('SEEDING COMPLETE: ' . $tablesSeeded . ' tables seeded.');

    }

}
