<?php

namespace Sq\Card\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;

class FetchCardDesign extends Action
{
    use InteractsWithQueue, Queueable;
    public function handle(ActionFields $fields, Collection $models)
    {
        (new \Sq\Card\Support\ShareCardApi)->fetch($fields->ip);
    }
    public function fields(NovaRequest $request)
    {
        return [
            Text::make(trans("ip"), 'ip')->rules('required', 'ipv4'),
        ];
    }
    public function name()
    {
        return trans("Download Card Frame");
    }
}
