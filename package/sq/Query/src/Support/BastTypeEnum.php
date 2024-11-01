<?php
namespace Sq\Query\Support;

use Illuminate\Contracts\Support\DeferringDisplayableValue;
use Sq\Query\Support\Contracts\EnumDisplayed;
enum BastTypeEnum: string
{
use EnumDisplayed;
    case Bast = "بست";
    case ThsClass = "تی اچ اس";
    case Other = "غیره";
}
