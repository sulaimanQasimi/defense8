<?php
namespace Sq\Query\Policy;
class UserDepartment
{
    public static function getUserDepartment(): array
    {
        return auth()->user()->departments()->pluck('departments.id')->toArray();
    }
    public static function getUserGate(): array
    {
        return auth()->user()->gates()->pluck('gates.id')->toArray();
    }public static function getUserGuestGate(): array
    {
        return auth()->user()->guest_allowed_doors()->pluck('gates.id')->toArray();
    }
}
