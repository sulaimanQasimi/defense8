<?php

namespace Sq\Guest\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Nova\Notifications\NovaNotification;
use Sq\Guest\Models\Guest;
use Sq\Guest\Models\GuestGate;
use Sq\Query\Policy\UserDepartment;
use Sq\Guest\Models\Patient;
use App\Support\Defense\PermissionTranslation;
use Sq\Notification\NovaNotification as SqNotificationNovaNotification;

class QRCodeGenerateController extends Controller
{

    public function generate(Guest $guest)
    {
        // dd($guest?->host?->user_id == auth()->user()->id);
        if (in_array($guest->host->department_id, UserDepartment::getUserDepartment())) {

            return view(
                'sqguest::guest.generateQR',
                ['url' => $guest->barcode, 'guest' => $guest, 'gate' => $guest->gate_translation]
            );
        }
        if (in_array($guest->gate_id, UserDepartment::getUserGuestGate())) {

            return view(
                'sqguest::guest.generateQR',
                ['url' => $guest->barcode, 'guest' => $guest, 'gate' => $guest->gate_translation]
            );
        }
        if ($guest->gate_id == auth()->user()->gate_id) {

            return view(
                'sqguest::guest.generateQR',
                ['url' => $guest->barcode, 'guest' => $guest, 'gate' => $guest->gate_translation]
            );
        }
        if ($guest?->host?->user_id == auth()->user()->id) {
            return view(
                'sqguest::guest.generateQR',
                ['url' => $guest->barcode, 'guest' => $guest, 'gate' => $guest->gate_translation]
            );
        }

        $guest->host->user->notify(
            NovaNotification::make()->message(trans("QR code for guest Generated", ['name' => $guest->name]))->type("info")
        );
        return abort(403);
    }

    public function state(Request $request, Guest $guest)
    {
        if (!in_array($guest->host->department_id, UserDepartment::getUserDepartment())) {
            return view('sqguest::missuse');
        }


        // Get Current Gate
        $gate = auth()->user()->gate;

        // Get wheather  enter or Exit
        $state = $request->input('state');

        // Create or update passed Gate
        $passed = GuestGate::query()
            ->firstOrCreate([
                'guest_id' => $guest->id,
                'gate_id' => $gate->id,
            ]);


        // Enter the Gate
        if ($state == 'enter') {
            $passed->entered_at = now();
            $passed->save();
            $guest->host->user->notify(
                NovaNotification::make()->message(trans("Guest Now Entered From Gate", ['name' => $guest->name, 'gate' => $gate->fa_name]))->type("info")
            );
        }


        // Exit the Gate
        if ($state == 'exit') {
            $passed->exit_at = now();
            $passed->save();
            $guest->host->user->notify(
                NovaNotification::make()->message(trans("Guest Now Exit From Gate", ['name' => $guest->name, 'gate' => $gate->fa_name]))->type("info")
            );
        }


        return redirect()->route("sqemployee.employee.check.card");
    }

    public function generatePatient(Patient $patient)
    {
        if (in_array($patient->host->department_id, UserDepartment::getUserDepartment())) {
            return view(
                'sqguest::guest.patient-thermal',
                ['url' => $patient->barcode, 'patient' => $patient]
            );
        }

        if (in_array($patient->gate_id, UserDepartment::getUserGuestGate())) {
            return view(
                'sqguest::guest.patient-thermal',
                ['url' => $patient->barcode, 'patient' => $patient]
            );
        }

        if ($patient->gate_id != auth()->user()->gate_id) {
            return view(
                'sqguest::guest.patient-thermal',
                ['url' => $patient->barcode, 'patient' => $patient]
            );
        }

        if ($patient?->host?->user_id != auth()->user()->id) {
            return view(
                'sqguest::guest.patient-thermal',
                ['url' => $patient->barcode, 'patient' => $patient]
            );
        }

        $patient->host->user->notify(
            NovaNotification::make()->message(trans("QR code for patient Generated", ['name' => $patient->name]))->type("info")
        );
        return abort(403);
    }

    public function deactivate(Patient $patient)
    {
        // Check permissions
        if (!in_array($patient->host->department_id, UserDepartment::getUserDepartment()) &&
            !in_array($patient->gate_id, UserDepartment::getUserGuestGate()) &&
            $patient->gate_id != auth()->user()->gate_id &&
            $patient?->host?->user_id != auth()->user()->id) {
            return abort(403);
        }

        // Update patient status
        $patient->update([
            'status' => 'inactive'
        ]);

        // Notify the host
        $patient->host->user->notify(
            NovaNotification::make()
                ->message(trans("Patient status has been deactivated", ['name' => $patient->name]))
                ->type("warning")
        );

        return redirect()->route('guest.patients.index')
            ->with('success', trans('Patient has been deactivated successfully'));
    }
}
