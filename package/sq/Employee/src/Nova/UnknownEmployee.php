<?php

namespace Sq\Employee\Nova;

use App\Nova\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Laravel\Nova\Fields;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sq\Query\Policy\UserDepartment;

class UnknownEmployee extends CardInfo
{
    /**
     * The click action to use when clicking on the resource in the table.
     *
     * Can be one of: 'detail' (default), 'edit', 'select', 'preview', or 'ignore'.
     *
     * @var string
     */
    public static $clickAction = 'edit';
    /**
     * Summary of label
     * @return array|string|null
     */
    public static function label()
    {
        return __('Unknown Employee');
    }
    /**
     * Summary of singularLabel
     * @return array|string|null
     */
    public static function singularLabel()
    {
        return __('Unknown Employee');
    }
    /**
     * Summary of indexQuery
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @param mixed $query
     * @return Builder
     */
    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->whereNull('department_id');
    }
    /**
     * Summary of fieldsForUpdate
     * @param \Laravel\Nova\Http\Requests\NovaRequest $request
     * @return array
     */
    public function fieldsForUpdate(NovaRequest $request)
    {
        return [
            Fields\BelongsTo::make(__("Department/Chancellor"), 'orginization', Department::class)
                ->relatableQueryUsing(function (NovaRequest $request, Builder $query) {
                    $query->whereIn('id', UserDepartment::getUserDepartment());
                })
                ->searchable()
                ->filterable()
                ->sortable()
                ->withoutTrashed()
                ->showCreateRelationButton()
                ->withSubtitles(),

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
                ->withoutTrashed()
                ->withSubtitles(),
        ];
    }

    public static function redirectAfterUpdate(NovaRequest $request, $resource)
    {
        return '/resources/card-infos/' . $resource->getKey();
    }
}
