<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

require_once "SystemTableSeeder.php";
require_once "PermissionTableSeeder.php";
require_once "RoleTableSeeder.php";
require_once "DianpuTableSeeder.php";
require_once "UserTableSeeder.php";
require_once "UserRoleTableSeeder.php";
require_once "RolePermissionTableSeeder.php";
require_once "TestTableSeeder.php";

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //使用说明
        //1、运行：php artisan migrate
        //2、运行：php artisan db:seed
        Model::unguard();

        $this->call(SystemTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RoleTableSeeder::class);
        $this->call(DianpuTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(UserRoleTableSeeder::class);
        $this->call(RolePermissionTableSeeder::class);
        $this->call(TestTableSeeder::class);

//        factory('App\Model\User', 2)->create()->each(function($u)  {
//            factory('App\Model\Role',10)->create();
//        });

        Model::reguard();
    }
}
