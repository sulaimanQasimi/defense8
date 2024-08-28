<?php

namespace App\Policies;
use Illuminate\Database\Eloquent\Model;


class RolePolicy extends BasePolicy {
    protected $key = 'role';
    public function delete(Model $user, $model)
    {
        return false;
    }
    public function forceDelete(Model $user, $model)
    {
        return false;
    }
    public function restore(Model $user, $model)
    {
        return false;
    }
}
