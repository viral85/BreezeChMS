<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'role_id' => '1',
            'name' => 'BreezeChMS Admin', 
            'email' => 'admin@breezechms.com',
            'password' => '$2y$10$tNxqWWEbEfHksxeJDFkRgeZN09naxQTvRAhRbdEdrfnuxFuc2rlwK',
            'address' => '',
            'phone' => ''
        ]);
    }
}