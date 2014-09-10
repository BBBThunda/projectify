<?php

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
