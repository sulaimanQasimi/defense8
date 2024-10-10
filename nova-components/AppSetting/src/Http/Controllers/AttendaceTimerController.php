<?php
namespace Acme\AppSetting\Http\Controllers;
use App\Settings\AttendanceTimer;
use Illuminate\Http\Request;
class AttendaceTimerController
{

    public function get(): array
    {
        return [
            'start' => (new AttendanceTimer)->start,
            'end' => (new AttendanceTimer)->end,
        ];
    }
    public function post(Request $request)
    {
        dump($request->all());
        $app = new AttendanceTimer();
        $app->start = $request->input('start', '');
        $app->end = $request->input('end', '');
        $app->save();
    }
}
