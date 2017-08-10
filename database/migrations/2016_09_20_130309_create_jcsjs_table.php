<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJcsjsTable extends Migration
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
        Schema::create('yonggongs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dianpu_id')->unsigned();
            $table->string('name', 64);
            $table->string('tele', 64)->nullable();
            $table->string('job', 64)->nullable();
            $table->date('birthday')->nullable();
            $table->timestamps();
            $table->unique(['dianpu_id','name']);
            $table->foreign('dianpu_id') ->references('id') ->on('dianpus')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::create('kechengs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dianpu_id')->unsigned();
            $table->string('name', 64);
            $table->string('boach', 64)->nullable();
            $table->float('ageMin')->default(1);
            $table->float('ageMax')->default(60);
            $table->integer('skrsMin');
            $table->integer('skrsMax');
            $table->integer('skrs');
            $table->float('quanZhong')->default(1);
            $table->timestamps();
            $table->unique(['dianpu_id','name']);
            $table->foreign('dianpu_id') ->references('id') ->on('dianpus')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::create('jiazhangs', function (Blueprint $table) {
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
            $table->integer('buyDs')->default(0);
            $table->integer('buyZw')->default(0);
            $table->integer('buyYw')->default(0);
            $table->float('buyMoney')->default(0);
            $table->integer('studKssj')->default(0);
            $table->integer('studKszh')->default(0);
            $table->integer('leftKeshi')->default(0);
            $table->integer('leftKsds')->default(0);
            $table->timestamps();
            $table->unique(['dianpu_id','bh']);
            $table->unique(['dianpu_id','name']);
            $table->unique(['tele']);
            $table->foreign('dianpu_id') ->references('id') ->on('dianpus')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::create('xueyuans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dianpu_id')->unsigned();
            $table->integer('jiazhang_id')->unsigned();
            $table->string('bh', 64);
            $table->string('name', 64);
            $table->boolean('sexboy')->default(false)->nullable();
            $table->date('birthday')->nullable();
            $table->integer('studKssj')->default(0);
            $table->integer('studKszh')->default(0);
            $table->timestamps();
            $table->unique(['dianpu_id','bh']);
            $table->unique(['dianpu_id','name']);
            $table->foreign('dianpu_id') ->references('id') ->on('dianpus')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('jiazhang_id')->references('id')->on('jiazhangs')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::create('xieyis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dianpu_id')->unsigned();
            $table->integer('jiazhang_id')->unsigned();
            $table->string('name', 64);
            $table->date('date')->nullable();
            $table->string('kebao', 64)->nullable();
            $table->integer('ksDs')->default(0);
            $table->integer('ksZw')->default(0);
            $table->integer('ksYw')->default(0);
            $table->float('jinE')->default(0);
            $table->boolean('isZZ')->default(false);
            $table->integer('guWen1')->unsigned()->nullable();
            $table->integer('guWen2')->unsigned()->nullable();
            $table->timestamps();
            $table->unique(['dianpu_id','name']);
            $table->foreign('guWen1') ->references('id') ->on('yonggongs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('guWen2') ->references('id') ->on('yonggongs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('jiazhang_id')->references('id')->on('jiazhangs')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('dianpu_id')->references('id')->on('dianpus')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::create('koukes', function (Blueprint $table) {   //每门课程扣课情况
            $table->increments('id');
            $table->integer('dianpu_id')->unsigned();
            $table->integer('xueyuan_id')->unsigned();
            $table->integer('kecheng_id')->unsigned()->nullable();
            $table->string('studTime',10240)->nullable();
            $table->integer('studKs')->default(0);
            $table->float('kcQz')->default(1);
            $table->timestamps();
            $table->unique(['dianpu_id','xueyuan_id','kecheng_id']);
            $table->foreign('xueyuan_id') ->references('id') ->on('xueyuans')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('kecheng_id') ->references('id') ->on('kechengs')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropifexists('koukes');
        Schema::dropifexists('xieyis');
        Schema::dropifexists('xueyuans');
        Schema::dropifexists('jiazhangs');
        Schema::dropifexists('kechengs');
        Schema::dropifexists('yonggongs');
    }
}
