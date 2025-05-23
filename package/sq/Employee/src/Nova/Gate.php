<?php

namespace Sq\Employee\Nova;

use App\Models\User;
use App\Nova\Resource;
use DigitalCreative\MegaFilter\MegaFilter;
use DigitalCreative\MegaFilter\MegaFilterTrait;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sq\Employee\Models\Department;
use Sq\Query\Policy\UserDepartment;
use Sq\Query\SqNovaSelectFilter;
use Sq\Query\SqNovaTextFilter;

class Gate extends Resource
{
    use MegaFilterTrait;
    public static $model = \Sq\Employee\Models\Gate::class;
    public static $title = 'fa_name';
    public static $search = [
        'fa_name',
        'pa_name',
        'location',
        'level',
        'department.fa_name'
    ];
    public static function label()
    {
        return __('Gates');
    }

    public static function singularLabel()
    {
        return __('Gate');
    }


    public function subtitle()
    {
        return $this->department->fa_name;
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->whereIn('department_id', UserDepartment::getUserDepartment());
    }

    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make(__("Department/Chancellor"), 'department', \Sq\Employee\Nova\Department::class)
                ->relatableQueryUsing(function (NovaRequest $request, Builder $query) {
                    $query->whereIn('id', UserDepartment::getUserDepartment());
                })
                ->filterable()
                ->sortable(),
            Text::make(__("Persion Name"), 'fa_name')
                ->required()
                ->creationRules('required', 'string', 'unique:gates,fa_name')
                ->creationRules('required', 'string', 'unique:gates,fa_name,{{resourceId}}'),
            Text::make(__("Pashto Name"), 'pa_name')
                ->required()
                ->creationRules('required', 'string', 'unique:gates,pa_name')
                ->creationRules('required', 'string', 'unique:gates,pa_name,{{resourceId}}'),
            Number::make(__("Gate Level"), 'level')
                ->required()
                ->creationRules('required', 'numeric')
                ->creationRules('required', 'numeric')
                ->help(__("Use 1 For Main Gate")),
            HasMany::make(__("Employees"), 'cardInfos', CardInfo::class),
            HasMany::make(__("Users"), 'user', \App\Nova\User::class),
            HasMany::make(name: __("Scaned Employee"), attribute: 'scaned_employee', resource: ScanedEmployee::class)

        ];
    }
    public function cards(NovaRequest $request)
    {
        return [];
    }

    public function filters(NovaRequest $request)
    {
        return [

            MegaFilter::make([
                // Department
                new SqNovaSelectFilter(
                    label: __("Department/Chancellor"),
                    column: 'department_id',
                    options: Department::pluck('fa_name', 'id')->toArray()
                ),
                new SqNovaTextFilter(label: trans("Name"), column: 'fa_name'),

                new SqNovaTextFilter(label: trans("Pashto Name"), column: 'pa_name'),

                new SqNovaSelectFilter(
                    label: trans("Gate Level"),
                    column: 'level',
                    options: [
                        1 => trans("قرول"),
                    ]
                ),
            ])->columns(3),
        ];
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
