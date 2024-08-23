<?php
namespace Sq\Employee\Nova;

use App\Nova\Actions\VehicalRemarkAction;
use App\Nova\Resource;
use DigitalCreative\MegaFilter\MegaFilter;
use DigitalCreative\MegaFilter\MegaFilterTrait;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Image;
use MZiraki\PersianDateField\PersianDate;
use Sq\Query\SqNovaDateFilter;
use Sq\Query\SqNovaTextFilter;

class EmployeeVehicalCard extends Resource
{
    use MegaFilterTrait;
    public static $model = \Sq\Employee\Models\EmployeeVehicalCard::class;

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
                ->nullable()
                ->creationRules('nullable', 'string', 'unique:employee_vehical_cards,vehical_palete')
                ->updateRules('nullable', 'string', 'unique:employee_vehical_cards,vehical_palete,{{resourceId}}')
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

            BelongsTo::make(__('Driver'), 'driver', CardInfo::class)
                ->searchable()
                ->nullable(),

            PersianDate::make(__("Disterbute Date"), "register_date")
                ->required()
                ->rules('required', 'date')
                ->placeholder(__("Enter Field", ['name' => __("Disterbute Date")])),

            PersianDate::make(__("Expire Date"), "expire_date")
                ->required()
                ->rules('required', 'date')
                ->placeholder(__("Enter Field", ['name' => __("Expire Date")])),

            Trix::make(__("Remark"), 'remark')
                ->exceptOnForms()
                ->hideFromIndex()
        ];
    }


    public function cards(NovaRequest $request)
    {
        return [
        ];
    }

    public function filters(NovaRequest $request)
    {
        return [
            MegaFilter::make([
                //
                new SqNovaTextFilter(label: trans("Vehical Type"), column: "vehical_type"),
                //
                new SqNovaTextFilter(label: trans("Vehical Colour"), column: "vehical_colour"),
                //
                new SqNovaTextFilter(label: trans("Vehical Palete"), column: "vehical_palete"),
                //
                new SqNovaTextFilter(label: trans("Vehical Chassis"), column: "vehical_chassis"),
                //
                new SqNovaTextFilter(label: trans("Vehical Model"), column: "vehical_model"),
                //
                new SqNovaTextFilter(label: trans("Vehical Owner"), column: "vehical_owner"),
                //
                new SqNovaTextFilter(label: trans("Vehical Engine NO"), column: "vehical_engine_no"),
                //
                new SqNovaTextFilter(label: trans("Vehical Registration NO"), column: "vehical_registration_no"),
                //
                new SqNovaDateFilter(label: trans("Disterbute Date"), column: "register_date"),
                //
                new SqNovaDateFilter(label: trans("Expire Date"), column: "expire_date"),
            ])->columns(4)

        ];
    }
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    public function actions(NovaRequest $request)
    {
        return [
            (new \Sq\Card\Nova\Actions\EmployeeCarPrintCardAction)->onlyOnDetail()->canRun(fn() => auth()->user()->hasRole("Print Card")),
            (new VehicalRemarkAction)->canSee(fn() => auth()->user()->hasPermissionTo("add remark for vehical")),

        ];
    }
}
