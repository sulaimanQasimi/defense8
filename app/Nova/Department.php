<?php

namespace App\Nova;

use App\Nova\Card\CardInfo;
use Illuminate\Http\Request;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;

class Department extends Resource
{
    public static $model = \App\Models\Department::class;
    public static $title = 'fa_name';
    public static $search = [
        'fa_name',
        'pa_name',
        'en_name',
    ];


    public static function label()
    {
        return __('Departments');
    }

    public static function singularLabel()
    {
        return __('Department');
    }

    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make(trans("User"), 'user', User::class)
                ->showCreateRelationButton(),
            BelongsTo::make(trans("Department"), 'department', Department::class)
                ->nullable(),
            Text::make(trans("Name"), 'fa_name'),
            Text::make(trans("Pashto Name"), 'pa_name'),
            Text::make(trans("English Name"), 'en_name'),
            HasMany::make(trans("Departments"), 'departments', Department::class)
                // ->collapsable()
                // ->collapsedByDefault()
                ->nullable(),
            HasMany::make(trans("Employee"), 'card_infos', CardInfo::class)
                // ->collapsable()
                // ->collapsedByDefault()
                ->nullable(),

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
        return [
            Action::openInNewTab(
                __("In this Page you can set each employee attendance"),
                fn($department) => route('department.employee.attendance.check', ['department' => $department->id])
            )
                ->sole()
                ->canRun(fn($request, $department) => auth()->id() === $department->user_id)
                ->withoutConfirmation()
                ->onlyOnDetail(),
            Action::openInNewTab(
                __("Download CURRENT MONTH ATTENDANCE EMPLOYEE"),
                fn($department) => route('employee.attendance.current.month..department.single', ['department' => $department->id])
            )
                ->sole()
                ->canRun(fn($request, $department) => auth()->id() === $department->user_id)
                ->withoutConfirmation()
                ->onlyOnDetail(),
            Action::openInNewTab(
                __("Download Excel"),
                fn($department) => route('export.excel.attendance', ['department' => $department->id])
            )
                ->sole()
                ->canRun(fn($request, $department) => auth()->id() === $department->user_id)
                ->withoutConfirmation()
                ->onlyOnDetail()
        ];
    }
}
