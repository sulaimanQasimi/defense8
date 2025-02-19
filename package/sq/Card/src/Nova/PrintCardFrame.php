<?php

namespace Sq\Card\Nova;


use App\Nova\Resource;
use App\Support\Defense\Print\PrintTypeEnum;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Hidden;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sq\Employee\Nova\Department;
use Sq\Query\Policy\UserDepartment;

class PrintCardFrame extends Resource
{
    public static $model = \Sq\Card\Models\PrintCardFrame::class;
    public static $title = 'name';
    public static $search = [
        'name',
    ];
    public static function label()
    {
        return __('کارت های PVC');
    }
    public static function singularLabel()
    {
        return __('کارت PVC');
    }

    // public static function indexQuery(NovaRequest $request, $query)
    // {
    //     if (auth()->user()->hasRole('super-admin')) {
    //         return $query;
    //     }
    //     return $query->whereIn('department_id', UserDepartment::getUserDepartment());
    // }
    public function fields(NovaRequest $request)
    {
        return [
            Text::make(trans("Name"), 'name')->required()->rules("required"),
            Select::make(trans("Type"), 'type')->options([
                PrintTypeEnum::Employee => trans("Employee"),
                PrintTypeEnum::EmployeeCar => trans("Vehical Card"),
                PrintTypeEnum::Gun => trans("Gun Card"),
            ])
                ->displayUsingLabels()
                ->required()
                ->rules("required"),

            Select::make(trans("Dimentions"), 'dim')->options([
                'vertical' => trans("Vertical"),
                'horizontal' => trans("Horizotal"),
            ])
                ->displayUsingLabels()
                ->required()
                ->rules("required"),

            BelongsTo::make(__("Department/Chancellor"), 'department', Department::class)
                ->relatableQueryUsing(function (NovaRequest $request, Builder $query) {
                    $query->whereIn('id', UserDepartment::getUserDepartment());
                })
                // ->searchable()
                ->filterable()
                ->sortable()
                ->withoutTrashed(),

            Hidden::make('details'),
            Hidden::make('remark'),
            Hidden::make('attr'),
            Hidden::make('ip_address'),

        ];
    }

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
                __("Design Card"),
                fn($employee) => route('sq.employee.design-card', ['printCardFrame' => $employee->id])
            )
                ->sole()
                ->withoutConfirmation()
                ->onlyOnDetail()
                ->canRun(fn($request, $card) => auth()->user()->hasPermissionTo("design-card") && in_array($card->department_id, UserDepartment::getUserDepartment())),
            Action::openInNewTab(
                __("پیش نمایش کارت"),
                fn($card) => route('sq.employee.pvc-test-card', ['printCardFrame' => $card->id])
            )
                ->sole()
                ->withoutConfirmation()
                ->onlyOnDetail()
                ->canRun(fn($request, $card) => auth()->user()->hasPermissionTo("design-card") && in_array($card->department_id, UserDepartment::getUserDepartment())),

        ];
    }
    public function replicate()
    {
        return tap(parent::replicate(), function ($resource) {
            $model = $resource->model();

            $model->name = 'Duplicate of ' . $model->name;
            $model->attr = $model->getOriginal('attr'); // Ensure attr is correctly formatted
        });
    }
    public static function uriKey(): string
    {
        return 'print-card-frame';
    }
}
