<?php

namespace App\Nova;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource as NovaResource;

abstract class Resource extends NovaResource
{

    public static $trafficCop = false;
    public static $showPollingToggle = true;

    public static $perPageViaRelationship = 20;

    public static $perPageOptions = [25, 50, 100,150,200,300,500,1000];

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
