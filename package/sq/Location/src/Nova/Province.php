<?php
namespace Sq\Location\Nova;


use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Province extends Resource
{
    public static $model = \Sq\Location\Models\Province::class;
    public static $title = 'name';
    public static $search = [
        'name',
        'code'
    ];

    public static function label()
    {
        return __('Provinces');
    }

    public static function singularLabel()
    {
        return __('Province');
    }
    public function fields(NovaRequest $request)
    {
        return [
            Text::make(trans("Name"), 'name')
                ->required()
                ->creationRules('required', 'unique:provinces,name')
                ->updateRules('required', 'unique:provinces,name,{{resourceId}}'),
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
