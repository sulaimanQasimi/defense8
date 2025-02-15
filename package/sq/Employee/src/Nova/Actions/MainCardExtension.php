<?php

namespace Sq\Employee\Nova\Actions;

use Afj95\LaravelNovaHijriDatepickerField\HijriDatePicker;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sq\Query\Policy\UserDepartment;

class MainCardExtension extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            $model->update([
                "card_perform" => $fields->card_perform,
                "card_expired_date" => $fields->card_expired_date,
                "remark" => $fields->remark,
                "muthanna" => $fields->muthanna,
                "printed" => false,
                "printed_at" => null
            ]);

            activity()
                ->performedOn($model)
                ->causedBy(auth()->user())
                ->withProperties([
                    "card_perform" => $fields->card_perform,
                    "card_expired_date" => $fields->card_expired_date,
                    "remark" => $fields->remark,
                    "muthanna" => $fields->muthanna,
                ])
                ->log("کارت کارمند تا تاریخ {$fields->card_expired_date} تمدید شد");
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            HijriDatePicker::make(__("Disterbute Date"), "card_perform")
                ->format('iYYYY/iMM/iDD')
                ->placeholder('YYYY/MM/DD')
                ->selected_date('1444/12/12')
                ->placement('bottom'),
            HijriDatePicker::make(__("Expire Date"), "card_expired_date")
                ->format('iYYYY/iMM/iDD')
                ->placeholder('YYYY/MM/DD')
                ->selected_date('1444/12/12')
                ->placement('bottom'),
            Trix::make(trans('Remark'), 'remark'),
            Boolean::make(__("Muthanna"), 'muthanna'),

        ];
    }
    public function name()
    {
        return trans("تمدید کارت کارمند");
    }
    public function uriKey()
    {
        return 'main-card-extension';
    }
}
