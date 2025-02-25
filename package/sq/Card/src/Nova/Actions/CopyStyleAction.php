<?php

namespace Sq\Card\Nova\Actions;

use Sq\Card\Models\PrintCardFrame;
use App\Support\Defense\Print\PrintTypeEnum;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Actions\ActionResponse;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sq\Query\Policy\UserDepartment;

class CopyStyleAction extends Action
{
    use InteractsWithQueue, Queueable;
    public function __construct() {}
    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        $card = PrintCardFrame::find($fields->frame);
        foreach ($models as $model) {
            $model->update(['attr' => $card->attr]);
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

        $currentModel = $this->getCurrentModel($request);
        return [
            Select::make(trans("Card Type"), 'frame')
                ->options(
                    PrintCardFrame::where('type', $currentModel->type)
                        // ->where('dim', $currentModel->dim)
                        ->pluck('name', 'id')
                )
                ->displayUsingLabels(),
        ];
    }
    private function getCurrentModel(NovaRequest $request)
    {
        return $request->findModelQuery()->first();
    }
    public function name()
    {
        return trans("کاپی استایل کارت");
    }
    public function uriKey()
    {
        return "copy-card-style";
    }
}
