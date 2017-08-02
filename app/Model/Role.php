<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function givePermissionTo($permission)
    {
        return $this->permissions()->save($permission);
    }

    //给角色添加权限

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
