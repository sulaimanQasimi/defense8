<?php
namespace Sq\Employee\Nova;

use App\Nova\Resource;
use DigitalCreative\MegaFilter\MegaFilter;
use DigitalCreative\MegaFilter\MegaFilterTrait;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use MZiraki\PersianDateField\PersianDate;
use Sq\Query\Policy\UserDepartment;
use Sq\Query\SqNovaDateFilter;
use Sq\Query\SqNovaTextFilter;

class GunCard extends Resource
{
    use MegaFilterTrait;

    public static $model = \Sq\Employee\Models\GunCard::class;

    public static $title = 'gun_no';

    public static $search = [
        'gun_no',
    ];

    public static function label()
    {
        return __('Gun Card');
    }

    public static function singularLabel()
    {
        return __('Gun Card');
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->whereHas('card_info', function ($query) {
            return $query->whereIn('department_id',  UserDepartment::getUserDepartment());
        });
    }

    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make(__('Employee'), 'card_info', CardInfo::class)
                ->relatableQueryUsing(function (NovaRequest $request, Builder $query) {
                    $query->whereIn('department_id',  UserDepartment::getUserDepartment());
                })
                ->searchable(),
            Text::make(__("Gun Type"), "gun_type")
                ->required()
                ->rules("required", "string"),
            Text::make(__("Gun No"), "gun_no")
                ->required()
                ->creationRules("required", "string", "unique:gun_cards,gun_no")
                ->updateRules("required", "string", "unique:gun_cards,gun_no,{{resourceId}}"),
            Text::make(__("Gun Range"), "range")
                ->required()
                ->rules("required", "string"),
            PersianDate::make(__("Disterbute Date"), "register_date")
                ->required()
                ->rules('required', 'date')
                ->placeholder(__("Enter Field", ['name' => __("Disterbute Date")])),
            PersianDate::make(__("Expire Date"), "expire_date")
                ->required()
                ->rules('required', 'date')
                ->placeholder(__("Enter Field", ['name' => __("Expire Date")])),

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

                new SqNovaTextFilter(label: trans("Gun Type"), column: 'gun_type'),
                //
                new SqNovaTextFilter(label: trans("Gun No"), column: 'gun_no'),
                //
                new SqNovaTextFilter(label: trans("Gun Range"), column: 'range'),
                //
                new SqNovaDateFilter(label: trans("Disterbute Date"), column: "register_date"),
                //
                new SqNovaDateFilter(label: trans("Expire Date"), column: "expire_date"),
            ])->columns(4)

        ];
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
        return [
            (new \Sq\Card\Nova\Actions\GunPrintCardAction)->onlyOnDetail()
            ->canRun(fn($request, $gun) => auth()->user()->hasPermissionTo("print-card")
            && in_array($gun->card_info->orginization->id, UserDepartment::getUserDepartment())
            && $gun->card_info->confirmed),

        ];
    }
}
