<?php
namespace Sq\Query\Support;

use Sq\Query\Support\Contracts\EnumDisplayed;
enum TashkeelType :string
{
    use EnumDisplayed;
    case Military="نظامی";
    case Civilian="ملکی";
}
