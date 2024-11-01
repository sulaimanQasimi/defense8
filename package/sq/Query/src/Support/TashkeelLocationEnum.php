<?php
namespace Sq\Query\Support;

use Sq\Query\Support\Contracts\EnumDisplayed;
enum TashkeelLocationEnum :string{
    use EnumDisplayed;
    case Internal = 'داخل وزارت';
    case External = "بیرون وزارت";
}
