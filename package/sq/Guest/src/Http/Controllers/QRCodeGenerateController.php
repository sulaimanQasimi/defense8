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
use Sq\Guest\Models\PatientGatePass;

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
        // Get Current Gate
        if (!auth()->user()->gate) {
            return redirect()->back()
                ->with('error', trans('You need to be assigned to a gate to deactivate a patient'));
        }

        $gate = auth()->user()->gate;

        // Check if patient already has a gate_id and it's different from the current user's gate
        if ($patient->gate_id && $patient->gate_id != $gate->id) {
            return redirect()->back()
                ->with('error', trans('This patient is assigned to a different gate'));
        }

        // Update patient status
        $patient->update([
            'status' => 'inactive',
            'gate_id' => $gate->id
        ]);

        // Create a new PatientGatePass record
        PatientGatePass::create([
            'patient_id' => $patient->id,
            'gate_id' => $gate->id,
            'entered_at' => now(),
        ]);

        // Notify the host
        $patient->host->user->notify(
            NovaNotification::make()
                ->message(trans("Patient status has been deactivated", ['name' => $patient->name]))
                ->type("warning")
        );

        return redirect()->back()
            ->with('success', trans('Patient has been deactivated successfully'));
    }

    public function exitPatient(Patient $patient)
    {
        // Get Current Gate
        if (!auth()->user()->gate) {
            return redirect()->back()
                ->with('error', trans('You need to be assigned to a gate to mark patient exit'));
        }

        $gate = auth()->user()->gate;

        // Check if the patient's gate_id matches the current user's gate_id
        if ($patient->gate_id != $gate->id) {
            return redirect()->back()
                ->with('error', trans('You can only mark exit for patients assigned to your gate'));
        }

        // Find the latest gate pass record without an exit time
        $gatePass = PatientGatePass::where('patient_id', $patient->id)
            ->where('gate_id', $gate->id)
            ->whereNotNull('entered_at')
            ->whereNull('exit_at')
            ->latest()
            ->first();

        if ($gatePass) {
            // Update exit time
            $gatePass->update([
                'exit_at' => now(),
            ]);

            // Notify the host
            $patient->host->user->notify(
                NovaNotification::make()
                    ->message(trans("Patient has exited the gate", ['name' => $patient->name, 'gate' => $gate->fa_name]))
                    ->type("info")
            );

            return redirect()->back()
                ->with('success', trans('Patient exit has been recorded successfully'));
        }

        return redirect()->back()
            ->with('error', trans('No active gate pass found for this patient at this gate'));
    }
}
