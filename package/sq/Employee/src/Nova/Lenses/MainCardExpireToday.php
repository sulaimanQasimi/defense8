<?php

namespace Sq\Employee\Nova\Lenses;

use Afj95\LaravelNovaHijriDatepickerField\HijriDatePicker;
use Alkoumi\LaravelHijriDate\Hijri;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Lenses\Lens;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sq\Employee\Models\MainCard;
use Sq\Employee\Nova\CardInfo;
use Illuminate\Database\Eloquent\Builder;
use Sq\Query\Policy\UserDepartment;

class MainCardExpireToday extends Lens
{

    public static function query(NovaRequest $request, $query)
    {
        return $query->whereDate(column: 'card_expired_date', operator: '<', value: Hijri::Date('Y-m-d'))
            ->whereHas('card_info', function ($query) {
                return $query->whereIn('department_id', UserDepartment::getUserDepartment());
            });
    }

    public function fields(NovaRequest $request)
    {
        return [

            BelongsTo::make(__('Employee'), 'card_info', CardInfo::class)
                ->relatableQueryUsing(function (NovaRequest $request, Builder $query) {
                    $query->whereIn('department_id', UserDepartment::getUserDepartment());
                }),
            HijriDatePicker::make(__("Disterbute Date"), "card_perform")
                ->hideWhenUpdating(
                    fn() => $this->printed
                )
                ->format('iYYYY/iMM/iDD')
                ->placeholder('YYYY/MM/DD')
                ->selected_date('1444/12/12')
                ->placement('bottom'),
            HijriDatePicker::make(__("Expire Date"), "card_expired_date")
                ->hideWhenUpdating(
                    fn() => $this->printed
                )
                ->format('iYYYY/iMM/iDD')
                ->placeholder('YYYY/MM/DD')
                ->selected_date('1444/12/12')
                ->placement('bottom')
                ->withMeta(['extraAttributes' => [
                    'style' => 'color: red;'
                ]]),
            Trix::make(trans('Remark'), 'remark'),
            Boolean::make(__("Print"), 'printed')->hideWhenCreating(),
            Boolean::make(__("Muthanna"), 'muthanna'),
            // PersianDate::make(__("Print Date"), 'printed_at')->exceptOnForms(),

        ];
    }
    public function name()
    {
        return __('کارتهای انقضا شده');
    }
    public  function uriKey()
    {
        return 'main-card-expire-today';
    }
}
