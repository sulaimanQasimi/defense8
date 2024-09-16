<?php

namespace App\Nova\Actions;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

class CopyUserDependantDepartment extends Action
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
        $user = User::where('email', $fields->email)->first();
        // $user->departments()->attach();
        foreach ($models as $model) {
            foreach ($user->departments as $department) {
                $model->departments()->attach($department);
            }
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
            Text::make(__("Email"), 'email')
                ->copyable()
                ->sortable()
                ->rules('required', 'email', 'max:254', 'exists:users,email'),
        ];
    }
    public function name(): string
    {
        return trans("Set User Depandant Department");

    }
}
