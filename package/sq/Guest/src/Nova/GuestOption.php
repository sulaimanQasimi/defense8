<?php
namespace Sq\Guest\Nova;

use App\Nova\Resource;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class GuestOption extends Resource
{
    public static $model = \Sq\Guest\Models\GuestOption::class;
    public static $title = 'name';
    public static $search = [
        'name',
    ];

    public static function label()
    {
        return __('Options');
    }

    public static function singularLabel()
    {
        return __('Option');
    }

    public function fields(NovaRequest $request)
    {
        return [
            Text::make(__("Name"), 'name')
                ->required()
                ->creationRules('required', 'string', 'unique:guest_options,name')
                ->updateRules('required', 'string', 'unique:guest_options,name,{{resourceId}}')
                ->placeholder(__("Enter Field", ['name' => __("Name")])),
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

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
