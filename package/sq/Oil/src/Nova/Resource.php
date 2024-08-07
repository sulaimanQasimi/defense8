<?php

namespace Sq\Oil\Nova;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\OilNovaResource;

abstract class Resource extends OilNovaResource
{

    public static $trafficCop = false;
    public static $showPollingToggle = true;

    public static $perPageViaRelationship = 20;

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    public static function scoutQuery(NovaRequest $request, $query)
    {
        return $query;
    }
    public static function detailQuery(NovaRequest $request, $query)
    {
        return parent::detailQuery($request, $query);
    }

    public static function relatableQuery(NovaRequest $request, $query)
    {
        return parent::relatableQuery($request, $query);
    }

    public static function perPageOptions()
    {
        return [20, 50, 75, 100, 150];
    }
}
