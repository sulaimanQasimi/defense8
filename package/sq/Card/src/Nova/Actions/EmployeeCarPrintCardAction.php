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
use Sq\Query\Policy\UserDepartment;

class EmployeeCarPrintCardAction extends Action
{
    use InteractsWithQueue, Queueable;
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            return ActionResponse::openInNewTab(route('sq.employee-car.print-card-for', ['employeeVehicalCard' => $model->id, "printCardFrame" => $fields->frame]));
        }
    }

    public function fields(NovaRequest $request)
    {
        return [
            Select::make(trans("Card Type"), 'frame')->options(
                PrintCardFrame::where('type', PrintTypeEnum::EmployeeCar)
                    ->whereIn('department_id', UserDepartment::getUserDepartment())
                    ->pluck('name', 'id')
            )->displayUsingLabels()->rules('required', 'exists:print_card_frames,id'),
        ];
    }

    public function name()
    {
        return trans("کارت PVC کارمند");
    }
    public function uriKey()
    {
        return 'employee-car-print-card';
    }}
