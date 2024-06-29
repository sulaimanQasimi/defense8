<?php
namespace App\Nova\Card;

use App\Nova\Actions\EmployeeCarPrintCardAction;
use App\Nova\Actions\VehicalRemarkAction;
use App\Nova\Card\Support\VehicalDriverField;
use App\Nova\Resource;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

use Laravel\Nova\Fields\Image;

class EmployeeVehicalCard extends Resource
{
    public static $model = \App\Models\Card\EmployeeVehicalCard::class;

    public static $title = 'vehical_palete';
    public static $search = [
        'vehical_type',
        "vehical_colour",
        "vehical_palete",

    ];

    public static function label()
    {
        return __('Vehical Card');
    }

    public static function singularLabel()
    {
        return __('Vehical Card');
    }

    public function fields(NovaRequest $request)
    {
        return [

            Image::make(__('Photo'), 'photo')->disk('vehical'),
            BelongsTo::make(__('Employee'), 'card_info', CardInfo::class)->nullable()->searchable(),

            Text::make(__("Vehical Type"), "vehical_type")
                ->required()
                ->rules('required', 'string')
                ->placeholder(__("Enter Field", ['name' => __("Vehical Type")])),

            Text::make(__("Vehical Colour"), "vehical_colour")
                ->nullable()
                ->rules('nullable', 'string')
                ->placeholder(__("Enter Field", ['name' => __("Vehical Colour")])),
            Text::make(__("Vehical Palete"), "vehical_palete")
                ->required()
                ->creationRules('required', 'string', 'unique:employee_vehical_cards,vehical_palete')
                ->updateRules('required', 'string', 'unique:employee_vehical_cards,vehical_palete,{{resourceId}}')
                ->placeholder(__("Enter Field", ['name' => __("Vehical Palete")])),

            Text::make(__("Vehical Chassis"), "vehical_chassis")
                ->required()
                ->creationRules('required', 'string', 'unique:employee_vehical_cards,vehical_chassis')
                ->updateRules('required', 'string', 'unique:employee_vehical_cards,vehical_chassis,{{resourceId}}')
                ->placeholder(__("Enter Field", ['name' => __("Vehical Chassis")])),
            Text::make(__("Vehical Model"), "vehical_model")
                ->nullable()
                ->rules('nullable', 'string')
                ->placeholder(__("Enter Field", ['name' => __("Vehical Model")])),
            Text::make(__("Vehical Owner"), "vehical_owner")
                ->nullable()
                ->rules('nullable', 'string')
                ->placeholder(__("Enter Field", ['name' => __("Vehical Owner")])),
            Text::make(__("Vehical Engine NO"), "vehical_engine_no")
                ->nullable()
                ->rules('nullable', 'string')
                ->placeholder(__("Enter Field", ['name' => __("Vehical Engine NO")])),

            Text::make(__("Vehical Registration NO"), "vehical_registration_no")
                ->nullable()
                ->rules('nullable', 'string')
                ->placeholder(__("Enter Field", ['name' => __("Vehical Registration NO")])),

            Select::make(trans("Type"), 'type')
                ->options([
                    'employee' => trans("Employee Vehical Card"),
                    'armor' => trans("Armor Vehical Card"),
                    'black_mirror' => trans("Black Mirror Vehical Card"),
                ])
                ->rules('required', 'in:employee,armor,Directory,black_mirror')
                ->filterable()
                ->displayUsingLabels(),


            BelongsTo::make(__('Driver'), 'driver', CardInfo::class)
                ->searchable()
                ->nullable(),
            Trix::make(__("Remark"), 'remark')
                ->exceptOnForms()
                ->hideFromIndex()
        ];
    }


    public function cards(NovaRequest $request)
    {
        return [];
    }

    public function filters(NovaRequest $request)
    {
        return [];
    }
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    public function actions(NovaRequest $request)
    {
        return [
            (new EmployeeCarPrintCardAction)->onlyOnDetail()->canRun(fn() => auth()->user()->hasRole("Print Card")),
            (new VehicalRemarkAction)->canSee(fn() => auth()->user()->hasPermissionTo("add remark for vehical")),

        ];
    }
}
