<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTongjiTable extends Migration
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

//        Schema::create('tjxieyis', function (Blueprint $table) {  //每个家长买课情况
//            $table->increments('id');
//            $table->integer('dianpu_id')->unsigned();
//            $table->integer('jiazhang_id')->unsigned();
//            $table->string('allname');
//            $table->integer('allksZw');
//            $table->integer('allksYw');
//            $table->float('alljinE');
//            $table->integer('allguWen1')->unsigned()->nullable();
//            $table->integer('allguWen2')->unsigned()->nullable();
//            $table->timestamps();
//            $table->unique(['dianpu_id','jiazhang_id']);
//            $table->foreign('jiazhang_id')->references('id')->on('jiazhangs')->onUpdate('cascade')->onDelete('cascade');
//            $table->foreign('dianpu_id')->references('id')->on('dianpus')->onUpdate('cascade')->onDelete('cascade');
//        });
        Schema::create('tjkoukes', function (Blueprint $table) {   //每个学员扣课情况
            $table->increments('id');
            $table->integer('dianpu_id')->unsigned();
            $table->integer('jiazhang_id')->unsigned()->nullable();
            $table->integer('xueyuan_id')->unsigned()->nullable();
            $table->string('xhqk',256)->nullable();
            $table->string('studQk',2048)->nullable();
            $table->integer('studKs')->default(0);
            $table->integer('zeheKs')->default(0);
            $table->boolean('isJz')->default(false);
            $table->timestamps();
            $table->unique(['dianpu_id','xueyuan_id','jiazhang_id']);
            $table->foreign('jiazhang_id') ->references('id') ->on('jiazhangs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('xueyuan_id') ->references('id') ->on('xueyuans')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('dianpu_id') ->references('id') ->on('dianpus')->onUpdate('cascade')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::drop('tjxieyis');
        Schema::dropifexists('tjkoukes');
    }
}
