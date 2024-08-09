<?php

namespace App\Nova\Dashboards;

use App\Models\Video;
use Laravel\Nova\Cards\VideoCard;
use Laravel\Nova\Dashboard;

class EducationalVideo extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            (new VideoCard)->addVideoLinks(Video::pluck('link','title')
            ->map(function ($video,$key) {

                return asset('app/video/'.$video);
            })->toArray())
        ];
    }

    public function name()
    {
        return trans("Educational Videos of System");
    }
    /**
     * Get the URI key for the dashboard.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'educational-video';
    }
}
