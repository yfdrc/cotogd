<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'dianpu_id' => '1',
            'name' => 'yfdrc',
            'email' => 'gdyfqxdrc@qq.com',
            'password' => bcrypt('red123'),
        ]);
        DB::table('users')->insert([
            'dianpu_id' => '1',
            'name' => '曾凤',
            'email' => 'zf@qq.com',
            'password' => bcrypt('zf123'),
        ]);
        DB::table('users')->insert([
            'dianpu_id' => '2',
            'name' => 'Tina',
            'email' => 'tina@qq.com',
            'password' => bcrypt('tina123'),
        ]);
    }
}
