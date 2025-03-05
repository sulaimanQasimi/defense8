<?php

namespace Sq\Card\Nova\Metrics;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Table;
use Sq\Card\Models\PrintCard;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Metrics\MetricTableRow;
use Laravel\Nova\Menu\MenuItem;

class PrintCardFrameMetric extends Table
{
    /**
     * Calculate the value of the metric.
     *
     * @return array<int, \Laravel\Nova\Metrics\MetricTableRow>
     */
    public function calculate(NovaRequest $request): array
    {

        $paper = PrintCard::query()->whereHas('customPaperCard')->count();
        $pvc = PrintCard::query()->whereHas('printCardFrame')->count();
        return[
            MetricTableRow::make()
            ->title('تعداد کارت های PVC')
            ->subtitle("به تعداد {$pvc} کارت چاپ شده"),

        MetricTableRow::make()
            ->title('تعداد کارت های کاغذی')
            ->subtitle("به تعداد {$paper} کارت چاپ شده"),
        ];
    }

    public function name()
    {
        return __('کارتها به اساس نوع');
    }

    public function uriKey()
    {
        return 'print-card-frame-distribution';
    }

    public function columns()
    {
        return [
            'Type',
            'Name',
            'Total'
        ];
    }
}
