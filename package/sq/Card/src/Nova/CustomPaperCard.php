<?php

namespace Sq\Card\Nova;


use App\Nova\Resource;
use App\Support\Defense\Print\PrintTypeEnum;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sq\Employee\Nova\Department;
use Sq\Query\Policy\UserDepartment;
use Laravel\Nova\Fields\Hidden;

class CustomPaperCard extends Resource
{
    public static $model = \Sq\Card\Models\CustomPaperCard::class;
    public static $title = 'name';
    public static $search = [
        'name',
    ];
    public static function label()
    {
        return __('کارت های کاغذی');
    }
    public static function singularLabel()
    {
        return __('کارت کاغذی');
    }

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

            BelongsTo::make(__("Department/Chancellor"), 'department', Department::class)
                ->relatableQueryUsing(function (NovaRequest $request, Builder $query) {
                    $query->whereIn('id', UserDepartment::getUserDepartment());
                })
                // ->searchable()
                ->filterable()
                ->sortable()
                ->withoutTrashed()
                ->nullable(),
                Code::make('details'),
                Code::make('remark'),
                Code::make('attr')
                    ->json()
                    ->hideWhenCreating(),
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
                fn($card) => route('sq.employee.paper-design-card', ['customPaperCard' => $card->id])
            )
                ->sole()
                ->withoutConfirmation()
                ->onlyOnDetail()
                ->canRun(fn($request, $card) => auth()->user()->hasPermissionTo("design-card") && in_array($card->department_id, UserDepartment::getUserDepartment())),
            Action::openInNewTab(
                __("پیش نمایش کارت"),
                fn($card) => route('sq.employee.paper-test-card', ['customPaperCard' => $card->id])
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
        });
    }

    public static function uriKey(): string
    {
        return 'custom-paper-card';
    }
}
