<?php

namespace Sq\Oil\Nova;

use DigitalCreative\MegaFilter\MegaFilter;
use DigitalCreative\MegaFilter\MegaFilterTrait;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\OilNovaResource;
use Laravel\Nova\Panel;
use MZiraki\PersianDateField\PersianDate;
use Sq\Employee\Nova\Department;
use Sq\Query\SqNovaDateFilter;
use Sq\Query\SqNovaSelectFilter;
use Sq\Query\SqNovaTextFilter;
use Vehical\OilType;

use Illuminate\Database\Eloquent\Builder;

class QuotaOil extends OilNovaResource
{
    use MegaFilterTrait;
    public static $model = \Sq\Employee\Models\CardInfo::class;

    public static $title = 'registare_no';

    public static $clickAction = 'edit';
    public static $search = [
        'registare_no',
    ];
    public static function label()
    {
        return __('Quota Oil');
    }

    public static function singularLabel()
    {
        return __('Quota Oil');
    }

    public function fields(NovaRequest $request)
    {
        return [
            Panel::make(__(''), [
                // URL::make(trans("CURRENT MONTH ATTENDANCE EMPLOYEE"),fn()=>route('employee.attendance.current.month.single',['cardInfo'=>$this->id]))->onlyOnDetail(),
                Fields\Image::make(__("Photo"), "photo")->exceptOnForms(),
                //
                Fields\Text::make(__("Register No"), "registare_no")->exceptOnForms(),
                //
                Fields\Text::make(__("Name"), "name")->exceptOnForms(),
                //
                Fields\Text::make(__("Last Name"), "last_name")->exceptOnForms(),
                //
                Fields\Text::make(__("Father Name"), "father_name")->exceptOnForms(),
                //
                Fields\Text::make(__("Grand Father Name"), "grand_father_name")->exceptOnForms(),
                //
                Fields\Text::make(__("National ID"), "national_id")->exceptOnForms(),
                //
                Fields\Text::make(__("Phone"), "phone")->exceptOnForms(),
                //
                PersianDate::make(__("Date of Birth"), "birthday")->exceptOnForms(),
            ]),
            Panel::make(__("Job"), [

                Fields\BelongsTo::make(__("Department/Chancellor"), 'orginization', Department::class)->exceptOnForms(),
                Fields\BelongsTo::make(__("Gate"), 'gate', \Sq\Employee\Nova\Gate::class)
                    ->dependsOn(
                        ['orginization'],
                        function (Fields\BelongsTo $field, NovaRequest $request, Fields\FormData $formData) {

                            $field->relatableQueryUsing(function (NovaRequest $request, Builder $query) use ($formData) {
                                $query->where('department_id', $formData->orginization);
                            });
                        }
                    )->exceptOnForms(),

                Fields\Text::make(__("Degree"), "degree")->exceptOnForms(),
                Fields\Text::make(__("Grade"), "grade")->exceptOnForms(),
                Fields\Text::make(__("Acupation"), "acupation")->exceptOnForms(),

                Fields\Text::make(__("Job Stracture Title"), "job_structure")->exceptOnForms(),
                Fields\Text::make(__("Previous Job"), "previous_job")->exceptOnForms(),
                Fields\Text::make(__("Department/Chancellor"), "department")->exceptOnForms(),
            ])->limit(0),
            Panel::make(
                trans("Oil Disterbution"),
                [

                    Fields\Select::make(trans("Oil Type"), 'oil_type')
                        ->options([
                            OilType::Diesel => trans("Diesel"),
                            OilType::Petrole => trans("Petrole"),
                        ])
                        ->rules('required', Rule::in([OilType::Diesel, OilType::Petrole]))
                        ->filterable()
                        ->displayUsingLabels(),

                        Fields\Select::make(trans("Type"), 'employee_type')
                        ->options([
                            "grade" => trans("Grade Rate"),
                            "duty" => trans("Duty Response"),
                        ])
                        ->rules('required', Rule::in(['grade', "duty"]))
                        ->filterable()
                        ->displayUsingLabels()
                        ->sortable(),

                    Fields\Number::make(trans("Monthly Rate"), "monthly_rate")
                        ->displayUsing(fn($monthly_rate) => trans("Liter", ["value" => $monthly_rate]))
                        ->rules("required", 'numeric'),

                    Fields\Text::make(trans("Consumtion Amount"), fn() => $this->current_month_oil_consumtion)
                        ->displayUsing(fn($monthly_rate) => trans("Liter", ["value" => $monthly_rate]))
                        ->rules("required", 'numeric'),

                    Fields\Text::make(trans("Remain"), fn() => $this->current_month_oil_remain)
                        ->displayUsing(fn($monthly_rate) => trans("Liter", ["value" => $monthly_rate]))
                        ->rules("required", 'numeric')
                ]

            ),
            Fields\HasMany::make(__("Oil Report"), 'oil_disterbutions', \Sq\Oil\Nova\OilDisterbution::class),

        ];
    }

    public function filters(NovaRequest $request)
    {
        return [

            MegaFilter::make([
                //
                new SqNovaTextFilter(label: __("Register No"), column: 'registare_no'),
                //
                new SqNovaTextFilter(label: __("Name"), column: 'name'),
                //
                new SqNovaTextFilter(label: __("Last Name"), column: 'last_name'),
                //
                new SqNovaTextFilter(label: __("Father Name"), column: 'father_name'),
                //
                new SqNovaTextFilter(label: __("Grand Father Name"), column: 'grand_father_name'),
                //
                new SqNovaTextFilter(label: __("National ID"), column: 'national_id'),
                //
                new SqNovaTextFilter(label: __("Phone"), column: 'phone'),
                //
                new SqNovaDateFilter(label: __("Date of Birth"), column: 'birthday'),
                //
                new SqNovaTextFilter(label: __("Degree"), column: 'degree'),
                //
                new SqNovaTextFilter(label: __("Grade"), column: 'grade'),
                //
                new SqNovaTextFilter(label: __("Acupation"), column: 'acupation'),
                //
                new SqNovaTextFilter(label: __("Job Stracture Title"), column: 'job_structure'),
                //
                new SqNovaTextFilter(label: __("Previous Job"), column: 'previous_job'),
                //
                new SqNovaSelectFilter(
                    label: __("Department/Chancellor"),
                    column: 'department_id',
                    options: \Sq\Employee\Models\Department::pluck('fa_name', 'id')->toArray()
                ),
                //
                new SqNovaSelectFilter(
                    label: trans("Oil Type"),
                    column: 'oil_type',
                    options: [
                        OilType::Diesel => trans("Diesel"),
                        OilType::Petrole => trans("Petrole"),
                    ]
                ),
                //
                new SqNovaTextFilter(label: trans("Monthly Rate"), column: "monthly_rate"),
            ])->columns(4)
        ];
    }

    public static function redirectAfterCreate(NovaRequest $request, $resource)
    {
        return '/resources/'.static::uriKey();
    }
    public static function redirectAfterUpdate(NovaRequest $request, $resource)
    {
        return '/resources/'.static::uriKey();
    }
    public function actions(NovaRequest $request)
    {
        return [];
    }
    public static $trafficCop = false;
    public static $showPollingToggle = true;

    public static $perPageViaRelationship = 20;

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query;
    }

    public static function scoutQuery(NovaRequest $request, $query)
    {
        return $query;
    }
    public static function detailQuery(NovaRequest $request, $query)
    {
        return parent::detailQuery($request, $query);
    }

    public static function relatableQuery(NovaRequest $request, $query)
    {
        return parent::relatableQuery($request, $query);
    }

    public static function perPageOptions()
    {
        return [20, 50, 75, 100, 150];
    }

}
