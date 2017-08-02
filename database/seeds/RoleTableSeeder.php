<?php

use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name' => 'readers',
            'label' => '查阅角色',
            'description' => '用于查阅基本数据',
        ]);
        DB::table('roles')->insert([
            'name' => 'creates',
            'label' => '新建角色',
            'description' => '用于新建基本数据',
        ]);
        DB::table('roles')->insert([
            'name' => 'editors',
            'label' => '编辑角色',
            'description' => '用于新建查编基本数据',
        ]);
        DB::table('roles')->insert([
            'name' => 'deletes',
            'label' => '删除角色',
            'description' => '用于新建查编删基本数据',
        ]);
        DB::table('roles')->insert([
            'name' => 'caiwus',
            'label' => '财务角色',
            'description' => '用于操作财务数据',
        ]);
        DB::table('roles')->insert([
            'name' => 'dianzhangs',
            'label' => '店长角色',
            'description' => '用于操作本店基本和财务数据',
        ]);
        DB::table('roles')->insert([
            'name' => 'managers',
            'label' => '经理角色',
            'description' => '用于操作所有店基本和财务数据',
        ]);
        DB::table('roles')->insert([
            'name' => 'admins',
            'label' => '管理员角色',
            'description' => '用于任何操作',
        ]);
    }
}
