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
use Laravel\Nova\Fields\ID;
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
use Sq\Guest\Models\Host;
use Sq\Guest\Models\Patient as ModelsPatient;

class Patient extends Resource
{
    use MegaFilterTrait;

    /**
     * The model the resource corresponds to.
     *
     * @var class-string<\Sq\Guest\Models\Patient>
     */
    public static $model = ModelsPatient::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
        'name',
        'last_name',
        'phone',
        'barcode'
    ];

    public static function label()
    {
        return __('مریضان');
    }

    public static function singularLabel()
    {
        return __('مریض');
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
                ->orderBy('registered_at', 'desc')
                ->whereHas('host', function ($query) {
                    return $query->whereIn('department_id', UserDepartment::getUserDepartment());
                });
        }

        return $query->whereHas('host', function ($query) {
            return $query->whereIn('department_id', UserDepartment::getUserDepartment());
        });
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [

            URL::make(__("Print"), fn() => route('sqguest.patient.generate', $this)),


            Text::make(__("توکن"), 'barcode')
                ->sortable()
                ->filterable()
                ->exceptOnForms()
                ->copyable(),

            Text::make(__("Name"), 'name')
                ->required()
                ->sortable()
                ->rules('required', 'string')
                ->placeholder(__("Enter Field", ['name' => __("Name")])),

            Text::make(__("Last Name"), 'last_name')
                ->required()
                ->sortable()
                ->rules('required', 'string')
                ->placeholder(__("Enter Field", ['name' => __("Last Name")])),

            Text::make(__("Phone"), 'phone')
                ->required()
                ->sortable()
                ->rules('required', 'string')
                ->placeholder(__("Enter Field", ['name' => __("Phone")])),

            Text::make(__("Address"), 'address')
                ->nullable()
                ->sortable()
                ->rules('nullable', 'string')
                ->placeholder(__("Enter Field", ['name' => __("Address")])),


            Select::make(__("حالت"), 'status')
                ->options([
                    'active' => __('استفاده نشده'),
                    'inactive' => __('استفاده شده'),
                ])
                ->nullable()
                ->sortable()
                ->exceptOnForms(),

            Text::make(__("مریضی"), 'diseases')
                ->nullable()
                ->sortable()
                ->placeholder(__("Enter Field", ['name' => __("مریضی")])),

            Text::make(__("نام داکتر"), 'doctor_name')
                ->nullable()
                ->sortable()
                ->placeholder(__("Enter Field", ['name' => __("نام داکتر")])),

            Text::make(__("بخش مربوطه"), 'department')
                ->nullable()
                ->sortable()
                ->placeholder(__("Enter Field", ['name' => __("بخش مربوطه")])),

            BelongsTo::make(__("Host"), 'host', \Sq\Guest\Nova\Host::class)
                ->filterable()
                ->showCreateRelationButton()
                ->exceptOnForms(),

            PersianDateTime::make(__('تاریخ مراجعه'), 'registered_at')
                ->format('jYYYY/jMM/jDD h:mm a')
                ->required()
                ->rules('required', 'date')
                ->sortable(),

            Trix::make(trans("Remark"), 'remark')
                ->nullable()
                ->hideFromIndex(),

            MorphMany::make(trans("Activity Log"), 'activities', Activitylog::class),
        ];
    }

    /**
     * Get the cards available on the request.
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
        return [
            MegaFilter::make([
                new SqNovaTextFilter(column: 'name', label: trans("Name")),
                new SqNovaTextFilter(column: 'last_name', label: trans("Last Name")),
                new SqNovaTextFilter(column: 'phone', label: trans("Phone")),
                new SqNovaTextFilter(label: __("Address"), column: 'address'),

                new SqNovaSelectFilter(
                    label: __("حالت"),
                    column: 'status',
                    options: [
                        'active' => __('استفاده نشده'),
                        'inactive' => __('استفاده شده'),
                    ]
                ),

                new SqNovaTextFilter(label: __("مریضی"), column: 'diseases'),
                new SqNovaTextFilter(label: __("نام داکتر"), column: 'doctor_name'),
                new SqNovaTextFilter(label: __("بخش مربوطه"), column: 'department'),
                new SqNovaDateFilter(label: __("تاریخ مراجعه"), column: 'registered_at'),
                new SqNovaSelectFilter(
                    label: __("Host"),
                    column: 'host_id',
                    options: \Sq\Guest\Models\Host::query()
                        ->whereIn('department_id', UserDepartment::getUserDepartment())
                        ->pluck('head_name', 'id')
                        ->toArray()
                ),
            ])->columns(4),
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
            Action::openInNewTab("ایجاد توکن", fn($patient) => route('sqguest.patient.generate', ['patient' => $patient->id]))
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
