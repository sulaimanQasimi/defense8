<?php
namespace Sq\Query\Support;

use Illuminate\Support\Traits\EnumeratesValues;
use Sq\Query\Support\Contracts\EnumDisplayed;
enum TashkeelStatus :string
{
    use EnumDisplayed;
    case Created ="ایجاد شده";
    case Processing="در حال برسی";
    case Published='به نشر رسیده';
    case Edited='تغییر یافته';
}
