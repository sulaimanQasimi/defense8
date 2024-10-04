<?php

namespace Sq\Card\Nova;

use App\Nova\Resource;
use App\Nova\User;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use MZiraki\PersianDateField\PersianDate;
use Sq\Employee\Nova\CardInfo;

class PrintCard extends Resource
{
    public static $model = \Sq\Card\Models\PrintCard::class;
   public static $title = 'card_info.registare_no';

    public static $search = [
        'card_info.registare_no',
    ];

    public static function label()
    {
        return __('Print Card');
    }
    public static function singularLabel()
    {
        return __('Print Card');
    }
    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make(trans("Employee"),'card_info',CardInfo::class),
            BelongsTo::make(trans("User"),'user',User::class),
            BelongsTo::make(trans("Card Type"),'card_info',PrintCardFrame::class),
            PersianDate::make(trans("Issue Date"),'issue'),
            PersianDate::make(trans("Expire Date"),'expire'),

        ];
    }
    public function cards(NovaRequest $request)
    {
        return [];
    }
    public function filters(NovaRequest $request)
    {
        return [];
    }
    public function lenses(NovaRequest $request)
    {
        return [];
    }
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
