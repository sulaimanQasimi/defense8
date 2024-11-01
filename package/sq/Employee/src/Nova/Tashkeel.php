<?php

namespace Sq\Employee\Nova;

use App\Nova\Resource;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;
use Sq\Query\Support\BastTypeEnum;
use Sq\Query\Support\GenderEnum;
use Sq\Query\Support\TashkeelLocationEnum;
use Sq\Query\Support\TashkeelStatus;
use Sq\Query\Support\TashkeelType;

class Tashkeel extends Resource
{
    public static $model = \Sq\Employee\Models\Tashkeel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
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
            ID::make()->sortable(),

            Text::make('tashkeel_code')->nullable(),

         BelongsTo::make(trans("Bast Title"),'bast_title',BastTitle::class)->nullable()->showCreateRelationButton()->searchable(),
         BelongsTo::make(trans("Bast Grade"),'bast_grade',BastGrade::class)->nullable()->showCreateRelationButton()->searchable(),
         BelongsTo::make(trans("Department"),'department',Department::class)->nullable()->showCreateRelationButton()->searchable(),

            Number::make('radif')->nullable(),

            Text::make('section')->nullable(),

            Select::make('creation_type')
                ->options(BastTypeEnum::withLabelInArray())
                ->default(BastTypeEnum::Bast->name)
                ->required()
                ->rules("required", Rule::in(BastTypeEnum::InArray())),

            Number::make('ths_class_count')
                ->nullable(),

            Number::make('number_tashkeelat')
                ->nullable(),

            Number::make('year')->nullable(),

            // $table->date('date')->nullable(),

            Text::make('change_year')
                ->nullable()
            ,
            Text::make('rob')
                ->nullable(),

            Select::make('tashkeel_location')
                ->options(TashkeelLocationEnum::withLabelInArray())
                ->default(TashkeelLocationEnum::Internal->name)
                ->required()
                ->rules("required", Rule::in(TashkeelLocationEnum::InArray())),

            Select::make('type')
                ->options(TashkeelType::withLabelInArray())
                ->default(TashkeelType::Civilian->name)
                ->required()
                ->rules("required", Rule::in(TashkeelType::InArray())),

            Select::make('status')
                ->options(TashkeelStatus::withLabelInArray())
                ->default(TashkeelStatus::Created->name)
                ->required()
                ->rules("required", Rule::in(TashkeelStatus::InArray()))

            ,
            Boolean::make('is_filled')
                ->default(false)
            ,
            Boolean::make('is_active')
                ->default(true)
            ,
            Text::make('code_mulki')->nullable(),

            Select::make('gender')
                ->options(GenderEnum::withLabelInArray())
                ->default(GenderEnum::Male->name)
                ->nullable()
                ->rules("required", Rule::in(GenderEnum::InArray())),

            Text::make('file_name')->nullable(),
            Text::make('file_path')->nullable(),


            // $table->foreignId('created_by')->nullable(),
            // $table->foreignId('updated_by')->nullable(),
            // $table->foreignId('deleted_by')->nullable(),
            // $table->foreignId('published_by')->nullable(),

            // $table->date('published_at')
            //     ->nullable()
            //  ,
            // $table->foreignId('approved_by')
            //     ->nullable(),

            // $table->date('approved_at')
            //     ->nullable()
            //  ,
            // $table->boolean('ready_to_published_by')
            //     ->default(false),

            // $table->date('ready_to_published_at')
            //     ->nullable()
            //  ,
            Text::make('action'),

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
