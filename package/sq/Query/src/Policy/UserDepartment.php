<?php
namespace Sq\Query\Policy;
use Illuminate\Support\Facades\Cache;
class UserDepartment
{
    public static function getUserDepartment(): array
    {
        return auth()->user()->departments()->pluck('departments.id')->toArray();
    }
    public static function getUserGate(): array
    {
        return auth()->user()->gates()->pluck('gates.id')->toArray();
    }
}
