<?php

namespace Sq\Employee\Http\Controllers;

use App\Http\Controllers\Controller;
use Sq\Employee\Models\Attendance;
use Sq\Employee\Models\CardInfo;
use Sq\Employee\Models\MainCard;
use Sq\Guest\Models\Guest;
use Sq\Employee\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class EmployeeScanCard extends Controller
{
    public function scan(Request $request)
    {
        //
        $guest = null;
        //
        $code = $request->input("code");
        //
        if (\Illuminate\Support\Str::startsWith($code, 'Guest-')) {
            $guest = Guest::query()->where('barcode', $code)->first();
        }
        //
        $employee = CardInfo::query()->where('registare_no', "=", $code)->first();
        //
        return view("sqemployee::employee.scan", compact("employee", "code", 'guest'));
    }



    public function employeeState(Request $request, CardInfo $cardInfo)
    {

        $this->authorize('gatePass', $cardInfo);

        // Get Current Gate
        $state = $request->input('state');

        //
        $gate = auth()->user()->gate;

        $this->authorize('gateChecker', $gate);


        // Get wheather  enter or Exit

        if ($gate->id === $cardInfo->gate?->id && !is_null($state)) {

            $today_attendance = Attendance::updateOrCreate(
                [
                    'gate_id' => $gate->id,
                    'card_info_id' => $cardInfo->id,
                    'date' => now()->format('Y-m-d'),
                ]
            );


            // If employee Not absent and the state is enter
            if ($today_attendance->state != "U" && $state == 'enter') {

                // Fill the date to NOW
                $today_attendance->enter = now();

                // State changed to P - Present
                $today_attendance->state = "P";

                // else If employee Present and the state is enter and not absent then fill exit to now
            } elseif ($today_attendance->enter && $today_attendance->state != "U" && $state == 'exit') {

                // Update Attendance Datetime to NOW
                $today_attendance->exit = now();

            } elseif ($today_attendance->state != "P" && $state == 'upsent') {

                // State changed to U - Absent
                $today_attendance->state = "U";
            }

            $today_attendance->save();

        } else {
            return abort(403);
        }
        return redirect()->route("sqemployee.employee.check.card");
    }

    public function scan_other_website_employee(Request $request)
    {
        $employee = null;

        $websites = Website::all();

        $website = $request->input("website");

        $code = $request->input("code");

        $message = null;

        if ($website) {
            // Define Validate Rules
            $validator = Validator::make($request->all(), [
                'code' => 'required|string|max:255',
                'website' => 'required|exists:websites,id',
            ]);

            // If Failed redireect Back
            if ($validator->fails()) {
                return redirect()->back();
            }

            // Validate the input request
            $data = $validator->Validated();
            // Get Code From URL
            $code = $data['code'];
            // Get Website
            $website = $data['website'];
            // Find Website
            $app = Website::find($website);

            try {

                $response = Http::withToken($app->token)->withUrlParameters([
                    'ip' => $app->ip,
                    'code' => $code,
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
            } catch (\Exception) {
                $message = trans("Server is Offline");
            }
        }
        return view("sqemployee::employee.other-website", compact("websites", "employee", "message"));
    }

}
