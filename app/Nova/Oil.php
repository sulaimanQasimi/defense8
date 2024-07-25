<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use MZiraki\PersianDateField\PersianDate;
use Vehical\OilType;
use Vehical\Vehical;

class Oil extends Resource
{
    public static $model = \App\Models\Oil::class;
    public static $title = 'code';
    public static $search = [
        'code',
    ];

    public static function label()
    {
        return __('Oil');
    }

    public static function singularLabel()
    {
        return __('Oil');
    }
    public function fields(NovaRequest $request)
    {
        return [
            Text::make(trans("Code"),'code')->exceptOnForms(),
            Select::make(trans("Oil Type"), 'oil_type')
            ->options([
                OilType::Diesel => trans("Diesel"),
                OilType::Petrole => trans("Petrole"),
            ])
            ->rules('required', Rule::in([OilType::Diesel,OilType::Petrole]))
            ->filterable()
            ->displayUsingLabels(),
            // $table->string('oil_type')->nullable();
            Select::make(trans("Oil Quality"), 'oil_quality')
            ->options(Vehical::oil_quality())
            ->rules('required', Rule::in(Vehical::oil_quality()))
            ->filterable()
            ->displayUsingLabels(),
            Number::make(trans("Oil Amount"),"oil_amount")
            ->displayUsing(fn ($oil_amount)=> trans("Liter",["value"=>$oil_amount]))->rules("required",'numeric'),
            PersianDate::make(trans("Date"),'filled_date'),
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
