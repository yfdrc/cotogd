<?php

namespace App\Providers;

use App\Model\Role;
use App\Model\Permission;
use App\Policies\RolePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * 应用的策略映射。
     *
     * @var array
     */
    protected $policies = [
        Role::class => RolePolicy::class,
    ];

    /**
     * 注册任意用户认证、用户授权服务。
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//        //以下内容需要注释后才重新建立数据库
//        $permissions = \App\Model\Permission::with('roles')->get();
//        foreach ($permissions as $permission) {
//            Gate::define($permission->name, function ($user) use ($permission) {
//                return $user->setPermission($permission);
//            });
//        }
    }
}