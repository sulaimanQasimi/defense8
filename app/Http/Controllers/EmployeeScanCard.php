<?php

namespace App\Http\Controllers;

use App\Models\Card\CardInfo;
use App\Models\Card\MainCard;
use App\Models\Guest;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class EmployeeScanCard extends Controller
{
    public function scan(Request $request)
    {
        $guest = null;

        $code = $request->input("code");

        if (\Illuminate\Support\Str::startsWith($code, 'G-')) {
            $guest = Guest::query()->where('barcode', $code)->first();
        }

        $employee = CardInfo::query()->where('registare_no', "=", $code)->first();
        if ($employee) {
            // dd($employee->gateEnteredToday);
        }
        return view("employee.scan", compact("employee", "code", 'guest'));
    }
    public function scan_other_website_employee(Request $request)
    {
        $employee = null;

        $websites = Website::all();
        $website = $request->input("website");
        $code = $request->input("code");
        $message = null;
        if ($website) {
            $validator = Validator::make($request->all(), [
                'code' => 'required|string|max:255',
                'website' => 'required|exists:websites,id',
            ]);

            if ($validator->fails()) {
                return redirect()->back();
            }

            $data = $validator->Validated();
            $code = $data['code'];
            $website = $data['website'];
            $app = Website::find($website);
            try {

                $response = Http::withToken($app->token)->withUrlParameters([
                    'ip' => $app->ip,
                    'code'=>$code,
                ])->get("{ip}/api/employee/check?code={code}");
                if ($response->tooManyRequests()) {
                    $message = trans("Too many requests");
                }
                if ($response->unauthorized()) {
                    $message = trans("User Token Don't have API Token Role!");
                }
                if ($response->requestTimeout()) {
                    $message = trans("Server is not responding");
                }
                if ($response->notFound()) {
                    $message = trans("Employee Not Found");
                }
                if ($response->ok()) {
                    $employee = collect(json_decode($response->body(), JSON_UNESCAPED_UNICODE)['data']);
                }
            }
            catch(\Exception){
                $message= trans("Server is Offline");
            }
        }



        return view("employee.other-website", compact("websites", "employee", "message"));
    }

}
