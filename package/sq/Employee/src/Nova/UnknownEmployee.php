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

    public static function label()
    {
        return __('Unknown Employees');
    }

    public static function singularLabel()
    {
        return __('Unknown Employee');
    }

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->whereNull('department_id');
    }
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
}
