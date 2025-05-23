<?php

namespace Sq\Employee\Nova;

use Afj95\LaravelNovaHijriDatepickerField\HijriDatePicker;
use App\Nova\Resource;
use App\Support\Defense\PermissionTranslation;
use Bolechen\NovaActivitylog\Resources\Activitylog;
use DigitalCreative\MegaFilter\MegaFilter;
use DigitalCreative\MegaFilter\MegaFilterTrait;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use MZiraki\PersianDateField\PersianDate;
use Sq\Employee\Nova\Actions\GunCardExtension;
use Sq\Employee\Nova\Filters\ConfirmedFilter;
use Sq\Query\Policy\UserDepartment;
use Sq\Query\SqNovaDateFilter;
use Sq\Query\SqNovaTextFilter;
use App\Nova\User;
use Sq\Employee\Nova\Actions\ConfirmGunCardAction;

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
            return $query->whereIn('department_id', UserDepartment::getUserDepartment());
        });
    }

    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make(__('Employee'), 'card_info', CardInfo::class)
                ->relatableQueryUsing(function (NovaRequest $request, Builder $query) {
                    $query->whereIn('department_id', UserDepartment::getUserDepartment());
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

            HijriDatePicker::make(__("Disterbute Date"), "register_date")
                ->format('iYYYY/iMM/iDD')
                ->placeholder('YYYY/MM/DD')
                ->selected_date('1444/12/12')
                ->placement('bottom')
                ->hideWhenUpdating(),

            HijriDatePicker::make(__("Expire Date"), "expire_date")
                ->format('iYYYY/iMM/iDD')
                ->placeholder('YYYY/MM/DD')
                ->selected_date('1444/12/12')
                ->placement('bottom')
                ->hideWhenUpdating(),

            Trix::make(trans('Remark'), 'remark'),
            Boolean::make(__("Print"), 'printed')->hideWhenCreating(),
            Boolean::make(__("Confirmed"), 'confirmed')
                ->help(__('Indicates whether this gun card has been confirmed'))
                ->canSee(function ($request) {
                    return $request->user()->hasPermissionTo('view-gun-card-confirmation');
                })
                ->readonly(function ($request) {
                    return !$request->user()->hasPermissionTo('confirm-gun-card');
                }),

            BelongsTo::make(__('Confirmed By'), 'confirmedByUser', User::class)
                ->nullable()
                ->searchable()
                ->withoutTrashed()
                ->canSee(function ($request) {
                    return $request->user()->hasPermissionTo('view-gun-card-confirmation');
                }),

            MorphMany::make(trans("Activity Log"), 'activities', Activitylog::class),
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
                //
                new ConfirmedFilter,
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
            \Sq\Card\Nova\Actions\GunPrintCardAction::make()
                ->sole()
                ->canRun(
                    fn($request, $gun) => auth()->user()->hasPermissionTo("print-card")
                        && in_array($gun->card_info->orginization->id, UserDepartment::getUserDepartment())
                        && !$gun->printed
                        && $gun->confirmed

                ),
            \Sq\Card\Nova\Actions\GunPrintPaperCardAction::make()
                ->sole()
                ->canRun(
                    fn($request, $gun) => auth()->user()->hasPermissionTo("print-card")
                        && in_array($gun->card_info->orginization->id, UserDepartment::getUserDepartment())
                        && !$gun->printed
                        && $gun->confirmed

                ),

            GunCardExtension::make()
                ->sole()
                ->canRun(
                    fn($request, $gun) => auth()->user()->hasPermissionTo(PermissionTranslation::update("Main Card"))
                        && in_array($gun->card_info->orginization->id, UserDepartment::getUserDepartment())
                        && $gun->confirmed
                ),

            \Sq\Employee\Nova\Actions\ConfirmGunCardAction::make()
                ->canRun(
                    fn($request, $gun) => auth()->user()->hasPermissionTo("confirm-gun-card")
                        && in_array($gun->card_info->orginization->id, UserDepartment::getUserDepartment())
                        && !$gun->confirmed
                ),

        ];
    }
}
