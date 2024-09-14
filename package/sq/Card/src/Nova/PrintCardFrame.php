<?php
namespace Sq\Card\Nova;


use App\Nova\Resource;
use App\Support\Defense\Print\PrintTypeEnum;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class PrintCardFrame extends Resource
{
    public static $model = \Sq\Card\Models\PrintCardFrame::class;
    public static $title = 'name';
    public static $search = [
        'name',
    ];
    public static function label()
    {
        return __('Print Card Frames');
    }
    public static function singularLabel()
    {
        return __('Print Card Frame');
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

            Select::make(trans("Dimentions"), 'dim')->options([
                'vertical' => trans("Vertical"),
                'horizontal' => trans("Horizotal"),
            ])
                ->displayUsingLabels()
                ->required()
                ->rules("required"),
        ];
    }

    public function cards(NovaRequest $request)
    {
        return [
        ];
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
                ->canRun(fn() => auth()->user()->hasPermissionTo("design-card")),
            (new \Sq\Card\Nova\Actions\FetchCardDesign)->canRun(fn() => auth()->user()->hasPermissionTo("design-card"))

        ];
    }
    public function replicate()
    {
        return tap(parent::replicate(), function ($resource) {
            $model = $resource->model();

            $model->name = 'Duplicate of ' . $model->name;
        });
    }
}
