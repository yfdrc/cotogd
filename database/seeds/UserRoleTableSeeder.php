<?php

use Illuminate\Database\Seeder;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role_user')->insert([
            'user_id' => '1',
            'role_id' => '8',
        ]);
        DB::table('role_user')->insert([
            'user_id' => '2',
            'role_id' => '7',
        ]);
        DB::table('role_user')->insert([
            'user_id' => '3',
            'role_id' => '6',
        ]);
    }
}
