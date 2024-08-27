<?php
namespace App\Nova;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Sereny\NovaPermissions\Nova\Resource;
use Spatie\Permission\Models\Permission as PermissionModel;

class Permission extends Resource
{

    /**
     * The list of field name that should be hidden
     *
     * @var string[]
     */
    public static $hiddenFields = [];

    /**
     * Indicates if the resource should be globally searchable.
     *
     * @var bool
     */
    public static $globallySearchable = false;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = PermissionModel::class;

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
        'fa_name',
        'pa_name'
    ];

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'fa_name';

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function fields(Request $request)
    {
        $guardOptions = $this->guardOptions($request);
        $userResource = $this->userResource();

        return [

            Text::make(__('Name'), 'name')
                ->sortable()
                ->exceptOnForms()
                ->hideFromIndex()
                ->hide(),

            Text::make(__('Persion Name'), 'fa_name')
                ->rules(['required', 'string', 'max:255'])
                ->sortable(),
            Text::make(__('Pashto Name'), 'pa_name')
                ->rules(['required', 'string', 'max:255']),

            Text::make(__('Group'), 'group')
                ->sortable()
                ->exceptOnForms()
                ->rules(['required', 'string', 'max:255']),

            Select::make(__('Guard Name'), 'guard_name')
                ->exceptOnForms()
                ->options($guardOptions->toArray())
                ->rules(['required', Rule::in($guardOptions)])
                ->default($this->defaultGuard($guardOptions))
                ->canSee(function ($request) {
                    return $this->fieldAvailable('guard_name');
                })
                ->onlyOnForms(),

            BelongsToMany::make(__('Roles'), 'roles', Role::class)
                ->canSee(function ($request) {
                    return $this->fieldAvailable('roles');
                }),

            MorphToMany::make($userResource::label(), 'users', $userResource)
                ->searchable()
                ->canSee(function ($request) {
                    return $this->fieldAvailable('users');
                }),
        ];
    }

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Permissions');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Permission');
    }

}
