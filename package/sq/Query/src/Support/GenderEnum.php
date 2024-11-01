<?php
namespace Sq\Query\Support;

use Sq\Query\Support\Contracts\EnumDisplayed;
enum GenderEnum: string
{
    use EnumDisplayed;

    case Male = "Male";
    case Female = "Female";
}
