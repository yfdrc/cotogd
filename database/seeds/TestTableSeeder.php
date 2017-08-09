<?php

use Illuminate\Database\Seeder;

class TestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kechengs')->insert([
            'dianpu_id' => '2',
            'name' => '缺省',
            'ageMin' => '1',
            'ageMax' => '80',
            'quanZhong' => 1,
        ]);
        DB::table('kechengs')->insert([
            'dianpu_id' => '3',
            'name' => '缺省',
            'ageMin' => '1',
            'ageMax' => '80',
            'quanZhong' => 1,
        ]);

        DB::table('yonggongs')->insert([
            'dianpu_id' => '1',
            'name' => '曾凤',
            'tele' => '138******646',
            'job' => '管理员',
        ]);
        DB::table('yonggongs')->insert([
            'dianpu_id' => '2',
            'name' => 'Tina',
            'tele' => '138******646',
            'job' => '店长',
        ]);


        DB::table('jiazhangs')->insert([
            'id' => '20160001',
            'dianpu_id' => '2',
            'bh' => 'bh1',
            'name' => '妈妈1',
            'tele' => '妈妈手机1',
        ]);
        DB::table('jiazhangs')->insert([
            'id' => '20160002',
            'dianpu_id' => '2',
            'bh' => 'bh2',
            'name' => '妈妈2',
            'tele' => '妈妈手机2',
        ]);
        DB::table('jiazhangs')->insert([
            'id' => '20160003',
            'dianpu_id' => '2',
            'bh' => 'bh3',
            'name' => '妈妈3',
            'tele' => '妈妈手机3',
        ]);

        DB::table('xieyis')->insert([
            'name' => '20160001',
            'dianpu_id' => '2',
            'jiazhang_id' => '20160001',
            'date' => '2016/1/1',
            'kebao' => '课包1',
            'ksZw' => '5',
            'ksYw' => '5',
            'jinE' => '880',
            'guWen1' => '2',
            'isZZ' => false,
        ]);
        DB::table('xieyis')->insert([
            'name' => '20160002',
            'dianpu_id' => '2',
            'jiazhang_id' => '20160002',
            'date' => '2016/1/2',
            'kebao' => '课包2',
            'ksZw' => '10',
            'ksYw' => '10',
            'jinE' => '980',
            'guWen1' => '2',
            'isZZ' => false,
        ]);

        DB::table('xueyuans')->insert([
            'id' => '20160001',
            'dianpu_id' => '2',
            'bh' => 'xybh1',
            'jiazhang_id' => '20160001',
            'name' => 'xh11',
            'birthday' => '2016/1/1',
        ]);
        DB::table('xueyuans')->insert([
            'id' => '20160002',
            'dianpu_id' => '2',
            'bh' => 'xybh2',
            'jiazhang_id' => '20160001',
            'name' => 'xh12',
            'birthday' => '2016/1/2',
        ]);
        DB::table('xueyuans')->insert([
            'id' => '20160021',
            'bh' => 'xybh3',
            'dianpu_id' => '2',
            'jiazhang_id' => '20160002',
            'name' => 'xh21',
            'birthday' => '2016/2/1',
        ]);

        DB::table('koukes')->insert([
            'dianpu_id' => '2',
            'xueyuan_id' => '20160001',
            'kecheng_id' => '1',
            'studTime' => '2016/09/21',
            'studKs' => '1',
            'kcQz' => '1',
        ]);

    }
}
