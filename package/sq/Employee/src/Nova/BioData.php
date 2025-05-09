<?php

namespace Sq\Employee\Nova;

use App\Nova\Resource;
use Laravel\Nova\Fields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sq\Employee\Models\BioData as BioDataModel;

class BioData extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = BioDataModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * Get the displayable label of the resource.
     *
     * @return string
     */
    public static function label()
    {
        return __('Biometric Data');
    }

    /**
     * Get the displayable singular label of the resource.
     *
     * @return string
     */
    public static function singularLabel()
    {
        return __('Biometric Data');
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'SerialNumber',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Fields\ID::make()->sortable(),

            Fields\BelongsTo::make(__('Employee'), 'cardInfo', CardInfo::class)
                ->searchable()
                ->withoutTrashed(),

            Fields\Text::make(__('Manufacturer'), 'Manufacturer')
                ->sortable(),

            Fields\Text::make(__('Model'), 'Model')
                ->sortable(),

            Fields\Text::make(__('Serial Number'), 'SerialNumber')
                ->sortable(),

            Fields\Text::make(__('Image Width'), 'ImageWidth')
                ->hideFromIndex(),

            Fields\Text::make(__('Image Height'), 'ImageHeight')
                ->hideFromIndex(),

            Fields\Text::make(__('Image DPI'), 'ImageDPI')
                ->hideFromIndex(),

            Fields\Text::make(__('Image Quality'), 'ImageQuality')
                ->sortable(),

            Fields\Text::make(__('NFIQ'), 'NFIQ')
                ->hideFromIndex(),

            Fields\Image::make(__('Fingerprint Image'), function () {
                if ($this->BMPBase64) {
                    return 'data:image/bmp;base64,' . $this->BMPBase64;
                }
                return null;
            })
                ->hideFromIndex(),

            Fields\Textarea::make(__('Template Base64'), 'TemplateBase64')
                ->hideFromIndex()
                ->hideFromDetail(),

            Fields\Textarea::make(__('ISO Template Base64'), 'ISOTemplateBase64')
                ->hideFromIndex()
                ->hideFromDetail(),

            Fields\Textarea::make(__('BMP Base64'), 'BMPBase64')
                ->hideFromIndex()
                ->hideFromDetail(),

            Fields\DateTime::make(__('Created At'), 'created_at')
                ->sortable()
                ->hideFromIndex(),

            Fields\DateTime::make(__('Updated At'), 'updated_at')
                ->sortable()
                ->hideFromIndex(),
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
        return [
            \Laravel\Nova\Actions\Action::openInNewTab(
                __("Capture Fingerprint"),
                fn($bioData) => route('employee.biodata.show', ['employee_id' => $bioData->personal_info_id])
            )
                ->canRun(fn($request, $bioData) => auth()->user()->hasPermissionTo('update', '\Sq\Employee\Models\CardInfo'))
                ->withoutConfirmation()
                ->onlyOnDetail(),
        ];
    }
}
