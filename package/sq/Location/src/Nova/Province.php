<?php
namespace Sq\Location\Nova;


use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sq\Employee\Nova\CardInfo;

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
            HasMany::make(trans("District"), 'districts', District::class),
            HasMany::make(trans("Villages"), 'villages', Village::class),
            HasMany::make(trans("Main Address"), 'main_employee_address', CardInfo::class),
            HasMany::make(trans("Current Address"), 'current_employee_address', CardInfo::class),

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
