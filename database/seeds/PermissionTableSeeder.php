<?php

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            'name' => 'view',
            'label' => '查阅权限',
            'description' => '可以查阅基本数据',
        ]);
        DB::table('permissions')->insert([
            'name' => 'create',
            'label' => '新建权限',
            'description' => '可以新建基本数据',
        ]);
        DB::table('permissions')->insert([
            'name' => 'update',
            'label' => '编辑权限',
            'description' => '可以新建查阅编辑基本数据',
        ]);
        DB::table('permissions')->insert([
            'name' => 'delete',
            'label' => '删除权限',
            'description' => '可以新建查阅编辑删除基本数据',
        ]);
        DB::table('permissions')->insert([
            'name' => 'caiwu',
            'label' => '财务权限',
            'description' => '可以操作财务数据',
        ]);
        DB::table('permissions')->insert([
            'name' => 'dianzhang',
            'label' => '店长权限',
            'description' => '可以操作本店基本和财务数据',
        ]);
        DB::table('permissions')->insert([
            'name' => 'manage',
            'label' => '经理权限',
            'description' => '可以操作所有店基本和财务数据',
        ]);
        DB::table('permissions')->insert([
            'name' => 'admin',
            'label' => '管理员权限',
            'description' => '拥有终极权限',
        ]);
    }
}
