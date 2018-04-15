<?php

use Illuminate\Database\Seeder;
//use Illuminate\Database\Eloquent\Model;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(
            array(
                array(
                    'name' => 'BreezeChMS Admin',
                    'slug' => 'superadmin',
                    'created_at' => '2017-03-28 00:00:00',
                    'created_by'=>'1',
                    'updated_at' => '2017-03-28 00:00:00',
                    'updated_by'=>'1',
                    'status' => '1'
                ),
                array(
                    'name' => 'User',
                    'slug' => 'user',
                    'created_at' => '2017-03-28 00:00:00',
                    'created_by'=>'1',
                    'updated_at' => '2017-03-28 00:00:00',
                    'updated_by'=>'1',
                    'status' => '1'
                )
            )
        );
    }
}
