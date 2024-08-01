<?php
namespace App\Nova;

use Carbon\Carbon;
use DigitalCreative\MegaFilter\MegaFilter;
use DigitalCreative\MegaFilter\MegaFilterTrait;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Tag;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;
use MZiraki\PersianDateField\PersianDateTime;
use Sq\Query\SqNovaDateFilter;
use Sq\Query\SqNovaSelectFilter;
use Sq\Query\SqNovaTextFilter;

class Guest extends Resource
{

    use MegaFilterTrait;

    public static $model = \App\Models\Guest::class;
    public static $title = 'name';
    public static $search = [
        'name',
    ];

    public static function label()
    {
        return __('Guests');
    }

    public static function singularLabel()
    {
        return __('Guest');
    }

    public static function indexQuery(NovaRequest $request, $query)
    {

        if (auth()->user()->host) {
            return $query->where('host_id', auth()->user()->host->id)->orderBy('registered_at', 'desc');
        }

        if (auth()->user()->can('gateChecker', 'App\\Models\Gate')) {
            return $query
                ->whereYear('registered_at', now()->year)
                ->whereMonth("registered_at", now()->month)
                ->whereDay("registered_at", now()->day)
                ->orderBy('registered_at', 'desc');
        }
        return $query->orderBy('registered_at', "desc");
    }
    public function fields(NovaRequest $request)
    {
        return [

            URL::make(__("Print"), fn() => route('guest.generate', $this)),

            // Guest Name
            Text::make(__("Name"), 'name')
                ->required()
                ->sortable()
                ->rules('required', 'string')
                ->hideWhenUpdating(fn() => $this->registered_at->isBefore(Carbon::today()))

                ->placeholder(__("Enter Field", ['name' => __("Name")])),

            // Guest Last Name
            Text::make(__("Last Name"), 'last_name')
                ->required()
                ->sortable()

                ->rules('required', 'string')
                ->placeholder(__("Enter Field", ['name' => __("Last Name")]))
                ->hideWhenUpdating(fn() => $this->registered_at->isBefore(Carbon::today()))

            ,

            // Career
            Text::make(__("Career"), 'career')
                ->required()
                ->sortable()
                ->rules('required', 'string')
                ->placeholder(__("Enter Field", ['name' => __("Career")])),


            // Host
            BelongsTo::make(__("Host"), 'host', Host::class)
                ->filterable()
                ->showCreateRelationButton()
                ->exceptOnForms(),

            //
            Text::make(__("Invited By"), fn() => $this->host->head_name),

            Text::make(__("Address"), 'address')
                ->required()
                ->sortable()
                ->hideWhenUpdating(fn() => $this->registered_at->isBefore(Carbon::today()))

                ->rules('required', 'string'),

            // ‌Boolean::make(__('Status'),'status')->onlyIndex(),
            PersianDateTime::make(__("Guest Enter Date"), 'registered_at')
                ->format('jYYYY/jMM/jDD h:mm a')
                ->hideWhenUpdating(fn() => $this->registered_at->isBefore(Carbon::today()))
                ->required()->rules('required', 'date'),

            Select::make(__("Enter Gate"), 'enter_gate')
                ->options(
                    \App\Support\Defense\Gate::gate_options()
                )->filterable()
                ->displayUsingLabels()
                ->required()
                ->creationRules('required')
                ->hideWhenUpdating(fn() => $this->registered_at->isBefore(Carbon::today())),

            Tag::make(__("Condition"), 'Guestoptions', GuestOption::class)->showCreateRelationButton()->displayAsList(),

            Trix::make(trans("Remark"), 'remark')->nullable(),

            HasMany::make(__("Gate Passed"), 'guestGate', GuestGate::class),

        ];
    }

    public function cards(NovaRequest $request)
    {
        return [
            // new HostGuestValue(),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
            MegaFilter::make([
                new SqNovaTextFilter(column: 'name', label: trans("Name")),
                new SqNovaTextFilter(column: 'last_name', label: trans("Last Name")),
                new SqNovaTextFilter(label: __("Career"), column: 'career'),
                new SqNovaTextFilter(label: __("Address"), column: 'address'),
                new SqNovaDateFilter(label: __("Guest Enter Date"), column: 'registered_at'),
                new SqNovaSelectFilter(
                    label: __("Enter Gate"),
                    column: 'enter_gate',
                    options: \App\Support\Defense\Gate::key_value_filter_options()
                ),
                new SqNovaSelectFilter(
                    label: __("Host"),
                    column: 'host_id',
                    options: \App\Models\Host::pluck('head_name','id')->toArray()
                ),

            ])->columns(3),
            
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
        return [];
    }
    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        return '/resources/' . static::uriKey();
    }
}
