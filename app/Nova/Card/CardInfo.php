<?php

namespace App\Nova\Card;

use App\Nova\Actions\EditCardInfoOption;
use App\Nova\Actions\EditCardInfoRemark;
use App\Nova\Actions\ExportCardInfo;
use App\Nova\Attendance;
use App\Nova\Department;
use App\Nova\District;
use App\Nova\Gate;
use App\Nova\GuestOption;
use App\Nova\Province;
use App\Nova\Resource;
use App\Nova\Village;
use App\Support\Defense\EditAditionalCardInfoEnum;
use Coroowicaksono\ChartJsIntegration\LineChart;
use DigitalCreative\MegaFilter\MegaFilter;
use DigitalCreative\MegaFilter\MegaFilterTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Tag;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use MZiraki\PersianDateField\PersianDate;
use Sq\Query\SqNovaDateFilter;
use Sq\Query\SqNovaSelectFilter;
use Sq\Query\SqNovaTextFilter;
use Vehical\OilType;

class CardInfo extends Resource
{
    use MegaFilterTrait;

    public static $model = \App\Models\Card\CardInfo::class;

    public static $title = 'name';

    public static $showPollingToggle = true;
    public static $search = [
        'name',
        'last_name',
        'father_name',
        'grand_father_name',
        'job_structure',
        'national_id',
        'grade',
        'degree',
        'department',
        'registare_no',

    ];

    public static $tableStyle = 'tight';
    public static $trafficCop = false;
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query;
    }
    public static function label()
    {
        return __('Employees');
    }

    public static function singularLabel()
    {
        return __('Employee');
    }
    public function fields(NovaRequest $request)
    {
        return [
            Panel::make(__(), [
                // URL::make(trans("CURRENT MONTH ATTENDANCE EMPLOYEE"),fn()=>route('employee.attendance.current.month.single',['cardInfo'=>$this->id]))->onlyOnDetail(),
                \Laravel\Nova\Fields\Image::make(__("Photo"), "photo")->nullable()->rules("image"),
                Text::make(__("Register No"), "registare_no")
                    ->copyable()
                    ->required()
                    // ->rules('required', 'string')
                    ->creationRules('required', 'string', 'unique:card_infos,registare_no')
                    ->updateRules('required', 'string', 'unique:card_infos,registare_no,{{resourceId}}')
                    ->placeholder(__("Enter Field", ['name' => __("Register No")])),

                Text::make(__("Name"), "name")
                    ->required()
                    ->rules('required', 'string')
                    ->placeholder(__("Enter Field", ['name' => __("Name")]))
                    ->filterable()
                    ->sortable(),

                Text::make(__("Last Name"), "last_name")
                    ->required()
                    ->rules('required', 'string')
                    ->placeholder(__("Enter Field", ['name' => __("Last Name")]))
                    ->filterable()
                    ->sortable(),

                Text::make(__("Father Name"), "father_name")
                    ->nullable()
                    ->rules('nullable', 'string')
                    ->placeholder(__("Enter Field", ['name' => __("Father Name")]))
                    ->filterable()
                    ->sortable(),

                Text::make(__("Grand Father Name"), "grand_father_name")
                    ->nullable()
                    ->rules('nullable', 'string')
                    ->placeholder(__("Enter Field", ['name' => __("Grand Father Name")]))
                    ->filterable()
                    ->sortable(),

                Text::make(__("National ID"), "national_id")
                    ->nullable()
                    ->rules('nullable', 'string')
                    ->placeholder(__("Enter Field", ['name' => __("National ID")]))
                    ->filterable()
                    ->sortable(),

                Text::make(__("Phone"), "phone")

                    ->nullable()
                    ->rules('nullable', 'string')
                    ->placeholder(__("Enter Field", ['name' => __("Phone")]))
                    ->filterable()
                    ->sortable(),

                PersianDate::make(__("Date of Birth"), "birthday")
                    ->nullable()
                    ->rules('nullable', 'string')
                    ->placeholder(__("Enter Field", ['name' => __("Date of Birth")])),
            ]),
            Panel::make(__("Job"), [

                BelongsTo::make(__("Department/Chancellor"), 'orginization', Department::class)
                    ->searchable()
                    ->filterable()
                    ->sortable(),
                BelongsTo::make(__("Gate"), 'gate', Gate::class)->dependsOn(
                    ['orginization'],
                    function (BelongsTo $field, NovaRequest $request, FormData $formData) {

                        $field->relatableQueryUsing(function (NovaRequest $request, Builder $query) use ($formData) {
                            $query->where('department_id', $formData->orginization);
                        });
                    }
                ),


                Text::make(__("Degree"), "degree")
                    ->nullable()
                    ->rules('nullable', 'string')

                    ->placeholder(__("Enter Field", ['name' => __("Degree")])),
                Text::make(__("Grade"), "grade")
                    ->nullable()
                    ->rules('nullable', 'string')

                    ->placeholder(__("Enter Field", ['name' => __("Grade")])),
                Text::make(__("Acupation"), "acupation")
                    ->nullable()
                    ->rules('nullable', 'string')

                    ->placeholder(__("Enter Field", ['name' => __("Acupation")])),

                Text::make(__("Job Stracture Title"), "job_structure")
                    ->nullable()
                    ->rules('nullable', 'string')

                    ->placeholder(__("Enter Field", ['name' => __("Job Stracture Title")])),
                Text::make(__("Previous Job"), "previous_job")
                    ->nullable()
                    ->rules('nullable', 'string')

                    ->placeholder(__("Enter Field", ['name' => __("Previous Job")])),
                Text::make(__("Department/Chancellor"), "department")
                    ->nullable()
                    ->rules('nullable', 'string')
                    ->placeholder(__("Enter Field", ['name' => __("Department/Chancellor")])),

                Tag::make(__("Condition"), 'employeeOptions', GuestOption::class)->showCreateRelationButton()->displayAsList()->exceptOnForms(),

            ])->limit(0),
            Panel::make(__("Main Address"), [

                //
                BelongsTo::make(__("Province"), "main_province", Province::class)
                    ->nullable()
                    ->searchable()
                    ->showCreateRelationButton(),



                //
                BelongsTo::make(__("District"), "main_district", District::class)
                    ->dependsOn(
                        ['main_province'],
                        function (BelongsTo $field, NovaRequest $request, FormData $formData) {
                            $field->relatableQueryUsing(function (NovaRequest $request, Builder $query) use ($formData) {
                                $query->where('province_id', $formData->main_province);
                            });
                        }
                    )
                    ->nullable()
                    ->showCreateRelationButton(),


                //
                BelongsTo::make(__("Village"), "main_village", Village::class)
                    ->dependsOn(
                        ['main_district'],
                        function (BelongsTo $field, NovaRequest $request, FormData $formData) {
                            $field->relatableQueryUsing(function (NovaRequest $request, Builder $query) use ($formData) {
                                $query->where('district_id', $formData->main_district);
                            });
                        }
                    )
                    ->nullable()
                    ->showCreateRelationButton(),
            ])->limit(0),

            Panel::make(__("Current Address"), [
                BelongsTo::make(__("Province"), "current_province", Province::class)
                    ->nullable()
                    ->searchable(),

                BelongsTo::make(__("District"), "current_district", District::class)
                    ->dependsOn(
                        ['current_province'],
                        function (BelongsTo $field, NovaRequest $request, FormData $formData) {
                            $field->relatableQueryUsing(function (NovaRequest $request, Builder $query) use ($formData) {
                                $query->where('province_id', $formData->current_province);
                            });
                        }
                    )
                    ->nullable()

                    ->showCreateRelationButton(),

                BelongsTo::make(__("Village"), "current_village", Village::class)
                    ->dependsOn(
                        ['current_district'],
                        function (BelongsTo $field, NovaRequest $request, FormData $formData) {
                            $field->relatableQueryUsing(function (NovaRequest $request, Builder $query) use ($formData) {
                                $query->where('district_id', $formData->current_district);
                            });
                        }
                    )
                    ->nullable()
                    ->showCreateRelationButton(),

            ]),

            Trix::make(__("Remark"), 'remark')
                ->exceptOnForms()
                ->hideFromIndex(),
            HasOne::make(__("Main Card"), 'main_card', MainCard::class),
            HasOne::make(__("Gun Card"), 'gun_card', GunCard::class),
            HasMany::make(__("Employee Vehical Card"), 'employee_vehical_card', EmployeeVehicalCard::class),
            Panel::make(
                trans("Oil Disterbution"),
                [
                    Select::make(trans("Oil Type"), 'oil_type')
                        ->options([
                            OilType::Diesel => trans("Diesel"),
                            OilType::Petrole => trans("Petrole"),
                        ])
                        ->rules('required', Rule::in([OilType::Diesel, OilType::Petrole]))
                        ->filterable()
                        ->displayUsingLabels(),
                    Number::make(trans("Monthly Rate"), "monthly_rate")->displayUsing(fn($monthly_rate) => trans("Liter", ["value" => $monthly_rate]))->rules("required", 'numeric'),
                    Text::make(trans("Consumtion Amount"), fn() => $this->current_month_oil_consumtion)->displayUsing(fn($monthly_rate) => trans("Liter", ["value" => $monthly_rate]))->rules("required", 'numeric'),
                    Text::make(trans("Remain"), fn() => $this->current_month_oil_remain)->displayUsing(fn($monthly_rate) => trans("Liter", ["value" => $monthly_rate]))->rules("required", 'numeric')
                ]

            ),
            HasMany::make(__("Oil Report"), 'oil_disterbutions', \Sq\Oil\Nova\OilDisterbution::class),
            HasMany::make(__("Attendance"), 'attendance', Attendance::class),
        ];
    }
    public function cards(NovaRequest $request)
    {
        //
        $info = DB::table('card_infos')
            ->select(DB::raw('count(id) as num,year(created_at) as year'))
            ->groupByRaw("year(created_at)")
            ->orderBy('year')
            ->pluck('num', 'year');
        return [
            (new LineChart)
                ->title("")

                ->series(
                    array(
                        [
                            'barPercentage' => 0.5,
                            'label' => trans("Employees"),
                            'borderColor' => "#f7a35c",
                            'data' => $info
                        ]
                    )
                )
                ->options([
                    'xaxis' => collect($info)->keys()
                ]),
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
                    options: \App\Models\Department::pluck('fa_name', 'id')->toArray()
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
            (new ExportCardInfo())
                //->askForFilename()
                ->askForWriterType()
            ,
            (new EditCardInfoRemark())->canSee(fn() => auth()->user()->hasPermissionTo(EditAditionalCardInfoEnum::Remark)),
            (new EditCardInfoOption())->canSee(fn() => auth()->user()->hasPermissionTo(EditAditionalCardInfoEnum::Option)),
            // (new CurrentMonthAttendanceEmployeeAction)
            Action::openInNewTab(
                __("Download CURRENT MONTH ATTENDANCE EMPLOYEE"),
                fn($employee) => route('employee.attendance.current.month.single', ['cardInfo' => $employee->id])
            )
                ->sole()
                //  ->canRun(fn($request, $employee) => auth()->user()->department?->id === $employee->orginization?->id)
                ->withoutConfirmation()
                ->onlyOnDetail(),
            (new \Sq\Card\Nova\Actions\PrintAllTypeCardEmployeeAction)->onlyOnDetail()->canRun(fn() => auth()->user()->hasRole("Print Card"))

        ];
    }
}
