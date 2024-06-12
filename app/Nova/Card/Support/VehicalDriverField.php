<?php
namespace App\Nova\Card\Support;

use App\Nova\Card\CardInfo;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

trait VehicalDriverField
{
    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make(__('Employee'), 'card_info', CardInfo::class),

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
                ->rules('required', 'string')
                ->placeholder(__("Enter Field", ['name' => __("Vehical Palete")])),

            Text::make(__("Vehical Chassis"), "vehical_chassis")
                ->required()
                ->rules('required', 'string')
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
        ];
    }
}
