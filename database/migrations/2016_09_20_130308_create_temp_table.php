<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTempTable extends Migration
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
        Schema::create('tempyonggongs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dianpu_id')->unsigned();
            $table->string('name', 64);
            $table->string('tele', 64)->nullable();
            $table->string('job', 64)->nullable();
            $table->date('birthday')->nullable();
            $table->boolean('addFlag')->default(false);
            $table->timestamps();
            $table->unique(['dianpu_id','name']);
            $table->foreign('dianpu_id')->references('id')->on('dianpus')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::create('tempkechengs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dianpu_id')->unsigned();
            $table->string('name', 64);
            $table->string('boach', 64)->nullable();
            $table->float('ageMin');
            $table->float('ageMax');
            $table->float('quanZhong');
            $table->boolean('addFlag')->default(false);
            $table->timestamps();
            $table->unique(['dianpu_id','name']);
            $table->foreign('dianpu_id')->references('id')->on('dianpus')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::create('tempjiazhangs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dianpu_id')->unsigned();
            $table->string('bh', 64);
            $table->string('name', 64);
            $table->string('tele', 64);
            $table->string('name2', 64)->nullable();
            $table->string('tele2', 64)->nullable();
            $table->string('hAddress', 128)->nullable();
            $table->string('howGet', 64)->nullable();
            $table->string('region', 64)->nullable();
            $table->string('whenStud', 1024)->nullable();
            $table->boolean('addFlag')->default(false);
            $table->timestamps();
            $table->unique(['dianpu_id','bh']);
            $table->unique(['dianpu_id','name']);
            $table->unique(['dianpu_id','tele']);
            $table->foreign('dianpu_id')->references('id')->on('dianpus')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::create('tempxueyuans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dianpu_id')->unsigned();
            $table->string('jzbh',64);
            $table->string('bh', 64);
            $table->string('name',64);
            $table->string('sex');
            $table->date('birth')->nullable();
            $table->boolean('addFlag')->default(false);
            $table->timestamps();
            $table->unique(['dianpu_id','bh']);
            $table->unique(['dianpu_id','name']);
            $table->foreign('dianpu_id')->references('id')->on('dianpus')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::create('tempxieyis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dianpu_id')->unsigned();
            $table->string('name', 64);
            $table->string('jzbh',64);
            $table->date('date')->nullable();
            $table->string('kebao', 64)->nullable();
            $table->integer('ksZw');
            $table->integer('ksYw');
            $table->float('jinE');
            $table->boolean('isZZ');
            $table->string('guWen1',64);
            $table->string('guWen2',64);
            $table->boolean('addFlag')->default(false);
            $table->timestamps();
            $table->unique(['dianpu_id','name']);
            $table->foreign('dianpu_id')->references('id')->on('dianpus')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::create('tempkoukes', function (Blueprint $table) {   //每门课程扣课情况
            $table->increments('id');
            $table->integer('dianpu_id')->unsigned();
            $table->string('xybh',64);
            $table->string('kcname',64);
            $table->string('studTime',10240)->nullable();
            $table->integer('studKs');
            $table->boolean('addFlag')->default(false);
            $table->timestamps();
            $table->unique(['dianpu_id','xybh','kcname']);
            $table->foreign('dianpu_id')->references('id')->on('dianpus')->onUpdate('cascade')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropifexists('tempkoukes');
        Schema::dropifexists('tempxieyis');
        Schema::dropifexists('tempxueyuans');
        Schema::dropifexists('tempjiazhangs');
        Schema::dropifexists('tempkechengs');
        Schema::dropifexists('tempyonggongs');
    }
}
