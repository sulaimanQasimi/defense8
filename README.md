# Update 19.0.1
Add single Vehical Model Nova 
`
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
`
## Add Vehicals to Menu sidebar
App\Providers\Novaserviceprovider.php
`
MenuItem::resource(EmployeeVehicalCard::class),
`
