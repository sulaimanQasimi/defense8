<?php

namespace Sq\Card\Nova\Actions;

use App\Support\Defense\Print\PrintTypeEnum;
use Illuminate\Bus\Queueable;
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
            return $this->route('sq.employee.print-card-for', $model->id, $fields->frame);
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

            Select::make(trans("Card Type"), 'frame')
                ->displayUsingLabels()
                ->rules('required', 'exists:print_card_frames,id')
                ->options(
                    \Sq\Card\Models\PrintCardFrame::where('type', PrintTypeEnum::Employee)
                        ->pluck('name', 'id')
                ),
        ];
    }
    public function name()
    {
        return trans("Print Card Frame");
    }
}
