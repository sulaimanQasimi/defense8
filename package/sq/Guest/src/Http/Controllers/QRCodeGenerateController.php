<?php

namespace Sq\Guest\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Nova\Notifications\NovaNotification;
use Sq\Employee\Models\Attendance;
use Sq\Employee\Models\CardInfo;
use Sq\Guest\Models\Guest;
use Sq\Guest\Models\GuestGate;

class QRCodeGenerateController extends Controller
{

    public function generate(Guest $guest)
    {
        $guest->host->user->notify(
            NovaNotification::make()->message(trans("QR code for guest Generated", ['name' => $guest->name]))->type("info")
        );

        return view(
            'sqguest::guest.generateQR',
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
        return redirect()->route("sqemployee.employee.check.card");
    }
}
