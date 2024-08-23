<?php

use Sq\Employee\Models\CardInfo;
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

    $department = request()->input('department', '');
    $employee = [];
    if ($request->input('department', '') != '') {
        $employee = CardInfo::where('department_id', $request->input('department'))->get();
    }
    return inertia('OilReport', [
        'disterbutes' => DisterbutedOilResource::collection($createDisterbutedOilQuery->query()
        ->orderByDesc('filled_date')
            ->when(
                $department,
                function ($query) use ($department) {
                    return $query->whereHas('card_info', function ($query) use ($department) {
                        return $query->where("department_id", $department);
                    });
                }
            )
            ->when($request->input('employee'), function ($query) use ($department) {
                return $query->where('card_info_id', request()->input('employee'));
            })
            ->paginate(25)),
        'request' => request()->all(),
        'date' => $request->input('date', verta()->format("Y/m/d")),
        'selectedDepartment' => $request->input('department', ''),
        'selectedEmployee' => $request->input('employee', ''),
        'employees' => $employee
    ]);
});
