<?php

use Illuminate\Database\Seeder;

class SystemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('systems')->insert([
            'name' => 'about',
            'desc' => '关于系统',
            'memo' => '本系统主要通过Excel文件导入数据用于查询和统计。',
        ]);
    }
}
