<?php

namespace App\Nova\Card;

use App\Nova\Actions\EditCardInfoOption;
use App\Nova\Actions\EditCardInfoRemark;
use App\Nova\Actions\ExportCardInfo;
use App\Nova\Actions\PrintAllTypeCardEmployeeAction;
use App\Nova\Attendance;
use App\Nova\Career;
use App\Nova\Department;
use App\Nova\District;
use App\Nova\Gate;
use App\Nova\GuestOption;
use App\Nova\Province;
use App\Nova\Resource;
use App\Nova\Village;
use App\Support\Defense\EditAditionalCardInfoEnum;
use Coroowicaksono\ChartJsIntegration\LineChart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Tag;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Panel;
use MZiraki\PersianDateField\PersianDate;

class CardInfo extends Resource
{

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
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query;
    }



    public static function label()
    {
        return __('Card Info');
    }

    public static function singularLabel()
    {
        return __('Card Info');
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

                BelongsTo::make(__("Province"), "main_province", Province::class)
                    ->nullable()
                    ->searchable()
                    ->showCreateRelationButton(),

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
            HasOne::make(__("Armor Vehical Card"), 'armor_vehical_card', ArmorVehicalCard::class),
            HasOne::make(__("Black Mirror Vehical Card"), 'black_mirror_vehical_card', BlackMirrorVehicalCard::class),
            HasOne::make(__("Employee Vehical Card"), 'employee_vehical_card', EmployeeVehicalCard::class),
            HasMany::make(__("Attendance"), 'attendance', Attendance::class),
            // MorphToMany::make(__("Print Card"), 'PrintCardFrame', \App\Nova\PrintCardFrame::class),



        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
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

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
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
            (new PrintAllTypeCardEmployeeAction)->onlyOnDetail()->canRun(fn() => auth()->user()->hasRole("Print Card"))

        ];
    }
}
