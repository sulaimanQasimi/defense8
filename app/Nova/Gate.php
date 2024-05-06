<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Gate extends Resource
{
    public static $model = \App\Models\Gate::class;
    public static $title = 'fa_name';
    public static $search = [
        'fa_name',
        'pa_name',
        'location',
        'level'
    ];


    public static function label()
    {
        return __('Gates');
    }

    public static function singularLabel()
    {
        return __('Gate');
    }

    public function fields(NovaRequest $request)
    {
        return [
            Text::make(__("Persion Name"), 'fa_name')
                ->required()
                ->creationRules('required', 'string', 'unique:gates,fa_name')
                ->creationRules('required', 'string', 'unique:gates,fa_name,{{resourceId}}'),
            Text::make(__("Pashto Name"), 'pa_name')
                ->required()
                ->creationRules('required', 'string', 'unique:gates,pa_name')
                ->creationRules('required', 'string', 'unique:gates,pa_name,{{resourceId}}'),
            Text::make(__("Location"), 'location')
                ->required()
                ->creationRules('required', 'string'),
            Number::make(__("Gate Level"), 'level')
                ->required()
                ->creationRules('required', 'numeric')
                ->creationRules('required', 'numeric')
                ->help(__("Use 1 For Main Gate")),
            HasMany::make(__("Users"), 'user', User::class)
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
