<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CardInfoResource;
use App\Models\Card\CardInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckEmployeeInfo extends Controller
{

    public function check(Request $request)
    {

        if(!auth()->user()->hasRole("api-token")){
            return response()->json(['error' => 'User Don\'t have api token Role!'], 401);
        }
        $data = Validator::make($request->all(), [
            'code' => 'required|string|max:255'
        ]);

        if ($data->fails()) {
            return response()->json(['error' => 'code is required'], 422);
        }

        $code = $data->Validated()['code'];

        $employee = CardInfo::query()
            ->where('registare_no', "=", $code)
            ->first();
        if ($employee) {
            return CardInfoResource::make($employee);
        }
        return response()->json(['error' => 'employee not found'], 404);
    }
}
