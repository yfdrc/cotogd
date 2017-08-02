<?php

use Illuminate\Database\Seeder;

class DianpuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dianpus')->insert([
            'name' => '总公司',
            'description' => '用于管理各店铺',
            'telephone' => '138*****646',
            'email' => 'zf@qq.com',
            'address' =>'总公司地址',
        ]);
        DB::table('dianpus')->insert([
            'name' => '巴西运动学院',
            'description' => '巴西运动学院',
            'telephone' => '2869218<br>2870218',
            'email' => 'bxyd@qq.com',
            'address' =>'广百时代广场1楼',
        ]);
        DB::table('dianpus')->insert([
            'name' => '乐涂涂',
            'description' => '乐涂涂',
            'telephone' => '2267979<br>2267279',
            'email' => 'ltt@qq.com',
            'address' =>'广百时代广场四楼购书中心内A3区',
        ]);
    }
}
