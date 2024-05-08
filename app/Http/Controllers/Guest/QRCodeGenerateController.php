<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Card\CardInfo;
use App\Models\Guest;
use App\Models\GuestGate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Laravel\Nova\Notifications\NovaNotification;

class QRCodeGenerateController extends Controller
{

    public function generate(Guest $guest)
    {
        $guest->host->user->notify(
            NovaNotification::make()->message(trans("QR code for guest Generated", ['name' => $guest->name]))->type("info")
        );

        return view(
            'guest.generateQR',
            ['url' => $guest->barcode, 'guest' => $guest, 'gate' => $guest->gate_translation]
        );
    }

    public function state(Request $request, Guest $guest)
    {
        // Get Current Gate
        $gate = auth()->user()->gate;
        // Get wheather  enter or Exit
        $state = $request->input('state');

        // Create or update passed Gate
        $passed = GuestGate::query()->firstOrCreate([
            'guest_id' => $guest->id,
            'gate_id' => $gate->id,
        ]);



        if ($state == 'enter') {
            $passed->entered_at = now();
            $passed->save();
            $guest->host->user->notify(
                NovaNotification::make()->message(trans("Guest Now Entered From Gate", ['name' => $guest->name, 'gate' => $gate->fa_name]))->type("info")
            );

        }
        if ($state == 'exit') {
            $passed->exit_at = now();
            $passed->save();
            $guest->host->user->notify(
                NovaNotification::make()->message(trans("Guest Now Exit From Gate", ['name' => $guest->name, 'gate' => $gate->fa_name]))->type("info")

            );

        }
        return redirect()->route("employee.check.card");
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
        return redirect()->route("employee.check.card");
    }

}
