<?php

use Illuminate\Database\Seeder;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert User Role
        DB::table('user_roles')->insert([
            'name' => 'Administrator'
        ]);

        DB::table('user_roles')->insert([
            'name' => 'User'
        ]);

        DB::table('user_roles')->insert([
            'name' => 'Artist'
        ]);
    }
}
