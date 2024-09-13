<?php

namespace Sq\Location\Nova;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sq\Employee\Nova\CardInfo;

class District extends Resource
{
    public static $model = \Sq\Location\Models\District::class;
    public static $title = 'name';
    public static $search = [
        'name',
        'code'
    ];
    public static function label()
    {
        return __('Districts');
    }

    public static function singularLabel()
    {
        return __('District');
    }
    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make(trans("Province"), 'province', Province::class)->searchable(),
            Text::make(trans("Name"), 'name')
                ->required()
                ->creationRules('required', 'string', Rule::unique('districts')
                    ->where(function ($query) use ($request) {
                        return $query->where('province_id', $request->province)->where('deleted_at', null);
                    }))
                ->updateRules(
                    'required',
                    Rule::unique('districts')
                        ->where(function ($query) use ($request) {
                            return $query->where('province_id', $request->province)->where('deleted_at', null);
                        })->ignore($this->id)
                ),

            HasMany::make(trans("Villages"), 'villages', Village::class),

            // HasMany::make(trans("Main Address"), 'main_employee_address', CardInfo::class),
            // HasMany::make(trans("Current Address"), 'current_employee_address', CardInfo::class),



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
