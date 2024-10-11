<?php
namespace Sq\Employee\Nova;

use App\Nova\Filters\AttendanceDateFilter;
use App\Nova\Resource;
use DigitalCreative\MegaFilter\MegaFilter;
use DigitalCreative\MegaFilter\MegaFilterTrait;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use MZiraki\PersianDateField\PersianDate;
use MZiraki\PersianDateField\PersianDateTime;
use NrmlCo\NovaBigFilter\NovaBigFilter;

class Attendance extends Resource
{
    use MegaFilterTrait;
    public static $model = \Sq\Employee\Models\Attendance::class;

    public static $title = 'card_info.registare_no';
    public static $search = [];
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->orderByDesc('date');
    }

    public static function label()
    {
        return __('Attendance');
    }

    public static function singularLabel()
    {
        return __('Attendance');
    }
    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make(__("Employee"), 'card_info', CardInfo::class),
            Text::make(trans("Department"), fn() => $this->card_info?->orginization?->fa_name),
            BelongsTo::make(__("Gate"), 'gate', Gate::class),
            Select::make(trans("State"), 'state')->options([
                'U' => trans("Upsent"),
                'P' => trans("Present"),
            ])->displayUsingLabels()->sortable()->filterable(),
            PersianDate::make(trans("Date"), 'date'),
            PersianDateTime::make(trans("Enter"), 'enter'),
            PersianDateTime::make(trans("Exit"), 'exit'),
        ];
    }

    public function cards(NovaRequest $request)
    {
        return [];
    }
    public function filters(NovaRequest $request)
    {
        return [

            MegaFilter::make([
                \Sq\Employee\Nova\Filters\AttendanceDateFilter::make()
                    ->color('rgb(30, 136, 229)') // customize color
                    ->locale('fa,en') // customize locale
                    ->type('date'), // date or datetime
                \Sq\Employee\Nova\Filters\AttendanceDepartmentFilter::make()
            ])
        ];
    }

    public function lenses(NovaRequest $request): array
    {
        return [];
    }
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
