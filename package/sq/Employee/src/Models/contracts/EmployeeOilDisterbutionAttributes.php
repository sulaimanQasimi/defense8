<?php
namespace Sq\Employee\Models\Contracts;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Support\Defense;
use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Database\Eloquent\Builder;

trait EmployeeOilDisterbutionAttributes
{
    public function scopeFilterByPumpStation(Builder $query, $pumpStationId)
    {
        return $query->where('pump_station_id', $pumpStationId);
    }

    // Oil Disterbution
    protected function currentMonthOilConsumtion(): Attribute
    {
        return Attribute::make(
            get: function () {
                return \Sq\Oil\Models\OilDisterbution::where("card_info_id", $this->id)
                    ->whereBetween('filled_date', [Defense::start_of_month(), Defense::end_of_month()])
                    ->sum('oil_amount');
            },
        );
    }

    protected function currentMonthOilRemain(): Attribute
    {

        $consum = \Sq\Oil\Models\OilDisterbution::where("card_info_id", $this->id)
            ->whereBetween('filled_date', [Defense::start_of_month(), Defense::end_of_month()])
            ->sum('oil_amount');

        return Attribute::make(
            get: function () use ($consum) {
                return $this->monthly_rate - $consum;
            },
        );
    }
}
