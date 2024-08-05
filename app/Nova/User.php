<?php

namespace App\Nova;

use DigitalCreative\MegaFilter\MegaFilter;
use DigitalCreative\MegaFilter\MegaFilterTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sq\Employee\Nova\Department;
use Sq\Employee\Nova\Gate;
use Sq\Query\SqNovaSelectFilter;
use Sq\Query\SqNovaTextFilter;

class User extends Resource
{
    use MegaFilterTrait;
    public static $model = \App\Models\User::class;
    public static $title = 'name';
    public static $search = [
        'id',
        'name',
        'email',
        'department.fa_name',
        'gate.fa_name'
    ];

    public static function label()
    {
        return __('Users');
    }

    public static function singularLabel()
    {
        return __('User');
    }
    public function fields(NovaRequest $request)
    {
        return [
            Text::make(__("Name"), 'name')
                ->sortable()
                ->rules('required', 'max:255'),

            Text::make(__("Email"), 'email')
                ->copyable()
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),
            BelongsTo::make(__("Department/Chancellor"), 'department', Department::class)
                ->filterable()
                ->sortable(),

            BelongsTo::make(__("Gate"), 'gate', Gate::class)->dependsOn(
                ['department'],
                function (BelongsTo $field, NovaRequest $request, FormData $formData) {
                    $field->relatableQueryUsing(function (NovaRequest $request, Builder $query) use ($formData) {
                        $query->where('department_id', $formData->department);
                    });
                }
            ),
            Password::make(__("Password"), 'password')
                ->onlyOnForms()
                ->creationRules('required', Rules\Password::defaults())
                ->updateRules('nullable', Rules\Password::defaults()),
            MorphToMany::make('Roles', 'roles', \Sereny\NovaPermissions\Nova\Role::class),
            MorphToMany::make('Permissions', 'permissions', \Sereny\NovaPermissions\Nova\Permission::class),

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
                // Name Filter
                new SqNovaTextFilter(label: trans("Name"), column: 'name'),
                // Email Filter
                new SqNovaTextFilter(label: trans("Email"), column: 'email'),
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
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
