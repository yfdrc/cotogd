<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWxuserlistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wxgroups', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->string('name', 128);
            $table->timestamps();
            $table->primary('id');
        });
        Schema::create('wxusers', function (Blueprint $table) {
            $table->string('openid', 64);
            $table->string('nickname', 32)->nullable();
            $table->string('remark', 128)->nullable();
            $table->string('address', 64)->nullable();
            $table->integer('group_id')->unsigned()->default(0);
            $table->integer('subtime')->default(0);
            $table->string('telephone', 32)->nullable();
            $table->string('xh1name', 32)->nullable();
            $table->string('xh2name', 32)->nullable();
            $table->string('xh3name', 32)->nullable();
            $table->timestamps();
            $table->primary('openid');
            $table->foreign('group_id') ->references('id') ->on('wxgroups')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::create('wxqrs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('scene_id')->default(0);
            $table->string('scene_str', 128)->nullable();
            $table->string('EventKey', 128)->nullable();
            $table->string('ticket', 1024)->nullable();
            $table->string('url', 1024)->nullable();
            $table->integer('expire_seconds')->default(0);
            $table->boolean('istemp')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wxusers');
        Schema::dropIfExists('wxgroups');
        Schema::dropIfExists('wxqrs');
    }
}
