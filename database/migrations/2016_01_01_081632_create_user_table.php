<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserTable extends Migration
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
        Schema::create('systems', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 64);
            $table->string('desc', 4096);
            $table->string('memo', 4096)->nullable();
            $table->timestamps();
            $table->unique('name');
        });
        Schema::create('dianpus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 64);
            $table->string('description', 10240)->nullable();
            $table->string('telephone', 256)->nullable();
            $table->string('email', 256)->nullable();
            $table->string('address', 256)->nullable();
            $table->timestamps();
            $table->unique('name');
        });
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('dianpu_id')->unsigned();
            $table->string('name', 64);
            $table->string('email', 64);
            $table->string('password', 256);
            $table->rememberToken();
            $table->timestamps();
            $table->unique('email');
            $table->unique('name');
            $table->foreign('dianpu_id') ->references('id') ->on('dianpus')->onUpdate('cascade')->onDelete('cascade');
        });
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 64);
            $table->string('label', 64);
            $table->string('description', 256)->nullable();
            $table->timestamps();
            $table->unique('name');
            $table->unique('label');
        });
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 64);
            $table->string('label', 64);
            $table->string('description', 256)->nullable();
            $table->timestamps();
            $table->unique('name');
            $table->unique('label');
        });
        Schema::create('permission_role', function (Blueprint $table) {
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->foreign('permission_id') ->references('id') ->on('permissions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('role_id') ->references('id') ->on('roles')->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['permission_id', 'role_id']);
        });
        Schema::create('role_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id') ->references('id') ->on('roles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id') ->references('id') ->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['role_id', 'user_id']);
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropifexists('password_resets');
        Schema::dropifexists('role_user');
        Schema::dropifexists('permission_role');
        Schema::dropifexists('permissions');
        Schema::dropifexists('roles');
        Schema::dropifexists('users');
        Schema::dropifexists('dianpus');
        Schema::dropifexists('systems');
    }
}
