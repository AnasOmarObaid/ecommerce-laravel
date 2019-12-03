<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create default user for each role
        $user = \App\User::create([
            'first_name' => 'Super',
            'last_name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make(123123),
        ]);
        $user->attachRole('super_admin');
    }
}
