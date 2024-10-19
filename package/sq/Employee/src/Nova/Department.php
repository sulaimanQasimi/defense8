<?php

namespace Sq\Employee\Nova;

use App\Nova\Resource;
use App\Nova\User;
use App\Support\Defense\DepartmentTypeEnum;
use DigitalCreative\MegaFilter\MegaFilter;
use DigitalCreative\MegaFilter\MegaFilterTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Panel;
use MZiraki\PersianDateField\PersianDateTime;
use Sq\Employee\Nova\Gate as NovaGate;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sq\Query\Policy\UserDepartment;
use Sq\Query\SqNovaSelectFilter;
use Sq\Query\SqNovaTextFilter;

class Department extends Resource
{
    use MegaFilterTrait;
    public static $model = \Sq\Employee\Models\Department::class;
    public static $title = 'fa_name';
    public static $search = [
        'fa_name',
        'pa_name',
        'en_name',
    ];
    public static function label()
    {
        return __('Departments');
    }

    public static function singularLabel()
    {
        return __('Department');
    }
    public function subtitle()
    {
        return $this->department?->fa_name;
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        if (auth()->user()->hasRole('super-admin')) {
            return $query;
        }
        return $query->whereIn('id', UserDepartment::getUserDepartment());
    }

    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make(trans("Header Department"), 'department', Department::class)
                ->relatableQueryUsing(function (NovaRequest $request, Builder $query) {
                    $query->whereIn('id', UserDepartment::getUserDepartment());
                })
                ->nullable()
                ->filterable(),

            Text::make(trans("Name"), 'fa_name')
                ->required()
                ->creationRules('required', 'unique:departments,fa_name')
                ->updateRules('required', 'unique:departments,fa_name,{{resourceId}}'),

            Text::make(trans("Pashto Name"), 'pa_name')
                ->required()
                ->creationRules('required', 'unique:departments,pa_name')
                ->updateRules('required', 'unique:departments,pa_name,{{resourceId}}'),

            Text::make(trans("English Name"), 'en_name')
                ->required()
                ->creationRules('required', 'unique:departments,en_name')
                ->updateRules('required', 'unique:departments,en_name,{{resourceId}}'),

            Select::make(trans("Type"), 'type')
                ->options([
                    DepartmentTypeEnum::Independant => trans("Independant"),
                    DepartmentTypeEnum::Assistant => trans("Assistant"),
                    DepartmentTypeEnum::Directory => trans("Directory"),
                    DepartmentTypeEnum::HeaderShip => trans("HeaderShip"),
                    DepartmentTypeEnum::Commander => trans("Commander"),
                    DepartmentTypeEnum::Management => trans("Management"),
                    DepartmentTypeEnum::Directorate => trans("Directorate"),
                ])
                ->rules('required', 'in:Independant,Assistant,Directory,HeaderShip,Commander,Management,Directorate')->filterable()->displayUsingLabels(),
            Text::make(trans("Hosts"), fn() => $this->hosts->count())->onlyOnIndex(),
            Text::make(trans("Employees"), fn() => $this->card_infos->count())->onlyOnIndex(),
            Panel::make(trans("Attendance"), [

                // Attendance Start Hour
                Text::make(name: trans("Start"), attribute: "start")
                    ->rules('required')
                    ->textAlign("center")
                    ->placeholder("08:30-09:30")
                    ->help(trans("Only Morning Hours")),

                // Final Attendance Hour
                Text::make(name: trans("Exit"), attribute: "end")
                    ->rules('required')
                    ->textAlign('left')
                    ->placeholder("02:30-03:00")
                    ->help(trans("Only Afternoon Hours")),
            ]),
            HasMany::make(trans("Users"), 'user', User::class),
            HasMany::make(trans("Under Departments"), 'departments', Department::class),
            HasMany::make(trans("Gates"), 'gates', NovaGate::class),
            HasMany::make(trans("Employee"), 'card_infos', CardInfo::class),
            HasMany::make(trans("Hosts"), 'hosts', \Sq\Guest\Nova\Host::class),

        ];
    }
    public function cards(NovaRequest $request)
    {
        //
        return [];
    }
    public function filters(NovaRequest $request)
    {
        return [
            MegaFilter::make([
                // Department
                new SqNovaSelectFilter(
                    label: __("Header Department"),
                    column: 'department_id',
                    options: Department::pluck('fa_name', 'id')->toArray()
                ),
                new SqNovaTextFilter(label: trans("Name"), column: 'fa_name'),

                new SqNovaTextFilter(label: trans("Pashto Name"), column: 'pa_name'),

                new SqNovaTextFilter(label: trans("English Name"), column: 'en_name'),

                new SqNovaSelectFilter(
                    label: trans("Type"),
                    column: 'type',
                    options: [
                        DepartmentTypeEnum::Independant => trans("Independant"),
                        DepartmentTypeEnum::Assistant => trans("Assistant"),
                        DepartmentTypeEnum::Directory => trans("Directory"),
                        DepartmentTypeEnum::HeaderShip => trans("HeaderShip"),
                        DepartmentTypeEnum::Commander => trans("Commander"),
                        DepartmentTypeEnum::Management => trans("Management"),
                        DepartmentTypeEnum::Directorate => trans("Directorate"),
                    ]
                ),
            ])->columns(3),
        ];
    }

    /*
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }
    public function actions(NovaRequest $request)
    {
        return [
            Action::openInNewTab(
                __("In this Page you can set each employee attendance"),
                fn($department) => route('department.employee.attendance.check', ['department' => $department->id])
            )
                ->sole()
                ->canRun(fn($request, $department) => Gate::allows('admin', $department))
                ->withoutConfirmation()
                ->onlyOnDetail(),

            Action::openInNewTab(
                __("Download CURRENT MONTH ATTENDANCE EMPLOYEE"),
                fn($department) => route('sqemployee.employee.attendance.current.month.department.single', ['department' => $department->id])
            )
                ->sole()
                ->canRun(fn($request, $department) => Gate::allows('admin', $department))
                ->withoutConfirmation()
                ->onlyOnDetail(),

            Action::openInNewTab(
                __("Download Excel"),
                fn($department) => route('export.excel.attendance', ['department' => $department->id])
            )
                ->sole()
                ->canRun(fn($request, $department) => Gate::allows('admin', $department))
                ->withoutConfirmation()
                ->onlyOnDetail()
        ];
    }
}
