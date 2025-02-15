<?php

namespace Sq\Card\Nova\Actions;

use Sq\Card\Models\PrintCardFrame;
use App\Support\Defense\Print\PrintTypeEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sq\Card\Models\CustomPaperCard;
use Sq\Query\Policy\UserDepartment;

class EmployeePrintPaperCardAction extends Action
{
    use InteractsWithQueue, Queueable;

    /**
     * Perform the action on the given models.
     *
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            return ActionResponse::openInNewTab(route('sq.paper.print-card.employee', ['mainCard' => $model->id, "printCardFrame" => $fields->frame]));
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
            Select::make(trans("Card Type"), 'frame')->options(
                CustomPaperCard::query()
                    ->where('type', PrintTypeEnum::Employee)
                    ->whereIn('department_id', UserDepartment::getUserDepartment())
                    ->pluck('name', 'id')
            )
                ->displayUsingLabels()
                ->rules('required', 'exists:custom_paper_cards,id'),
        ];
    }
    public function name()
    {
        return trans("کارت کاغذی ");
    }
    public function uriKey(){
        return 'employee-print-paper-card';
    }
}
