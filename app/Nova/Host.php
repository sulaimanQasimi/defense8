<?php
namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class Host extends Resource
{
    public static $model = \App\Models\Host::class;

    public static $title = 'name';

    public static $search = [
        'name', 'head_name', 'phone', 'address', 'user.name', 'user.email'
    ];

    public static function label()
    {
        return __('Hosts');
    }

    public static function singularLabel()
    {
        return __('Host');
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        if (auth()->user()->host) {
            return $query->where('id', auth()->user()->host->id);
        }
        return $query;
    }



    public function fields(NovaRequest $request)
    {
        return [

            // Department Name
            Text::make(__("Department Name"), 'name')
                ->required()
                ->creationRules('required', 'string', 'unique:hosts,name')
                ->creationRules('required', 'string', 'unique:hosts,name,{{resourceId}}')
                ->placeholder(__("Enter Field", ['name' => __("Department Name")])),

            // Header Name
            Text::make(__("Header"), 'head_name')
                ->required()
                ->rules('required', 'string')
                ->placeholder(__("Enter Field", ['name' => __("Header")])),

            // Header Name
            Text::make(__("Job"), 'job')
                ->required()
                ->rules('required', 'string')
                ->placeholder(__("Enter Field", ['name' => __("Job")])),

            // Phone Number
            Text::make(__("Phone"), 'phone')
                ->required()
                ->rules('required', 'string')
                ->placeholder(__("Enter Field", ['name' => __("Phone")])),

            // Department Address
            Text::make(__("Department Address"), 'address')
                ->required()
                ->rules('required', 'string')
                ->placeholder(__("Enter Field", ['name' => __("Department Address")])),

            BelongsTo::make(__("User"), 'user', User::class)->showCreateRelationButton(),
            HasMany::make(__('Guests'),'guests', Guest::class),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
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
