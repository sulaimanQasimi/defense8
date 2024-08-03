<?php

namespace Sq\Location\Nova;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class District extends Resource
{
    public static $model = \Sq\Location\Models\District::class;
    public static $title = 'name';
    public static $search = [
        'name','code'
    ];
    public static function label()
    {
        return __('Districts');
    }

    public static function singularLabel()
    {
        return __('District');
    }
    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make(trans("Province"),'province',Province::class)->searchable(),
            Text::make(trans("Name"), 'name')
                ->required()
                ->creationRules('required', 'unique:districts,name')
                ->updateRules('required', 'unique:districts,name,{{resourceId}}'),
        ];
    }

    public function cards(NovaRequest $request)
    {
        return [];
    }
    public function filters(NovaRequest $request)
    {
        return [];
    }

    public function lenses(NovaRequest $request)
    {
        return [];
    }
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
