<?php

namespace App\Nova\Actions;

use App\Nova\EmployeeOption;
use App\Nova\GuestOption;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\MultiSelect;
use Laravel\Nova\Fields\Tag;
use Laravel\Nova\Http\Requests\NovaRequest;
use Log;

class EditCardInfoOption extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        Log::info('Fields variable:', $fields->toArray());

        $options = $fields->get('employeeOptions');

        if (empty($options)) {
            return Action::danger("Option is Empty");
        }
        $selectedOptions = \App\Models\GuestOption::query()->whereIn('id', $options)->get();
        foreach ($models as $model) {
            $model->employeeOptions()->sync($selectedOptions);
        }

        return Action::message(__("Employee Options Updated Successfully"));

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
            MultiSelect::make(__('Condition'), 'employeeOptions')
                ->options(\App\Models\GuestOption::all()->pluck('name', 'id'))
                ->displayUsingLabels()
                ->sortable(),


        ];
    }
    public function name(){
        return trans("Employee Options");
    }


}
