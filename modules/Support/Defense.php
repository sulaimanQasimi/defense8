<?php
namespace Support;

use Hekmatinasser\Verta\Facades\Verta;

class Defense
{

    public static function start_of_month()
    {
        $start_month = Verta::startMonth()->format("Y-m-d");
        return Verta::parse($start_month)->toCarbon();
    }
    public static function end_of_month()
    {
        $end_month = Verta::endMonth()->format("Y-m-d");
        return Verta::parse($end_month)->toCarbon();
    }
}
