<?php

namespace App\Nova;

use App\Nova\Card\CardInfo;
use App\Support\Defense\DepartmentTypeEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
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
            BelongsTo::make(trans("Department"), 'department', Department::class)
                ->nullable()->filterable(),
            Text::make(trans("Name"), 'fa_name'),
            Text::make(trans("Pashto Name"), 'pa_name'),
            Text::make(trans("English Name"), 'en_name'),
            Select::make(trans("Type"), 'type')->options([
                DepartmentTypeEnum::Independant => trans("Independant"),
                DepartmentTypeEnum::Assistant => trans("Assistant"),
                DepartmentTypeEnum::Directory => trans("Directory"),
                DepartmentTypeEnum::HeaderShip => trans("HeaderShip"),
                DepartmentTypeEnum::Commander => trans("Commander"),
                DepartmentTypeEnum::Management => trans("Management"),
                DepartmentTypeEnum::Directorate => trans("Directorate"),
            ])->rules('required', 'in:Independant,Assistant,Directory,HeaderShip,Commander,Management,Directorate')->filterable()->displayUsingLabels(),
            HasMany::make(trans("Users"), 'user', User::class),
            HasMany::make(trans("Departments"), 'departments', Department::class),
            HasMany::make(trans("Employee"), 'card_infos', CardInfo::class),

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
                ->canRun(fn($request, $department) => Gate::allows('admin', $department))
                ->withoutConfirmation()
                ->onlyOnDetail(),
            Action::openInNewTab(
                __("Download CURRENT MONTH ATTENDANCE EMPLOYEE"),
                fn($department) => route('employee.attendance.current.month..department.single', ['department' => $department->id])
            )
                ->sole()
                ->canRun(fn($request, $department) => Gate::allows('admin', $department))
                ->withoutConfirmation()
                ->onlyOnDetail(),
            Action::openInNewTab(
                __("Download Excel"),
                fn($department) => route('export.excel.attendance', ['department' => $department->id])
            )
                ->sole()
                ->canRun(fn($request, $department) => Gate::allows('admin', $department))
                ->withoutConfirmation()
                ->onlyOnDetail()
        ];
    }
}
