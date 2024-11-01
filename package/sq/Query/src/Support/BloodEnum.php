<?php
namespace Sq\Query\Support;

use Sq\Query\Support\Contracts\EnumDisplayed;
enum BloodEnum: string
{
    use EnumDisplayed;
    case OM = 'O-';
    case OP = 'O+';
    case AM = 'A-';
    case AP = 'A+';
    case BM = 'B-';
    case BP = 'B+';
    case ABM = 'AB-';
    case ABP = 'AB+';
}
