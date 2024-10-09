<?php

namespace Sq\Employee\Nova;

use Acme\EmployeeAttendanceStatistic\EmployeeAttendanceStatistic;
use Acme\StripeInspector\StripeInspector;
use App\Nova\Actions\EditCardInfoOption;
use App\Nova\Actions\EditCardInfoRemark;
use App\Nova\Actions\ExportCardInfo;
use Sq\Card\Nova\PrintCard;
use Sq\Employee\Nova\Actions\ConfirmEmployee;
use Sq\Location\Nova as Location;
use App\Nova\Resource;
use App\Support\Defense\EditAditionalCardInfoEnum;
use DigitalCreative\MegaFilter\MegaFilter;
use DigitalCreative\MegaFilter\MegaFilterTrait;
use Illuminate\Database\Eloquent\Builder;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use MZiraki\PersianDateField\PersianDate;
use Sq\Query\Policy\UserDepartment;
use Sq\Query\SqNovaDateFilter;
use Sq\Query\SqNovaSelectFilter;
use Sq\Query\SqNovaTextFilter;
use Vehical\OilType;

class CardInfo extends Resource
{
    use MegaFilterTrait;

    public static $model = \Sq\Employee\Models\CardInfo::class;

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
        if (auth()->user()->hasRole('super-admin')) {
            return $query;
        }

        return $query->whereIn('department_id', UserDepartment::getUserDepartment());
    }
    public static function label()
    {
        return __('Employees');
    }

    public static function singularLabel()
    {
        return __('Employee');
    }
    public function fields(NovaRequest $request): array
    {
        return [
            Panel::make(__(), [
                // URL::make(trans("CURRENT MONTH ATTENDANCE EMPLOYEE"),fn()=>route('employee.attendance.current.month.single',['cardInfo'=>$this->id]))->onlyOnDetail(),
                Fields\Image::make(__("Photo"), "photo")->nullable()->rules("image"),
                Fields\Boolean::make(__("Confirmed"), 'confirmed')->exceptOnForms(),
                Fields\Text::make(__("Register No"), "registare_no")
                    ->copyable()
                    ->required()
                    // ->rules('required', 'string')
                    ->creationRules('required', 'string', 'unique:card_infos,registare_no')
                    ->updateRules('required', 'string', 'unique:card_infos,registare_no,{{resourceId}}')
                    ->placeholder(__("Enter Field", ['name' => __("Register No")])),

                Fields\Text::make(__("Name"), "name")
                    ->required()
                    ->rules('required', 'string')
                    ->placeholder(__("Enter Field", ['name' => __("Name")]))
                    ->filterable()
                    ->sortable()
                    ->suggestions(\Sq\Query\Resource\NameSugestion::make()),

                Fields\Text::make(__("Last Name"), "last_name")
                    ->nullable()
                    ->rules('nullable', 'string')
                    ->placeholder(__("Enter Field", ['name' => __("Last Name")]))
                    ->filterable()
                    ->sortable(),

                Fields\Text::make(__("Father Name"), "father_name")
                    ->nullable()
                    ->rules('nullable', 'string')
                    ->placeholder(__("Enter Field", ['name' => __("Father Name")]))
                    ->filterable()
                    ->sortable(),

                Fields\Text::make(__("Grand Father Name"), "grand_father_name")
                    ->nullable()
                    ->rules('nullable', 'string')
                    ->placeholder(__("Enter Field", ['name' => __("Grand Father Name")]))
                    ->filterable()
                    ->sortable(),

                Fields\Text::make(__("National ID"), "national_id")
                    ->nullable()
                    ->creationRules('nullable', 'string', 'unique:card_infos,national_id')
                    ->updateRules('nullable', 'string', 'unique:card_infos,national_id,{{resourceId}}')
                    ->placeholder(__("Enter Field", ['name' => __("National ID")]))
                    ->filterable()
                    ->sortable()
                    ->hideFromIndex(),

                Fields\Text::make(__("Phone"), "phone")

                    ->nullable()
                    ->rules('nullable', 'string')
                    ->placeholder(__("Enter Field", ['name' => __("Phone")]))
                    ->filterable()
                    ->sortable()
                    ->hideFromIndex(),

                PersianDate::make(__("Date of Birth"), "birthday")
                    ->nullable()
                    ->rules('nullable', 'string')
                    ->placeholder(__("Enter Field", ['name' => __("Date of Birth")]))
                    ->hideFromIndex(),
            ]),
            Panel::make(__("Job"), $this->job_fields())->limit(0),
            Panel::make(__("Main Address"), [

                //
                Fields\BelongsTo::make(__("Province"), "main_province", Location\Province::class)
                    ->nullable()
                    ->searchable()
                    ->hideFromIndex()
                    ->showCreateRelationButton(),
                //
                Fields\BelongsTo::make(__("District"), "main_district", Location\District::class)
                    ->dependsOn(
                        ['main_province'],
                        function (Fields\BelongsTo $field, NovaRequest $request, Fields\FormData $formData) {
                            $field->relatableQueryUsing(function (NovaRequest $request, Builder $query) use ($formData) {
                                $query->where('province_id', $formData->main_province);
                            });
                        }
                    )
                    ->nullable()
                    ->hideFromIndex()
                    ->showCreateRelationButton(),
                //
                Fields\BelongsTo::make(__("Village"), "main_village", Location\Village::class)
                    ->dependsOn(
                        ['main_district'],
                        function (Fields\BelongsTo $field, NovaRequest $request, Fields\FormData $formData) {
                            $field->relatableQueryUsing(function (NovaRequest $request, Builder $query) use ($formData) {
                                $query->where('district_id', $formData->main_district);
                            });
                        }
                    )
                    ->nullable()
                    ->hideFromIndex()
                    ->showCreateRelationButton(),
            ])->limit(0),

            Panel::make(__("Current Address"), [
                Fields\BelongsTo::make(__("Province"), "current_province", Location\Province::class)
                    ->nullable()
                    ->searchable()
                    ->hideFromIndex()
                    ->showCreateRelationButton(),

                Fields\BelongsTo::make(__("District"), "current_district", Location\District::class)
                    ->dependsOn(
                        ['current_province'],
                        function (Fields\BelongsTo $field, NovaRequest $request, Fields\FormData $formData) {
                            $field->relatableQueryUsing(function (NovaRequest $request, Builder $query) use ($formData) {
                                $query->where('province_id', $formData->current_province);
                            });
                        }
                    )
                    ->nullable()
                    ->hideFromIndex()
                    ->showCreateRelationButton(),

                Fields\BelongsTo::make(__("Village"), "current_village", Location\Village::class)
                    ->dependsOn(
                        ['current_district'],
                        function (Fields\BelongsTo $field, NovaRequest $request, Fields\FormData $formData) {
                            $field->relatableQueryUsing(function (NovaRequest $request, Builder $query) use ($formData) {
                                $query->where('district_id', $formData->current_district);
                            });
                        }
                    )
                    ->nullable()
                    ->hideFromIndex()
                    ->showCreateRelationButton(),

            ]),

            Fields\Trix::make(__("Remark"), 'remark')
                ->exceptOnForms()
                ->hideFromIndex(),
            Fields\HasOne::make(__("Main Card"), 'main_card', MainCard::class),
            Fields\HasMany::make(__("Gun Card"), 'gun_card', GunCard::class),
            Fields\HasMany::make(__("Employee Vehical Card"), 'employee_vehical_card', EmployeeVehicalCard::class),
            Panel::make(
                trans("Oil Disterbution"),
                [

                    Fields\Select::make(trans("Oil Type"), 'oil_type')
                        ->options([
                            OilType::Diesel => trans("Diesel"),
                            OilType::Petrole => trans("Petrole"),
                        ])
                        ->exceptOnForms()
                        ->filterable()
                        ->displayUsingLabels(),

                    Fields\Number::make(trans("Monthly Rate"), "monthly_rate")
                        ->displayUsing(fn($monthly_rate) => trans("Liter", ["value" => $monthly_rate]))
                        ->onlyOnDetail(),

                    Fields\Text::make(trans("Consumtion Amount"), fn() => $this->current_month_oil_consumtion)
                        ->displayUsing(fn($monthly_rate) => trans("Liter", ["value" => $monthly_rate]))
                        ->onlyOnDetail(),

                    Fields\Text::make(trans("Remain"), fn() => $this->current_month_oil_remain)
                        ->displayUsing(fn($monthly_rate) => trans("Liter", ["value" => $monthly_rate]))
                        ->onlyOnDetail()
                ]

            ),
            Fields\HasMany::make(__("Oil Report"), 'oil_disterbutions', \Sq\Oil\Nova\OilDisterbution::class),
            Fields\HasMany::make(name: __("Attendance"), attribute: 'attendance', resource: Attendance::class),
            Fields\HasMany::make(name: __("Print Card"), attribute: 'print_cards', resource: PrintCard::class),
            StripeInspector::make(),
            Fields\HasMany::make(name: __("Scaned Employee"), attribute: 'scaned_employee', resource: ScanedEmployee::class)
        ];
    }
    public function cards(NovaRequest $request)
    {
        return [
            (new EmployeeAttendanceStatistic())
                ->onlyOnDetail()
                ->attentenceLabel(__("Present"), true),
            (new EmployeeAttendanceStatistic())
                ->onlyOnDetail()
                ->attentenceLabel(__("Upsent"), false)
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
                    options: \Sq\Employee\Models\Department::query()
                        ->whereIn('id', UserDepartment::getUserDepartment())
                        ->pluck('fa_name', 'id')->toArray()
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
    public function actions(NovaRequest $request)
    {
        return [
            (new ExportCardInfo())
                //->askForFilename()
                ->askForWriterType()
            ,
            (new EditCardInfoRemark())
                ->canSee(fn() => auth()->user()->hasPermissionTo(EditAditionalCardInfoEnum::Remark))
                ->canRun(
                    fn($request, $infoCard) => EditAditionalCardInfoEnum::Remark
                    && in_array($infoCard->orginization->id, UserDepartment::getUserDepartment())
                    && $infoCard->confirmed
                ),

            // Edit Options
            (new EditCardInfoOption())
                ->canSee(fn() => auth()->user()->hasPermissionTo(EditAditionalCardInfoEnum::Option))
                ->canRun(fn($request, $infoCard) => EditAditionalCardInfoEnum::Remark
                    && in_array($infoCard->orginization->id, UserDepartment::getUserDepartment())
                    && $infoCard->confirmed),

            // Download Attendance
            Action::openInNewTab(
                __("Download CURRENT MONTH ATTENDANCE EMPLOYEE"),
                fn($employee) => route('sqemployee.employee.attendance.current.month.single', ['cardInfo' => $employee->id])
            )
                ->sole()
                ->canRun(fn($request, $infoCard) => in_array($infoCard->orginization->id, UserDepartment::getUserDepartment()))
                ->withoutConfirmation()

                ->onlyOnDetail(),

            (new \Sq\Card\Nova\Actions\PrintAllTypeCardEmployeeAction)->onlyOnDetail()
                ->canRun(
                    fn($request, $infoCard) =>
                    auth()->user()->hasPermissionTo("print-card")
                    && in_array($infoCard->orginization->id, UserDepartment::getUserDepartment())
                    && $infoCard->confirmed

                ),
            (new ConfirmEmployee)
                ->canRun(fn($request, $infoCard) => auth()->user()->hasPermissionTo("confirm-employee")
                    && in_array($infoCard->orginization->id, UserDepartment::getUserDepartment()))
        ];
    }

    public function job_fields(): array
    {
        return [
            Fields\BelongsTo::make(__("Department/Chancellor"), 'orginization', Department::class)
                ->relatableQueryUsing(function (NovaRequest $request, Builder $query) {
                    $query->whereIn('id', UserDepartment::getUserDepartment());
                })
                // ->searchable()
                ->filterable()
                ->sortable()
                ->withoutTrashed()
                ->showCreateRelationButton(),

            Fields\BelongsTo::make(__("Gate"), 'gate', Gate::class)
                ->dependsOn(
                    ['orginization'],
                    function (Fields\BelongsTo $field, NovaRequest $request, Fields\FormData $formData) {

                        $field->relatableQueryUsing(function (NovaRequest $request, Builder $query) use ($formData) {
                            $query->where('department_id', $formData->orginization);
                        });
                    }
                )
                ->showCreateRelationButton()
                ->withoutTrashed(),


            Fields\Text::make(__("Degree"), "degree")
                ->nullable()
                ->rules('nullable', 'string')

                ->placeholder(__("Enter Field", ['name' => __("Degree")])),
            Fields\Text::make(__("Grade"), "grade")
                ->nullable()
                ->rules('nullable', 'string')

                ->placeholder(__("Enter Field", ['name' => __("Grade")])),
            Fields\Text::make(__("Acupation"), "acupation")
                ->nullable()
                ->rules('nullable', 'string')

                ->placeholder(__("Enter Field", ['name' => __("Acupation")])),

            Fields\Text::make(__("Job Stracture Title"), "job_structure")
                ->nullable()
                ->rules('nullable', 'string')

                ->placeholder(__("Enter Field", ['name' => __("Job Stracture Title")])),
            Fields\Text::make(__("Previous Job"), "previous_job")
                ->nullable()
                ->rules('nullable', 'string')

                ->placeholder(__("Enter Field", ['name' => __("Previous Job")])),
            Fields\Text::make(__("Department/Chancellor"), "department")
                ->nullable()
                ->rules('nullable', 'string')
                ->placeholder(__("Enter Field", ['name' => __("Department/Chancellor")])),

            Fields\Tag::make(__("Condition"), 'employeeOptions', \Sq\Guest\Nova\GuestOption::class)
                ->showCreateRelationButton()
                ->displayAsList()
                ->exceptOnForms(),
        ];
    }
}
