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

class VehicalCardExtension extends Action
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
                "remark" => $fields->remark,
                "muthanna" => $fields->muthanna,
                "printed" => false,
                "printed_at" => null
            ]);

            activity()
                ->performedOn($model)
                ->causedBy(auth()->user())
                ->withProperties([
                    "register_date" => $fields->register_date,
                    "expire_date" => $fields->expire_date,
                    "remark" => $fields->remark,
                    "muthanna" => $fields->muthanna,
                ])
                ->log("کارت واسطه تا تاریخ {$fields->expire_date} تمدید شد");
        }
    }

    private function getCurrentModel(NovaRequest $request)
    {
        return $request->findModelQuery()->first();
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        $currentModel = $this->getCurrentModel($request);

        return [
            HijriDatePicker::make(__("Disterbute Date"), "register_date")
                ->format('iYYYY/iMM/iDD')
                ->placeholder('YYYY/MM/DD')
                ->selected_date('1444/12/12')
                ->placement('bottom')
                ->default(fn() => $currentModel?->register_date),

            HijriDatePicker::make(__("Expire Date"), "expire_date")
                ->format('iYYYY/iMM/iDD')
                ->placeholder('YYYY/MM/DD')
                ->selected_date('1444/12/12')
                ->placement('bottom')

                ->default(fn() => $currentModel?->expire_date),

        ];
    }
    public function name()
    {
        return trans("تمدید کارت واسطه");
    }
    public function uriKey()
    {
        return 'vehical-card-extension';
    }
}
