<?php

namespace Sq\Employee\Nova;

use Afj95\LaravelNovaHijriDatepickerField\HijriDatePicker;
use Alkoumi\LaravelHijriDate\Hijri;
use App\Nova\Actions\VehicalRemarkAction;
use App\Nova\Resource;
use App\Support\Defense\PermissionTranslation;
use Bolechen\NovaActivitylog\Resources\Activitylog;
use Carbon\Carbon;
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
use Sq\Employee\Nova\Lenses\ExpiredVehicleLens;
use Sq\Query\Policy\UserDepartment;
use Sq\Query\SqNovaDateFilter;
use Sq\Query\SqNovaTextFilter;
use Sq\Query\SqNovaSelectFilter;

class EmployeeVehicalCard extends Resource
{
    use MegaFilterTrait;
    public static $model = \Sq\Employee\Models\EmployeeVehicalCard::class;

    public static $title = 'vehical_palete';
    public static $search = [
        'vehical_type',
        "vehical_colour",
        "vehical_palete",
        'vehical_registration_no'

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
            Boolean::make(__("Print"), 'printed')->exceptOnForms(),

            Boolean::make(__('منقضی شده'), function () {
                // Create a Carbon instance from the current Hijri date
                $date1 = Carbon::make(Hijri::Date('Y-m-d'));

                // Create a Carbon instance from the card's expiration date
                $date2 = Carbon::make($this->expire_date);

                // Compare the two dates to determine if the card is expired
                return $date1->gt($date2);
            })
                ->exceptOnForms(),
            Select::make(__('Category'), 'category')
                ->options([
                    'الف' => __('الف'),
                    'ب' => __('ب'),
                    'ج' => __('ج'),
                    'موقت' => __('موقت'),
                ])
                ->sortable()
                ->filterable(),
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
                ->placement('bottom')
                ->hideWhenUpdating(),

            HijriDatePicker::make(__("Expire Date"), "expire_date")
                ->format('iYYYY/iMM/iDD')
                ->placeholder('YYYY/MM/DD')
                ->selected_date('1444/12/12')
                ->placement('bottom')
                ->hideWhenUpdating(),

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
                new SqNovaSelectFilter(
                    label: __("Category"),
                    column: "category",
                    options: [
                        'الف' => __('الف'),
                        'ب' => __('ب'),
                        'ج' => __('ج'),
                        'موقت' => __('موقت'),
                    ]
                ),
                new SqNovaTextFilter(label: trans("Vehical Type"), column: "vehical_type"),
                new SqNovaTextFilter(label: trans("Vehical Colour"), column: "vehical_colour"),
                new SqNovaTextFilter(label: trans("Vehical Palete"), column: "vehical_palete"),
                new SqNovaTextFilter(label: trans("Vehical Chassis"), column: "vehical_chassis"),
                new SqNovaTextFilter(label: trans("Vehical Model"), column: "vehical_model"),
                new SqNovaTextFilter(label: trans("Vehical Owner"), column: "vehical_owner"),
                new SqNovaTextFilter(label: trans("Vehical Engine NO"), column: "vehical_engine_no"),
                new SqNovaTextFilter(label: trans("Vehical Registration NO"), column: "vehical_registration_no"),
                new SqNovaDateFilter(label: __("Disterbute Date"), column: "register_date"),
                new SqNovaDateFilter(label: __("Expire Date"), column: "expire_date"),
                new SqNovaSelectFilter(
                    label: __("Employee"),
                    column: "card_info_id",
                    options: \Sq\Employee\Models\CardInfo::query()
                        ->whereIn('department_id', UserDepartment::getUserDepartment())
                        ->pluck('name', 'id')
                        ->toArray()
                ),
                new SqNovaSelectFilter(
                    label: __("Driver"),
                    column: "driver_id",
                    options: \Sq\Employee\Models\CardInfo::query()
                        ->whereIn('department_id', UserDepartment::getUserDepartment())
                        ->pluck('name', 'id')
                        ->toArray()
                ),
                new SqNovaSelectFilter(
                    label: __("Print Status"),
                    column: "printed",
                    options: [
                        '1' => __('Printed'),
                        '0' => __('Not Printed'),
                    ]
                ),
            ])->columns(4),
        ];
    }
    public function lenses(NovaRequest $request)
    {
        return [
            new ExpiredVehicleLens(),
        ];
    }

    public function actions(NovaRequest $request)
    {
        return [
            \Sq\Card\Nova\Actions\EmployeeCarPrintCardAction::make()
                ->onlyOnDetail()
                ->canRun(
                    fn($request, $employeeVehicalCard) => auth()->user()->hasPermissionTo("print-card")
                        && in_array($employeeVehicalCard->card_info->orginization->id, UserDepartment::getUserDepartment())
                        && !$employeeVehicalCard->printed
                ),
            \Sq\Card\Nova\Actions\EmployeeCarPrintPaperCardAction::make()
                ->onlyOnDetail()
                ->canRun(
                    fn($request, $employeeVehicalCard) => auth()->user()->hasPermissionTo("print-card")
                        && in_array($employeeVehicalCard->card_info->orginization->id, UserDepartment::getUserDepartment())
                        && !$employeeVehicalCard->printed


                ),
            VehicalRemarkAction::make()
                ->canSee(fn() => auth()->user()->hasPermissionTo("add remark for vehical")),


            \Sq\Employee\Nova\Actions\VehicalCardExtension::make()
                ->sole()
                ->canRun(
                    fn($request, $mainCard)
                    => auth()->user()->hasPermissionTo(PermissionTranslation::update("Employee Vehical Card"))
                        && in_array($mainCard->card_info->orginization->id, UserDepartment::getUserDepartment())
                ),
        ];
    }
}
