<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class User extends Resource
{
    public static $model = \App\Models\User::class;
    public static $title = 'name';
    public static $search = [
        'id',
        'name',
        'email',
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

            Text::make(__("Location"), 'location')
                ->copyable()
                ->sortable()
                ->rules('required'),
            Select::make(trans("Type"), 'type')->options([
                "Department" => trans("Department"),
                "Gate" => trans("Gate"),
                "None" => trans("No"),
            ])->rules('required', 'in:Gate,Department,None')
            ->filterable()
            ->displayUsingLabels(),

            BelongsTo::make(trans("Department"), 'department', Department::class)
                ->dependsOn(
                    ['type'],
                    function (BelongsTo $field, NovaRequest $request, FormData $formData) {
                        if ($formData->type === 'Gate') {
                            $field->hide()->nullable();
                        }
                        if ($formData->type === 'Department') {
                            $field->show();
                        }
                    }
                )
                ->nullable()
                ->hide()
                ->searchable()
                ->filterable(),
            BelongsTo::make(trans("Gate"), 'gate', Gate::class)
                ->dependsOn(
                    ['type'],
                    function (BelongsTo $field, NovaRequest $request, FormData $formData) {
                        if ($formData->type === 'Department') {
                            $field->hide()->nullable();
                        }
                        if ($formData->type === 'Gate') {
                            $field->show();
                        }
                    }
                )
                ->hide()
                ->nullable()
                ->searchable()
                ->filterable(),
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
