<?php
namespace App\Nova;

use App\Nova\Actions\FetchCardDesign;
use App\Support\Defense\Print\PrintTypeEnum;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Actions\Action;

use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class PrintCardFrame extends Resource
{
    public static $model = \App\Models\PrintCardFrame::class;
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

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
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
            Action::openInNewTab(__("Design Card"), fn($employee) => route('employee.design-card', ['printCardFrame' => $employee->id]))
                ->sole()
                ->withoutConfirmation()
                ->onlyOnDetail()
                ->canRun(fn() => auth()->user()->hasRole("Design Card")),
            (new FetchCardDesign)->canRun(fn() => auth()->user()->hasRole("Design Card"))

        ];
    }
}
