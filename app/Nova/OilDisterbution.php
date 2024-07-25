<?php

namespace App\Nova;

use App\Nova\Card\CardInfo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;
use MZiraki\PersianDateField\PersianDate;
use Vehical\OilType;

class OilDisterbution extends Resource
{
    public static $model = \App\Models\OilDisterbution::class;
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

            BelongsTo::make(__('Employee'), 'card_info', CardInfo::class),
            Select::make(trans("Oil Type"), 'oil_type')
                ->options([
                    OilType::Diesel => trans("Diesel"),
                    OilType::Petrole => trans("Petrole"),
                ])
                ->rules('required', Rule::in([OilType::Diesel, OilType::Petrole]))
                ->filterable()
                ->displayUsingLabels(),
            // $table->string('oil_type')->nullable();

            Number::make(trans("Oil Amount"), "oil_amount")
                ->displayUsing(fn($oil_amount) => trans("Liter", ["value" => $oil_amount]))->rules("required", 'numeric'),
            PersianDate::make(trans("Date"), 'filled_date')
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
