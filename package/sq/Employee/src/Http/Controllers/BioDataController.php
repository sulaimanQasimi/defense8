<?php

namespace Sq\Employee\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sq\Employee\Models\BioData;
use Sq\Employee\Models\CardInfo;
use App\Services\Fingerprint\Fingerprint;

class BioDataController extends Controller
{
    /**
     * Display the biometric capture interface for an employee.
     *
     * @param int $employee_id
     * @return \Illuminate\View\View
     */
    public function show($employee_id)
    {
        $employee = CardInfo::findOrFail($employee_id);
        $bioData = $employee->bioData;

        return view('sqemployee::employee.bio_data', [
            'employee' => $employee,
            'bioData' => $bioData,
        ]);
    }

    /**
     * Store the captured biometric data for an employee.
     *
     * @param Request $request
     * @param int $employee_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $employee_id)
    {
        $employee = CardInfo::findOrFail($employee_id);

        // Create or update the biometric data
        $bioData = BioData::updateOrCreate(
            ['personal_info_id' => $employee_id],
            [
                'Manufacturer' => $request->input('Manufacturer'),
                'Model' => $request->input('Model'),
                'SerialNumber' => $request->input('SerialNumber'),
                'ImageWidth' => $request->input('ImageWidth'),
                'ImageHeight' => $request->input('ImageHeight'),
                'ImageDPI' => $request->input('ImageDPI'),
                'ImageQuality' => $request->input('ImageQuality'),
                'NFIQ' => $request->input('NFIQ'),
                'ImageDataBase64' => $request->input('ImageDataBase64'),
                'BMPBase64' => $request->input('BMPBase64'),
                'ISOTemplateBase64' => $request->input('ISOTemplateBase64'),
                'TemplateBase64' => $request->input('TemplateBase64'),
            ]
        );

        return redirect()->back()->with('success', 'Biometric data saved successfully');
    }

    /**
     * Delete the biometric data for an employee.
     *
     * @param int $employee_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($employee_id)
    {
        $bioData = BioData::where('personal_info_id', $employee_id)->first();

        if ($bioData) {
            $bioData->delete();
            return redirect()->back()->with('success', 'Biometric data deleted successfully');
        }

        return redirect()->back()->with('error', 'No biometric data found');
    }

    /**
     * Verify a fingerprint against the stored template for an employee.
     *
     * @param Request $request
     * @param int $employee_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request, $employee_id)
    {
        $employee = CardInfo::findOrFail($employee_id);
        $bioData = $employee->bioData;

        if (!$bioData) {
            return response()->json(['match' => false, 'message' => 'No biometric data stored for this employee']);
        }

        $isoTemplate = $request->input('ISOTemplateBase64');

        // Create a temporary directory for the sample
        $samplesDir = storage_path('app/fingerprints/temp/' . uniqid());
        if (!file_exists($samplesDir)) {
            mkdir($samplesDir, 0755, true);
        }

        // Save the stored template as a file
        $storedTemplatePath = $samplesDir . '/stored.dat';
        file_put_contents($storedTemplatePath, base64_decode($bioData->ISOTemplateBase64));

        // Use the Fingerprint service to match
        try {
            $matchResult = Fingerprint::match($samplesDir, $isoTemplate);

            // Clean up temporary files
            @unlink($storedTemplatePath);
            @rmdir($samplesDir);

            if ($matchResult) {
                return response()->json(['match' => true, 'message' => 'Fingerprint matched']);
            } else {
                return response()->json(['match' => false, 'message' => 'Fingerprint did not match']);
            }
        } catch (\Exception $e) {
            // Clean up on error
            @unlink($storedTemplatePath);
            @rmdir($samplesDir);

            return response()->json([
                'match' => false,
                'message' => 'Error during verification: ' . $e->getMessage()
            ], 500);
        }
    }
}
