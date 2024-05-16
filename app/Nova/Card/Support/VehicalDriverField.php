<?php
namespace App\Nova\Card\Support;

use App\Nova\Card\CardInfo;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use MZiraki\PersianDateField\PersianDate;

trait VehicalDriverField
{

    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make(__('Info'), 'card_info', CardInfo::class),

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

                Panel::make(__("Driver"), [
                Text::make(__("Name"), "name")
                    ->nullable()
                    ->rules('nullable', 'string')
                    ->placeholder(__("Enter Field", ['name' => __("Name")])),

                Text::make(__("Last Name"), "last_name")
                    ->nullable()
                    ->rules('nullable', 'string')
                    ->placeholder(__("Enter Field", ['name' => __("Last Name")])),

                Text::make(__("Father Name"), "father_name")
                    ->nullable()
                    ->rules('nullable', 'string')
                    ->placeholder(__("Enter Field", ['name' => __("Father Name")])),

                Text::make(__("Grand Father Name"), "grand_father_name")
                    ->nullable()
                    ->rules('nullable', 'string')
                    ->placeholder(__("Enter Field", ['name' => __("Grand Father Name")])),
                Text::make(__("National ID"), "national_id")
                    ->nullable()
                    ->rules('nullable', 'string')
                    ->placeholder(__("Enter Field", ['name' => __("National ID")])),

                Text::make(__("Phone"), "phone")
                    ->nullable()
                    ->rules('nullable', 'string')
                    ->placeholder(__("Enter Field", ['name' => __("Phone")])),

                PersianDate::make(__("Date of Birth"), "birthday")
                    ->nullable()
                    ->rules('nullable', 'date')
                    ->placeholder(__("Enter Field", ['name' => __("Date of Birth")])),

                Text::make(__("Register No"), "registare_no")
                    ->nullable()
                    ->rules('nullable', 'string')
                    ->placeholder(__("Enter Field", ['name' => __("Register No")])),


            ]),
        ];
    }
}
