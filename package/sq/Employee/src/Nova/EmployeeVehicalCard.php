<?php

namespace Sq\Employee\Nova;

use Afj95\LaravelNovaHijriDatepickerField\HijriDatePicker;
use App\Nova\Actions\VehicalRemarkAction;
use App\Nova\Resource;
use App\Support\Defense\PermissionTranslation;
use Bolechen\NovaActivitylog\Resources\Activitylog;
use DigitalCreative\MegaFilter\MegaFilter;
use DigitalCreative\MegaFilter\MegaFilterTrait;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\MorphMany;
use MZiraki\PersianDateField\PersianDate;
use Sq\Query\Policy\UserDepartment;
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

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->whereHas('card_info', function ($query) {
            return $query->whereIn('department_id', UserDepartment::getUserDepartment());
        });
    }
    public function fields(NovaRequest $request)
    {
        return [
            Image::make(__('Photo'), 'photo')->disk('vehical'),
            Select::make(__('Category'), 'category')
                ->options([
                    'الف' => __('الف'),
                    'ب' => __('ب'),
                    'ج' => __('ج'),
                    'د' => __('د'),
                    'چ' => __('چ'),
                ]),
            BelongsTo::make(__('Employee'), 'card_info', CardInfo::class)
                ->relatableQueryUsing(function (NovaRequest $request, Builder $query) {
                    $query->whereIn('department_id', UserDepartment::getUserDepartment());
                })
                ->nullable()
                ->searchable(),

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

            HijriDatePicker::make(__("Disterbute Date"), "register_date")
                ->format('iYYYY/iMM/iDD')
                ->placeholder('YYYY/MM/DD')
                ->selected_date('1444/12/12')
                ->placement('bottom'),

            HijriDatePicker::make(__("Expire Date"), "expire_date")
                ->format('iYYYY/iMM/iDD')
                ->placeholder('YYYY/MM/DD')
                ->selected_date('1444/12/12')
                ->placement('bottom'),
            Boolean::make(__("Print"), 'printed')->hideWhenCreating(),

            Trix::make(__("Remark"), 'remark')
                ->exceptOnForms()
                ->hideFromIndex(),
            MorphMany::make(trans("Activity Log"), 'activities', Activitylog::class),
        ];
    }


    public function cards(NovaRequest $request)
    {
        return [];
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
            (new \Sq\Card\Nova\Actions\EmployeeCarPrintCardAction)
                ->onlyOnDetail()
                ->canRun(
                    fn($request, $employeeVehicalCard) => auth()->user()->hasPermissionTo("print-card")
                        && in_array($employeeVehicalCard->card_info->orginization->id, UserDepartment::getUserDepartment())

                ),
            (new \Sq\Card\Nova\Actions\EmployeeCarPrintPaperCardAction)
                ->onlyOnDetail()
                ->canRun(
                    fn($request, $employeeVehicalCard) => auth()->user()->hasPermissionTo("print-card")
                        && in_array($employeeVehicalCard->card_info->orginization->id, UserDepartment::getUserDepartment())

                ),
            (new VehicalRemarkAction)
                ->canSee(fn() => auth()->user()->hasPermissionTo("add remark for vehical")),


            (new \Sq\Employee\Nova\Actions\VehicalCardExtension)
                ->onlyOnDetail()
                ->canRun(
                    fn($request, $mainCard)
                    => auth()->user()->hasPermissionTo(PermissionTranslation::update("Employee Vehical Card"))
                        && in_array($mainCard->card_info->orginization->id, UserDepartment::getUserDepartment())
                ),
        ];
    }
}
