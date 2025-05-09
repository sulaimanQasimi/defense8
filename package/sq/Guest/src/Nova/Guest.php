<?php

namespace Sq\Guest\Nova;

use App\Nova\Resource;
use Bolechen\NovaActivitylog\Resources\Activitylog;
use Carbon\Carbon;
use DigitalCreative\MegaFilter\MegaFilter;
use DigitalCreative\MegaFilter\MegaFilterTrait;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Tag;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Http\Requests\NovaRequest;
use MZiraki\PersianDateField\PersianDateTime;
use Sq\Employee\Models\Gate as ModelsGate;
use Sq\Employee\Nova\Gate;
use Sq\Query\Policy\UserDepartment;
use Sq\Query\SqNovaDateFilter;
use Sq\Query\SqNovaSelectFilter;
use Sq\Query\SqNovaTextFilter;

class Guest extends Resource
{
    use MegaFilterTrait;

    public static $model = \Sq\Guest\Models\Guest::class;
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

        if (auth()->user()->hasRole('super-admin')) {
            return $query;
        }

        if (auth()->user()->host) {
            return $query->where('host_id', auth()->user()->host->id)->orderBy('registered_at', 'desc');
        }

        if (auth()->user()->can('gateChecker', 'App\\Models\Gate')) {
            return $query
                ->whereYear('registered_at', now()->year)
                ->whereMonth("registered_at", now()->month)
                ->whereDay("registered_at", now()->day)
                ->orderBy('registered_at', 'desc')
                ->whereHas('host', function ($query) {
                    return $query->whereIn('department_id', UserDepartment::getUserDepartment());
                });
        }

        return $query->whereHas('host', function ($query) {
            return $query->whereIn('department_id', UserDepartment::getUserDepartment());
        });
    }

    public function fields(NovaRequest $request)
    {
        return [
            URL::make(__("Print"), fn() => route('sqguest.guest.generate', $this)),

            Text::make(__("Name"), 'name')
                ->required()
                ->sortable()
                ->rules('required', 'string')
                ->hideWhenUpdating(fn() => $this->registered_at->isBefore(Carbon::today()))
                ->placeholder(__("Enter Field", ['name' => __("Name")])),

            Text::make(__("Last Name"), 'last_name')
                ->required()
                ->sortable()
                ->rules('required', 'string')
                ->placeholder(__("Enter Field", ['name' => __("Last Name")]))
                ->hideWhenUpdating(fn() => $this->registered_at->isBefore(Carbon::today())),

            Text::make(__("Career"), 'career')
                ->required()
                ->sortable()
                ->rules('required', 'string')
                ->placeholder(__("Enter Field", ['name' => __("Career")])),

            BelongsTo::make(__("Host"), 'host', Host::class)
                ->filterable()
                ->showCreateRelationButton()
                ->exceptOnForms(),
            Text::make(__("Invited By"), fn() => $this->host->head_name),

            Text::make(__('Address'), 'address')
                ->required()
                ->sortable()
                ->hideWhenUpdating(fn() => $this->registered_at->isBefore(Carbon::today()))
                ->rules('required', 'string'),

            Text::make(__('نوع واسطه'), 'vehical_type')
                ->nullable()
                ->sortable()
                ->placeholder(__('Enter Field', ['name' => __('Vehicle Type')])),

            Text::make(__('رنگ واسطه'), 'vehical_color')
                ->nullable()
                ->sortable()
                ->placeholder(__('Enter Field', ['name' => __('Vehicle Color')])),

            PersianDateTime::make(__('Guest Enter Date'), 'registered_at')
                ->format('jYYYY/jMM/jDD h:mm a')
                ->hideWhenUpdating(fn() => $this->registered_at->isBefore(Carbon::today()))
                ->required()->rules('required', 'date'),

            Select::make(__("Enter Gate"), 'gate_id')->options(ModelsGate::query()->whereIn('id', UserDepartment::getUserGuestGate())->pluck('fa_name', 'id'))
            ->required()
            ->rules('required'),

            Tag::make(__("Condition"), 'Guestoptions', GuestOption::class)
                ->showCreateRelationButton()
                ->displayAsList(),
            Trix::make(trans("Remark"), 'remark')->nullable(),

            HasMany::make(__("Gate Passed"), 'guestGate', GuestGate::class),
            MorphMany::make(trans("Activity Log"), 'activities', Activitylog::class),
        ];
    }

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
                    options: \Sq\Guest\Models\Host::query()
                        ->whereIn('department_id', UserDepartment::getUserDepartment())
                        ->pluck('head_name', 'id')
                        ->toArray()
                ),
            ])->columns(3),
        ];
    }

    public function actions(NovaRequest $request)
    {
        return [
            Action::openInNewTab("ایجاد توکن", fn($guest) => route('sqguest.guest.generate', ['guest' => $guest->id]))
                ->sole()
                ->withoutConfirmation()
            // ->canRun(fn() => in_array($this->host->department_id, UserDepartment::getUserDepartment()) || $this?->host?->user_id == auth()->user()->id)
        ];
    }


    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        return '/resources/' . static::uriKey();
    }
}
