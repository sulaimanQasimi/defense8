<?php

namespace Sq\Oil\Nova\Dashboards;

use Laravel\Nova\Dashboard;
use Sq\Oil\Nova\OilValueMetric;
use Vehical\OilType;

class OilDistribution extends Dashboard
{
    public function cards()
    {
        return [
            (new OilValueMetric(OilType::Petrole))
                ->icon('fas fa-gas-pump fa-2x')
                ->width('1/2'),

            (new OilValueMetric(OilType::Diesel))
                ->icon('fas fa-gas-pump fa-2x')
                ->width('1/2'),
       ];
    }

    /**
     * Get the URI key for the dashboard.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'oil-distribution';
    }

    public function name()
    {
        return trans("توزیع تیل");
    }
}
