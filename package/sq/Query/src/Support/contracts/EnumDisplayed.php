<?php
namespace Sq\Query\Support\Contracts;
trait EnumDisplayed
{

    public static function withLabelInArray()
    {
        $filtered = [];
        foreach (self::cases() as $case)
            $filtered[$case->name] = $case->value;

        return $filtered;
    }
    public static function InArray()
    {
        $filtered = [];
        foreach (self::cases() as $case)
            $filtered[] = $case->name;

        return $filtered;
    }

}
