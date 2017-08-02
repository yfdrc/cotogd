<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExcelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //php artisan migrate
    public function up()
    {
        //使用说明
        //1、运行：php artisan migrate
        //2、运行：php artisan db:seed
        //3、回滚：php artisan migrate:rollback
        Schema::create('excelzbjzs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dianpu_id')->unsigned();
            $table->string('jzbh',64);
            $table->string('moname',64)->nullable();
            $table->string('motele',64)->nullable();
            $table->string('faname',64)->nullable();
            $table->string('fatele',64)->nullable();
            $table->string('xhname1',64);
            $table->string('xhbirth1',64);
            $table->string('xhsex1',2);
            $table->string('xhname2',64)->nullable();
            $table->string('xhbirth2',64)->nullable();
            $table->string('xhsex2',2)->nullable();
            $table->string('xhname3',64)->nullable();
            $table->string('xhbirth3',64)->nullable();
            $table->string('xhsex3',2)->nullable();
            $table->string('addr',1024)->nullable();
            $table->string('hqqd',64)->nullable();
            $table->string('quyu',64)->nullable();
            $table->string('pksj',1024)->nullable();
            $table->boolean('addFlag')->default(false);
            $table->boolean('addxyFlag')->default(false);
            $table->timestamps();
        });
        Schema::create('excelzbxies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dianpu_id')->unsigned();
            $table->string('jzbh',64);
            $table->string('xybh',64);
            $table->string('qysj',64)->nullable();
            $table->string('kebao',64)->nullable();
            $table->string('kszw',64)->nullable();
            $table->string('ksyw',64)->nullable();
            $table->string('jine',64)->nullable();
            $table->string('zffs',64)->nullable();
            $table->string('gw1',64)->nullable();
            $table->string('gw2',64)->nullable();
            $table->boolean('addFlag')->default(false);
            $table->boolean('addygFlag')->default(false);
            $table->timestamps();
        });
        Schema::create('excelkkbs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dianpu_id')->unsigned();
            $table->string('jzbh',64);
            $table->string('xybh',64);
            $table->string('xyname',64);
            $table->string('kcname',64);
            $table->string('sksj',10240)->nullable();
            $table->float('sks')->default(0);
            $table->float('kcQz')->default(0);
            $table->boolean('addFlag')->default(false);
            $table->boolean('addkcFlag')->default(false);
            $table->timestamps();
        });

        Schema::create('exceloutzbs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dianpu_id')->unsigned();
            $table->string('jzbh',64);
            $table->string('moname',64)->nullable();
            $table->string('motele',64)->nullable();
            $table->string('faname',64)->nullable();
            $table->string('fatele',64)->nullable();
            $table->string('xhname1',64)->nullable();
            $table->string('xhbirth1',64)->nullable();
            $table->string('xhsex1',2)->nullable();
            $table->string('xhname2',64)->nullable();
            $table->string('xhbirth2',64)->nullable();
            $table->string('xhsex2',2)->nullable();
            $table->string('xhname3',64)->nullable();
            $table->string('xhbirth3',64)->nullable();
            $table->string('xhsex3',2)->nullable();
            $table->string('addr',1024)->nullable();
            $table->string('hqqd',64)->nullable();
            $table->string('quyu',64)->nullable();
            $table->string('pksj',1024)->nullable();
            $table->string('xybh1',64)->nullable();
            $table->string('qysj1',64)->nullable();
            $table->string('kebao1',64)->nullable();
            $table->string('kszw1',64)->nullable();
            $table->string('ksyw1',64)->nullable();
            $table->string('jine1',64)->nullable();
            $table->string('zffs1',64)->nullable();
            $table->string('gw11',64)->nullable();
            $table->string('gw21',64)->nullable();
            $table->string('xybh2',64)->nullable();
            $table->string('qysj2',64)->nullable();
            $table->string('kebao2',64)->nullable();
            $table->string('kszw2',64)->nullable();
            $table->string('ksyw2',64)->nullable();
            $table->string('jine2',64)->nullable();
            $table->string('zffs2',64)->nullable();
            $table->string('gw12',64)->nullable();
            $table->string('gw22',64)->nullable();
            $table->string('xybh3',64)->nullable();
            $table->string('qysj3',64)->nullable();
            $table->string('kebao3',64)->nullable();
            $table->string('kszw3',64)->nullable();
            $table->string('ksyw3',64)->nullable();
            $table->string('jine3',64)->nullable();
            $table->string('zffs3',64)->nullable();
            $table->string('gw13',64)->nullable();
            $table->string('gw23',64)->nullable();
            $table->string('xybh4',64)->nullable();
            $table->string('qysj4',64)->nullable();
            $table->string('kebao4',64)->nullable();
            $table->string('kszw4',64)->nullable();
            $table->string('ksyw4',64)->nullable();
            $table->string('jine4',64)->nullable();
            $table->string('zffs4',64)->nullable();
            $table->string('gw14',64)->nullable();
            $table->string('gw24',64)->nullable();
//            $table->timestamps();
        });
        Schema::create('exceloutkkbs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dianpu_id')->unsigned();
            $table->string('jzbh',64)->nullable();
            $table->string('jzname',64)->nullable();
            $table->string('xhshu',64)->nullable();
            $table->string('xybh',64)->nullable();
            $table->string('xyname',64)->nullable();
            $table->string('htbh',64)->nullable();
            $table->string('htsm',64)->nullable();
            $table->string('htds',64)->nullable();
            $table->string('htzw',64)->nullable();
            $table->string('htyw',64)->nullable();
            $table->string('kcqz',64)->nullable();
            $table->string('kcname',64)->nullable();
            $table->string('sksj',10240)->nullable();
//            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropifexists('exceloutzbs');
        Schema::dropifexists('exceloutkkbs');
        Schema::dropifexists('excelzbjzs');
        Schema::dropifexists('excelzbxies');
        Schema::dropifexists('excelkkbs');
    }
}
