<?php

namespace Sq\Employee\Nova\Metrics;

use Alkoumi\LaravelHijriDate\Hijri;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Sq\Employee\Models\MainCard;
use Carbon\Carbon;
use Sq\Query\Policy\UserDepartment;

class ExpiredCards extends Value
{
    public function calculate(NovaRequest $request)
    {
        $expiredCount = MainCard::where('card_expired_date', '<', Hijri::Date('Y-m-d'))
            ->whereHas('card_info', function ($query) {
                return $query->whereIn('department_id', UserDepartment::getUserDepartment());
            })
            ->count();
        return $this->result($expiredCount);
    }

    public function name()
    {
        return __('کارت‌های منقضی شده');
    }
    public function uriKey()
    {
        return 'expired-cards';
    }
}
