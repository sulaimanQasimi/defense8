<?php
namespace Vehical\Contracts;

use Sq\Oil\Models\Oil;
use Sq\Oil\Models\OilDisterbution;
use Vehical\OilType;

trait Statistics
{

    public static function expend_petrol_oil(): mixed
    {
        $expend = OilDisterbution::where('oil_type', OilType::Petrole)->sum('oil_amount');
        return $expend;
    }
    public static function remain_petrol_oil(): mixed
    {
        $oil=Oil::where('oil_type', OilType::Petrole)->sum('oil_amount');

        return $oil-self::expend_petrol_oil();
    }
    public static function remain_diesel_oil(): mixed
    {
        $oil=Oil::where('oil_type', OilType::Diesel)->sum('oil_amount');
        return $oil-self::expend_diesel_oil();
    }
    public static function expend_diesel_oil(): mixed
    {
        $expend = OilDisterbution::where('oil_type', OilType::Diesel)->sum('oil_amount');
        return $expend;
    }

}
