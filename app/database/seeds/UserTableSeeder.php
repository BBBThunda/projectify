<?php

class UserTableSeeder extends Seeder {

    public function run()
    {

        // Create one admin user
        User::create(array(
            'email' => 'admin@proj.ectify.com',
            'display_name' => 'Administrator',
            'password' => Hash::make('adminpassword'),
            'is_admin' => 1,
            'confirmed' => 1
        ));

        // Create one regular user
        User::create(array(
            'email' => 'user@proj.ectify.com',
            'display_name' => 'User',
            'password' => Hash::make('password'),
            'is_admin' => 0,
            'confirmed' => 1
        ));
    }
}
