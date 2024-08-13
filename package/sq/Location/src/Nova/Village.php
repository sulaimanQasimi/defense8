<?php
namespace Sq\Location\Nova;

use App\Nova\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sq\Employee\Nova\CardInfo;

class Village extends Resource
{
    public static $model = \Sq\Location\Models\Village::class;
    public static $title = 'name';
    public static $search = [
        'name'
    ];

    public static function label()
    {
        return __('Villages');
    }

    public static function singularLabel()
    {
        return __('Village');
    }
    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make(trans("Province"), 'province', Province::class)->searchable(),

            BelongsTo::make(trans("District"), 'district', District::class)
                ->dependsOn(
                    ['province'],
                    function (BelongsTo $field, NovaRequest $request, FormData $formData) {
                        $field->relatableQueryUsing(function (NovaRequest $request, Builder $query) use ($formData) {
                            $query->where('province_id', $formData->province);
                        });
                    }
                ),
            Text::make(trans("Name"), 'name')
                ->required()
                ->creationRules('required', 'string', Rule::unique('villages')
                    ->where(function ($query) use ($request) {
                        return $query->where('district_id', $request->district)->where('deleted_at', null);
                    }))
                ->updateRules(
                    'required',
                    Rule::unique('districts')
                        ->where(function ($query) use ($request) {
                            return $query->where('district_id', $request->district)->where('deleted_at', null);
                        })->ignore($this->id),

                ),
                HasMany::make(trans("Main Address"), 'main_employee_address', CardInfo::class),
                HasMany::make(trans("Current Address"), 'current_employee_address', CardInfo::class),

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
        return [];
    }
}
