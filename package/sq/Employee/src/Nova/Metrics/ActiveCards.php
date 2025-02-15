<?php

namespace Sq\Employee\Nova\Metrics;

use Alkoumi\LaravelHijriDate\Hijri;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Sq\Employee\Models\MainCard;
use Carbon\Carbon;
use Sq\Query\Policy\UserDepartment;

class ActiveCards extends Value
{
    public function calculate(NovaRequest $request)
    {
        $activeCount = MainCard::where('card_expired_date', '>=', Hijri::Date('Y-m-d'))
            ->whereHas('card_info', function ($query) {
                return $query->whereIn('department_id', UserDepartment::getUserDepartment());
            })

            ->count();
        return $this->result($activeCount);
    }

    public function name()
    {
        return __('کارت‌های فعال');
    }
    public function uriKey()
    {
        return 'active-cards';
    }
}
