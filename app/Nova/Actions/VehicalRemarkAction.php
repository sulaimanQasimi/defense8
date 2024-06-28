<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;

class VehicalRemarkAction extends Action
{
    use InteractsWithQueue, Queueable;

    public function name()
    {
        return __("Remark");
    }
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            $model->update(["remark"=> $fields->remark]);
        }
        return Action::message(__("Remark Updated Successfully"));
    }
    public function fields(NovaRequest $request)
    {
        return [

            Trix::make(__("Remark"), 'remark'),
        ];
    }
}
