<?php

use Sq\Query\DateFromAndToModelQuery;
use App\Http\Resources\DisterbutedOilResource;
use Sq\Oil\Models\OilDisterbution;
use Illuminate\Support\Facades\Route;
use Laravel\Nova\Http\Requests\NovaRequest;

/*
|--------------------------------------------------------------------------
| Tool Routes
|--------------------------------------------------------------------------
|
| Here is where you may register Inertia routes for your tool. These are
| loaded by the ServiceProvider of the tool. The routes are protected
| by your tool's "Authorize" middleware by default. Now - go build!
|
*/

Route::get('/', function (NovaRequest $request) {

    $createDisterbutedOilQuery = new DateFromAndToModelQuery(OilDisterbution::class, 'filled_date');

    return inertia('OilReport', [
        'disterbutes' => DisterbutedOilResource::collection($createDisterbutedOilQuery->query()->paginate(25)),
        'date'=>$request->input('date',verta()->format("Y/m/d"))
        ]);
});
