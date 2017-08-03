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
        Schema::create('wxusers', function (Blueprint $table) {
            $table->string('openid', 64);
            $table->string('nickname', 32)->nullable();
            $table->string('remark', 128)->nullable();
            $table->string('address', 64)->nullable();
            $table->integer('groupid');
            $table->integer('subtime');
            $table->string('telephone', 32)->nullable();
            $table->string('xh1name', 32)->nullable();
            $table->string('xh2name', 32)->nullable();
            $table->string('xh3name', 32)->nullable();
            $table->timestamps();
            $table->primary('openid');
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
    }
}
