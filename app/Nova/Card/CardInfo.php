<?php

namespace App\Nova\Card;
use App\Nova\Actions\EditCardInfoOption;
use App\Nova\Actions\EditCardInfoRemark;
use App\Nova\Actions\ExportCardInfo;
use App\Nova\Attendance;
use App\Nova\Department;
use App\Nova\Gate;
use App\Nova\GuestOption;
use App\Nova\Resource;
use App\Support\Defense\EditAditionalCardInfoEnum;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\BelongsTo;
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

                BelongsTo::make(__("Gate"), 'gate', Gate::class),
                BelongsTo::make(__("Department/Chancellor"), 'orginization', Department::class)
                    ->filterable()
                    ->sortable()
                    // ->searchable()
                    ,

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

                Text::make(__("Village"), "m_village")
                    ->nullable()
                    ->rules('nullable', 'string')

                    ->placeholder(__("Enter Field", ['name' => __("Village")])),

                Text::make(__("District"), "m_district")
                    ->nullable()
                    ->rules('nullable', 'string')

                    ->placeholder(__("Enter Field", ['name' => __("District")])),
                Text::make(__("Province"), "m_province")
                    ->nullable()
                    ->rules('nullable', 'string')

                    ->placeholder(__("Enter Field", ['name' => __("Province")])),

            ])->limit(0),

            Panel::make(__("Current Address"), [

                Text::make(__("Village"), "c_village")
                    ->nullable()
                    ->rules('nullable', 'string')

                    ->placeholder(__("Enter Field", ['name' => __("Village")])),
                Text::make(__("District"), "c_district")
                    ->nullable()
                    ->rules('nullable', 'string')

                    ->placeholder(__("Enter Field", ['name' => __("District")])),
                Text::make(__("Province"), "c_province")
                    ->nullable()
                    ->rules('nullable', 'string')

                    ->placeholder(__("Enter Field", ['name' => __("Province")])),
            ]),

            Trix::make(__("Remark"), 'remark')->exceptOnForms(),
            HasOne::make(__("Main Card"), 'main_card', MainCard::class),
            HasOne::make(__("Gun Card"), 'gun_card', GunCard::class),
            HasMany::make(__("Armor Vehical Card"), 'armor_vehical_card', ArmorVehicalCard::class),
            HasMany::make(__("Black Mirror Vehical Card"), 'black_mirror_vehical_card', BlackMirrorVehicalCard::class),
            HasMany::make(__("Employee Vehical Card"), 'employee_vehical_card', EmployeeVehicalCard::class),
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
        return [

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
            Action::openInNewTab(__("Download CURRENT MONTH ATTENDANCE EMPLOYEE"), fn($employee) => route('employee.attendance.current.month.single',['cardInfo'=>$employee->id]))
                ->sole()
                // ->canRun(fn($request, $course) => auth()->id() === $course->section->department?->user_id)
                ->withoutConfirmation()
                ->onlyOnDetail()
        ];
    }
}
