<?php

namespace App\Policies;

use App\Model\User;
use App\Model\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the role.
     *
     * @param  \App\Model\User $user
     * @param  \App\Model\Role $role
     * @return mixed
     */
    public function view(User $user, Role $role)
    {
//        return  $user->hasPermissions(['read-post','edit-post']);
        return $user->hasPermission('view');
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \App\Model\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermission('create');
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param  \App\Model\User $user
     * @param  \App\Model\Role $role
     * @return mixed
     */
    public function update(User $user, Role $role)
    {
        return $user->hasPermission('update');
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param  \App\Model\User $user
     * @param  \App\\ModelRole  $role
     * @return mixed
     */
    public function delete(User $user, Role $role)
    {
        return $user->hasPermission('delete');
    }

    public function caiwu(User $user, Role $role)
    {
        return $user->hasPermission('caiwu');
    }

    public function dianzhang(User $user, Role $role)
    {
        return $user->hasPermission('dianzhang');
    }

    public function manage(User $user, Role $role)
    {
        return $user->hasPermission('manage');
    }

    public function admin(User $user, Role $role)
    {
        return $user->hasPermission('admin');
    }
}
