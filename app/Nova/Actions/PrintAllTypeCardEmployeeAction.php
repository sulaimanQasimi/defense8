<?php

namespace App\Nova\Actions;

use App\Nova\PrintCardFrame;
use App\Support\Defense\Print\PrintTypeEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class PrintAllTypeCardEmployeeAction extends Action
{
    use InteractsWithQueue, Queueable;


    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {

            if ($fields->type === PrintTypeEnum::Employee) {
                return $this->route('employee.print-card-for', $model->id, $fields->frame);
            }
            if ($fields->type === PrintTypeEnum::Gun) {
                return $this->route('gun.print-card-for', $model->id, $fields->frame);
            }
        }
    }

    final private function route($route, $id, $card): ActionResponse
    {
        return ActionResponse::openInNewTab(route($route, ['cardInfo' => $id, "printCardFrame" => $card]));
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

            Select::make(trans("Type"), 'type')->options([
                PrintTypeEnum::Employee => trans("Employee"),
                PrintTypeEnum::Gun => trans("Gun Card"),
            ])->displayUsingLabels(),
            Select::make(trans("Card Type"), 'frame')
                ->options([])
                ->displayUsingLabels()
                ->rules('required', 'exists:print_card_frames,id')
                ->dependsOn(
                    ['type'],
                    function (Select $field, NovaRequest $request, FormData $formData) {
                        $field->options(\App\Models\PrintCardFrame::where('type', $formData->type)
                            ->pluck('name', 'id'));

                        // $field->relatableQueryUsing(function (NovaRequest $request, Builder $query) use ($formData) {
                        //     $query->where('province_id', $formData->province);
                        // });
                    }
                ),
        ];
    }
    public function name()
    {
        return trans("Print Card Frame");
    }
}
