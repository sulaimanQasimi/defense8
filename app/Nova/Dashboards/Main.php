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
            GuestCount::make()->icon('fas fa-person-shelter fa-2x'),
            EmpolyeeTrends::make()->icon('fa fa-user-plus fa-2x'),
            GunTrends::make()->icon('fas fa-gun fa-2x'),
            
            // Guest Report
            TodayGuest::make()->icon('fas fa-person-shelter fa-2x'),
            TodayEnterGuestMetric::make()->icon('fas fa-person-walking fa-2x'),
            TodayExitGuestMetric::make()->icon('fas fa-person-walking-arrow-loop-left fa-2x'),

            // Empolyee Report
            PresentEmployeeMetric::make()->icon("fas fa-person-circle-check fa-2x"),
            TodayExitEmployeeMetric::make()->icon('fas fa-person-walking-arrow-loop-left fa-2x'),
            TodayPresentEmployee::make()->icon('fas fa-person-circle-check fa-2x'),


        ];
    }


    public function name()
    {
        return __('Dashboard');

    }
}
