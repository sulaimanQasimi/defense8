<?php

namespace Laravel\Nova\Metrics;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Nova;

class ApexLineChart extends Metric
{

    public $component = 'apex-metric';

    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            // 'icon' => $this->icon,
            // 'options'=>$this->option
        ]);
    }
    public function options(array $options): self
    {
        return $this->withMeta(['options' => (object) $options]);
    }

}
