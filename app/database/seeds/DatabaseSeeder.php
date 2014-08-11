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

                $this->call('UserTableSeeder');

                $this->command->info('User table seeded!');
	}

}

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        // Create one admin user
        User::create(array(
            'email' => 'admin@proj.ectify.com',
            'display_name' => 'Administrator',
            'password' => Hash::make('adminpassword'),
            'is_admin' => 1
        ));

        // Create one regular user
        User::create(array(
            'email' => 'user@proj.ectify.com',
            'display_name' => 'User',
            'password' => Hash::make('password'),
            'is_admin' => 0
        ));
    }
}
