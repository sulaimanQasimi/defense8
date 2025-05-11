<?php

namespace Sq\Oil\Nova;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Sq\Employee\Models\CardInfo;
use Sq\Oil\Models\PumpStation;
use Sq\Oil\Models\Oil;
use Sq\Oil\Models\OilDisterbution;
use Vehical\OilType;
use Illuminate\Support\Facades\DB;

class PumpStationMetric extends Value
{
    protected $type;
    protected $pumpStationId;
    protected $oilType;

    public function __construct($type, $pumpStationId, $oilType = null)
    {
        $this->type = $type;
        $this->pumpStationId = $pumpStationId;
        $this->oilType = $oilType;
    }

    public function calculate(NovaRequest $request)
    {
        $pumpStation = PumpStation::findOrFail($this->pumpStationId);

        switch ($this->type) {
            case 'income':
                $query = DB::table('oil')
                    ->where('pump_station_id', $this->pumpStationId);

                if ($this->oilType) {
                    $query->where('oil_type', $this->oilType);
                }

                $value = $query->sum('oil_amount');
                return $this->result($value)
                    ->format(['thousandSeparated' => true, 'mantissa' => 0])
                    ->suffix('لیتر');

            case 'distributed':
                $query = DB::table('oil_disterbutions')
                    ->where('pump_station_id', $this->pumpStationId);

                if ($this->oilType) {
                    $query->where('oil_type', $this->oilType);
                }

                $value = $query->sum('oil_amount');
                return $this->result($value)
                    ->format(['thousandSeparated' => true, 'mantissa' => 0])
                    ->suffix('لیتر');

            case 'remaining':
                $incomeQuery = DB::table('oil')
                    ->where('pump_station_id', $this->pumpStationId);

                $distributedQuery = DB::table('oil_disterbutions')
                    ->where('pump_station_id', $this->pumpStationId);

                if ($this->oilType) {
                    $incomeQuery->where('oil_type', $this->oilType);
                    $distributedQuery->where('oil_type', $this->oilType);
                }

                $income = $incomeQuery->sum('oil_amount');
                $distributed = $distributedQuery->sum('oil_amount');

                $value = $income - $distributed;

                return $this->result($value)
                    ->format(['thousandSeparated' => true, 'mantissa' => 0])
                    ->suffix('لیتر');

            case 'needed':
                // Calculate remaining oil by type or total
                $incomeQuery = DB::table('oil')
                    ->where('pump_station_id', $this->pumpStationId);

                $distributedQuery = DB::table('oil_disterbutions')
                    ->where('pump_station_id', $this->pumpStationId);

                if ($this->oilType) {
                    $incomeQuery->where('oil_type', $this->oilType);
                    $distributedQuery->where('oil_type', $this->oilType);
                }

                $income = $incomeQuery->sum('oil_amount');
                $distributed = $distributedQuery->sum('oil_amount');

                $remaining = $income - $distributed;

                // Calculate total monthly quota for all employees at this pump station
                $quotaQuery = DB::table('card_infos')
                    ->where('pump_station_id', $this->pumpStationId);

                if ($this->oilType) {
                    $quotaQuery->where('oil_type', $this->oilType);
                }

                $totalMonthlyQuota = $quotaQuery->sum('monthly_rate');

                // Calculate needed oil based on total monthly quota and remaining
                $value = max(0, $totalMonthlyQuota - $remaining);

                return $this->result($value)
                    ->format(['thousandSeparated' => true, 'mantissa' => 0])
                    ->suffix('لیتر');
        }

        return $this->result(0);
    }

    public function name()
    {
        $oilTypeName = '';
        if ($this->oilType === OilType::Diesel) {
            $oilTypeName = 'دیزل - ';
        } elseif ($this->oilType === OilType::Petrole) {
            $oilTypeName = 'پطرول - ';
        }

        switch ($this->type) {
            case 'income':
                return $oilTypeName . 'مجموع واردات';
            case 'distributed':
                return $oilTypeName . 'مجموع توزیع شده';
            case 'remaining':
                return $oilTypeName . 'باقی مانده';
            case 'needed':
                return $oilTypeName . 'مقدار مورد نیاز';
            default:
                return '';
        }
    }

    public function uriKey()
    {
        $oilTypePart = $this->oilType ? '-' . strtolower($this->oilType) : '';
        return 'pump-station-' . $this->type . $oilTypePart . '-metric-' . $this->pumpStationId;
    }
}
