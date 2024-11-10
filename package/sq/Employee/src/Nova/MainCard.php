<?php

namespace Sq\Employee\Nova;

use App\Nova\Actions\EmployeePrintCardAction;
use App\Nova\Resource;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use MZiraki\PersianDateField\PersianDate;
use Sq\Query\Policy\UserDepartment;

class MainCard extends Resource
{
    public static $model = \Sq\Employee\Models\MainCard::class;

    public static $title = 'card_info.registare_no';

    public static $search = [
    ];

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
        return $query->whereHas('card_info', function ($query) {
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

            PersianDate::make(__("Disterbute Date"), "card_perform")->hideWhenUpdating(
                fn()=>$this->printed
            ),
            PersianDate::make(__("Expire Date"), "card_expired_date")->hideWhenUpdating(
                fn()=>$this->printed
            ),
            Trix::make(trans('Remark'), 'remark'),
            Boolean::make(__("Print"), 'printed')->hideWhenCreating(),
            Boolean::make(__("Muthanna"), 'muthanna'),
            PersianDate::make(__("Print Date"), 'printed_at')->exceptOnForms(),
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
            (new \Sq\Card\Nova\Actions\EmployeePrintCardAction)->onlyOnDetail()
                ->canRun(fn($request, $mainCard)
                    => auth()->user()->hasPermissionTo("print-card")
                    && in_array($mainCard->card_info->orginization->id, UserDepartment::getUserDepartment())
                   ),

        ];
    }
}
