<?php

namespace Sq\Employee\Nova;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use MZiraki\PersianDateField\PersianDateTime;
use Sq\Query\Policy\UserDepartment;

class ScanedEmployee extends Resource
{
    public static $model = \Sq\Employee\Models\ScanedEmployee::class;
    public static $title = 'id';
    public static $search = [
        'id',
        'card_info.name',
        'card_info.last_name',
        'card_info.father_name',
        'card_info.grand_father_name',
        'card_info.job_structure',
        'card_info.national_id',
        'card_info.grade',
        'card_info.degree',
        'card_info.department',
        'card_info.registare_no',
    ];


    public static function label()
    {
        return __('Scaned Employee');
    }

    public static function singularLabel()
    {
        return __('Scaned Employee');
    }

    public static function indexQuery(NovaRequest $request, $query)
    {

        if (auth()->user()->hasRole('super-admin')) {
            return $query;
        }

        return $query->whereHas('card_info', function ($query) {
            return $query->whereIn('department_id',  UserDepartment::getUserDepartment());
        });
    }

    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make(trans('Employee'), 'card_info', CardInfo::class),
            BelongsTo::make(trans('Gate'), 'gate', Gate::class),
            PersianDateTime::make(trans('Date'), 'scaned_at')
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}
