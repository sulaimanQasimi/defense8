<?php
namespace Sq\Employee\Nova;

use App\Nova\Filters\AttendanceDateFilter;
use App\Nova\Resource;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use MZiraki\PersianDateField\PersianDate;
use MZiraki\PersianDateField\PersianDateTime;
use NrmlCo\NovaBigFilter\NovaBigFilter;

class Attendance extends Resource
{
    public static $model = \Sq\Employee\Models\Attendance::class;

    public static $title = 'id';
    public static $search = [
        'id',
    ];

    public function fields(NovaRequest $request)
    {
        return [
            Select::make(trans("State"), 'state')->options([
                'U' => trans("Upsent"),
                'P' =>  trans("Present"),
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
            AttendanceDateFilter::make()
                ->color('rgb(30, 136, 229)') // customize color
                ->locale('fa,en') // customize locale
                ->type('date'), // date or datetime
        ];
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
