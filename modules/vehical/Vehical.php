<?php
namespace Vehical;
use Vehical\Contracts\Statistics;

class Vehical
{
    use Statistics;
    public static function oil_quality(): array
    {
        return [
            OilQuality::A24 => "A24",
        ];

    }
}
