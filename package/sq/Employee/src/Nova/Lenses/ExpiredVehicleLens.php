<?php

namespace Sq\Employee\Nova\Lenses;

use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\LensRequest;
use Laravel\Nova\Lenses\Lens;

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
use Sq\Employee\Nova\CardInfo;
use Sq\Query\Policy\UserDepartment;
use Sq\Query\SqNovaDateFilter;
use Sq\Query\SqNovaTextFilter;

class ExpiredVehicleLens extends Lens
{
    /**
     * Get the query for the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\LensRequest  $request
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function query(LensRequest $request, $query)
    {
        return $query->whereDate(column: 'expire_date', operator: '<', value: Hijri::Date('Y-m-d'))
            ->whereHas('card_info', function ($query) {
                return $query->whereIn('department_id', UserDepartment::getUserDepartment());
            });
    }

    /**
     * Get the fields displayed by the lens.
     *
     * @param  \Laravel\Nova\Http\Requests\LensRequest  $request
     * @return array
     */
    public function fields(\Laravel\Nova\Http\Requests\NovaRequest $request)
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

    /**
     * Get the name of the lens.
     *
     * @return string
     */

     public function name()
     {
         return __('کارتهای انقضا شده');
     }
     public  function uriKey()
     {
         return 'expired-vehicle-lens';
     }
}
