<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\EmpolyeeTrends;
use App\Nova\Metrics\GuestCount;
use App\Nova\Metrics\GunTrends;
use App\Nova\Metrics\PresentEmployeeMetric;
use App\Nova\Metrics\TodayEnterGuestMetric;
use App\Nova\Metrics\TodayExitEmployeeMetric;
use App\Nova\Metrics\TodayExitGuestMetric;
use App\Nova\Metrics\TodayGuest;
use App\Nova\Metrics\TodayPresentEmployee;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            GuestCount::make()->icon('academic-cap'),
            new EmpolyeeTrends,
            new GunTrends,
            new TodayGuest,
            new PresentEmployeeMetric,
            new TodayExitEmployeeMetric,
            TodayEnterGuestMetric::make()->icon('login'),
            TodayExitGuestMetric::make()->icon('logout'),
            TodayPresentEmployee::make(),

        ];
    }


    public function name(){
        return __('Dashboard');

    }
}
