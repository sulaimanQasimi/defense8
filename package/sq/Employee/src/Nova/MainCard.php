<?php

namespace Sq\Employee\Nova;

use Afj95\LaravelNovaHijriDatepickerField\HijriDatePicker;
use Alkoumi\LaravelHijriDate\Hijri;
use App\Nova\Actions\EmployeePrintCardAction;
use App\Nova\Resource;
use App\Support\Defense\PermissionTranslation;
use Bolechen\NovaActivitylog\Resources\Activitylog;
use DigitalCreative\MegaFilter\MegaFilterTrait;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use MZiraki\PersianDateField\PersianDate;
use Sq\Query\Policy\UserDepartment;
use Carbon\Carbon;
use Laravel\Nova\Fields\MorphMany;
use Sq\Employee\Nova\Metrics\ActiveCards;
use Sq\Employee\Nova\Metrics\ExpiredCards;

class MainCard extends Resource
{
    public static $model = \Sq\Employee\Models\MainCard::class;

    public static $title = 'card_info.registare_no';

    public static $search = [];

    public static function label()
    {
        return __('Main Card');
    }

    public static function singularLabel()
    {
        return __('Main Card');
    }


    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->whereHas(relation: 'card_info', callback: function ($query) {
            return $query->whereIn('department_id', UserDepartment::getUserDepartment());
        });
    }

    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make(__('Employee'), 'card_info', CardInfo::class)
                ->relatableQueryUsing(function (NovaRequest $request, Builder $query) {
                    $query->whereIn('department_id', UserDepartment::getUserDepartment());
                })
                ->searchable()
                ->filterable(),

            HijriDatePicker::make(__("Disterbute Date"), "card_perform")
                ->hideWhenUpdating(
                    fn() => $this->printed
                )
                ->format('iYYYY/iMM/iDD')
                ->placeholder('YYYY/MM/DD')
                ->selected_date('1444/12/12')
                ->placement('bottom')
                ->rules('required', 'date'),

            HijriDatePicker::make(__("Expire Date"), "card_expired_date")
                ->hideWhenUpdating(
                    fn() => $this->printed
                )
                ->format('iYYYY/iMM/iDD')
                ->placeholder('YYYY/MM/DD')
                ->selected_date('1444/12/12')
                ->placement('bottom')
                ->rules('required', 'date'),
            Boolean::make(__('منقضی شده'), function () {
                // Create a Carbon instance from the current Hijri date
                $date1 = Carbon::make(Hijri::Date('Y-m-d'));

                // Create a Carbon instance from the card's expiration date
                $date2 = Carbon::make($this->card_expired_date);

                // Compare the two dates to determine if the card is expired
                return $date1->gt($date2);
            })
                ->exceptOnForms(),

            Trix::make(trans('Remark'), 'remark'),
            Boolean::make(__("Print"), 'printed')->hideWhenCreating(),
            Boolean::make(__("Muthanna"), 'muthanna'),
            PersianDate::make(__("Print Date"), 'printed_at')->exceptOnForms(),
            MorphMany::make(trans("Activity Log"), 'activities', Activitylog::class),

        ];
    }
    public function cards(NovaRequest $request)
    {
        return [
            ExpiredCards::make()->icon('fas fa-times-circle fa-2x'),
            ActiveCards::make()->icon('fas fa-check-circle fa-2x'),
        ];
    }
    public function filters(NovaRequest $request)
    {
        return [];
    }

    public function lenses(NovaRequest $request)
    {
        return [
            new \Sq\Employee\Nova\Lenses\MainCardExpireToday(),
        ];
    }
    public function actions(NovaRequest $request)
    {
        return [
            (new \Sq\Card\Nova\Actions\EmployeePrintCardAction)
                ->sole()
                ->canRun(
                    fn($request, $mainCard)
                    => auth()->user()->hasPermissionTo("print-card")
                        &&
                        in_array($mainCard->card_info->orginization->id, UserDepartment::getUserDepartment())
                        &&
                        !$mainCard->printed
                ),

            (new \Sq\Card\Nova\Actions\EmployeePrintPaperCardAction)
                ->sole()
                ->canRun(
                    fn($request, $mainCard)
                    => auth()->user()->hasPermissionTo("print-card")
                        && in_array($mainCard->card_info->orginization->id, UserDepartment::getUserDepartment())
                        &&
                        !$mainCard->printed

                ),


            (new \Sq\Employee\Nova\Actions\MainCardExtension)
                ->sole()
                ->canRun(
                    fn($request, $mainCard)
                    => auth()->user()->hasPermissionTo(PermissionTranslation::update("Main Card"))
                        && in_array($mainCard->card_info->orginization->id, UserDepartment::getUserDepartment())
                ),
        ];
    }
}
