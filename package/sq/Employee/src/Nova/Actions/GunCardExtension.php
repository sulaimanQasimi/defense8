<?php

namespace Sq\Employee\Nova\Actions;

use Afj95\LaravelNovaHijriDatepickerField\HijriDatePicker;
use Alkoumi\LaravelHijriDate\Hijri;
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

class GunCardExtension extends Action
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
                "register_date" => $fields->register_date,
                "expire_date" => $fields->expire_date,
                "printed" => false,
                "printed_at" => null
            ]);

            activity()
                ->performedOn($model)
                ->causedBy(auth()->user())
                ->withProperties([
                    "register_date" => $fields->register_date,
                    "expire_date" => $fields->expire_date,
                ])
                ->log("کارت اسلحه تا تاریخ {$fields->expire_date} تمدید شد");
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
            HijriDatePicker::make(__("Disterbute Date"), "expire_date")
                ->format('iYYYY/iMM/iDD')
                ->placeholder('YYYY/MM/DD')
                ->selected_date(Hijri::Date('Y-m-d'))
                ->placement('bottom'),
            HijriDatePicker::make(__("Expire Date"), "expire_date")
                ->format('iYYYY/iMM/iDD')
                ->placeholder('YYYY/MM/DD')
                ->selected_date(Hijri::Date('Y-m-d'))
                ->placement('bottom'),

        ];
    }
    public function name()
    {
        return trans("تمدید کارت اسلحه");
    }
    public function uriKey()
    {
        return 'gun-card-extension';
    }
}
