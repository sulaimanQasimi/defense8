<?php

namespace Sq\Oil\Nova;

use Sq\Employee\Nova\CardInfo;
use App\Nova\Resource;
use DigitalCreative\MegaFilter\MegaFilter;
use DigitalCreative\MegaFilter\MegaFilterTrait;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use MZiraki\PersianDateField\PersianDate;
use Sq\Query\SqNovaDateFilter;
use Sq\Query\SqNovaNumberFilter;
use Sq\Query\SqNovaSelectFilter;
use Vehical\OilType;

class OilDisterbution extends Resource
{
    use MegaFilterTrait;
    public static $model = \Sq\Oil\Models\OilDisterbution::class;
    public static $title = 'id';
    public static $search = [
        'id',
    ];


    public static function label()
    {
        return __('Disterbuted Oil');
    }

    public static function singularLabel()
    {
        return __('Disterbuted Oil');
    }
    public function fields(NovaRequest $request)
    {
        return [

            BelongsTo::make(__('Employee'), 'card_info', CardInfo::class)->sortable(),

            Select::make(trans("Oil Type"), 'oil_type')
                ->options([
                    OilType::Diesel => trans("Diesel"),
                    OilType::Petrole => trans("Petrole"),
                ])
                ->rules('required', Rule::in([OilType::Diesel, OilType::Petrole]))
                ->filterable()
                ->displayUsingLabels()
                ->sortable(),

            Number::make(trans("Oil Amount"), "oil_amount")
                ->displayUsing(fn($oil_amount) => trans("Liter", ["value" => $oil_amount]))
                ->rules("required", 'numeric'),
            PersianDate::make(trans("Date"), 'filled_date')
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

                new SqNovaSelectFilter(label: trans("Oil Type"), column: 'oil_type', options: [
                    OilType::Diesel => trans("Diesel"),
                    OilType::Petrole => trans("Petrole"),
                ]),

                new SqNovaNumberFilter(label: trans("Oil Amount"), column: "oil_amount"),

                new SqNovaDateFilter(label: trans("Date"), column: 'filled_date'),

                ])->columns(3)
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
