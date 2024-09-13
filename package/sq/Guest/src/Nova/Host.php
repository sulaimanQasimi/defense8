<?php
namespace Sq\Guest\Nova;

use App\Nova\Resource;
use App\Nova\User;
use DigitalCreative\MegaFilter\MegaFilter;
use DigitalCreative\MegaFilter\MegaFilterTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sq\Employee\Nova\Department;
use Sq\Query\Policy\UserDepartment;
use Sq\Query\SqNovaSelectFilter;
use Sq\Query\SqNovaTextFilter;

class Host extends Resource
{
    use MegaFilterTrait;
    public static $model = \Sq\Guest\Models\Host::class;

    public static $title = 'department.fa_name';

    public static $search = [
        'department.fa_name',
        'head_name',
        'phone',
        'address',
        'user.name',
        'user.email'
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


        return $query->whereIn('department_id', UserDepartment::getUserDepartment());
    }



    public function fields(NovaRequest $request)
    {
        return [

            BelongsTo::make(__("Department/Chancellor"), 'department', Department::class)
                ->relatableQueryUsing(function (NovaRequest $request, Builder $query) {
                    $query->whereIn('id', UserDepartment::getUserDepartment());
                })

                ->filterable()
                ->sortable()
                ->searchable(),

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

            // User
            BelongsTo::make(__("User"), 'user', User::class)
                ->rules('required', 'unique:hosts,user_id')
                ->showCreateRelationButton()->searchable(),
            HasMany::make(__('Guests'), 'guests', Guest::class),
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
        return [
            MegaFilter::make([
                // Department
                new SqNovaSelectFilter(
                    label: __("Department/Chancellor"),
                    column: 'department_id',
                    options: \Sq\Employee\Models\Department::pluck('fa_name', 'id')->toArray()
                ),

                // Header Name
                new SqNovaTextFilter(label: __("Header"), column: 'head_name'),

                // Header Name
                new SqNovaTextFilter(label: __("Job"), column: 'job'),

                // Phone Number
                new SqNovaTextFilter(label: __("Phone"), column: 'phone'),

                // Department Address
                new SqNovaTextFilter(label: __("Department Address"), column: 'address'),
            ])->columns(3),
        ];
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
