<?php
namespace App\Policies;

use Illuminate\Database\Eloquent\Model;
class PermissionPolicy extends BasePolicy
{
    protected $key = 'permission';
    public function create(Model $user)
    {
        return false;
    }
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
