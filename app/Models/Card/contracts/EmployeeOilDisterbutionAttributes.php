<?php
namespace App\Models\Card\Contracts;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Support\Defense;

trait EmployeeOilDisterbutionAttributes
{


    // Oil Disterbution
    protected function currentMonthOilConsumtion(): Attribute
    {
        return Attribute::make(
            get: function () {
                return \App\Models\OilDisterbution::where("card_info_id", $this->id)
                    ->whereBetween('filled_date', [Defense::start_of_month(), Defense::end_of_month()])
                    ->sum('oil_amount');
            },
        );
    }

    protected function currentMonthOilRemain(): Attribute
    {

        $consum = \App\Models\OilDisterbution::where("card_info_id", $this->id)
            ->whereBetween('filled_date', [Defense::start_of_month(), Defense::end_of_month()])
            ->sum('oil_amount');

        return Attribute::make(
            get: function () use ($consum) {
                return $this->monthly_rate - $consum;
            },
        );
    }
}
