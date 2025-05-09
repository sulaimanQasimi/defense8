<?php

namespace Sq\Fingerprint\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Sq\Fingerprint\Models\BiometricData;
use Sq\Fingerprint\Services\FingerprintService;

class BioDataController extends Controller
{
    /**
     * The fingerprint service.
     *
     * @var \Sq\Fingerprint\Services\FingerprintService
     */
    protected $fingerprintService;

    /**
     * Create a new controller instance.
     *
     * @param  \Sq\Fingerprint\Services\FingerprintService  $fingerprintService
     * @return void
     */
    public function __construct(FingerprintService $fingerprintService)
    {
        $this->fingerprintService = $fingerprintService;
    }

    /**
     * Display the biometric data for a record.
     *
     * @param  int  $record_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($record_id)
    {
        try {
            $bioData = BiometricData::where('record_id', $record_id)->first();

            if (!$bioData) {
                return response()->json([
                    'success' => false,
                    'message' => 'No biometric data found for this record',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $bioData
            ]);
        } catch (Exception $e) {
            Log::error("Error retrieving biometric data: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving biometric data',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Store biometric data for a record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $record_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $record_id)
    {
        try {
            // Validate the request
            $request->validate([
                'Manufacturer' => 'nullable|string',
                'Model' => 'nullable|string',
                'SerialNumber' => 'nullable|string',
                'ImageWidth' => 'nullable|integer',
                'ImageHeight' => 'nullable|integer',
                'ImageDPI' => 'nullable|integer',
                'ImageQuality' => 'nullable|integer',
                'NFIQ' => 'nullable|integer',
                'ImageDataBase64' => 'nullable|string',
                'BMPBase64' => 'nullable|string',
                'ISOTemplateBase64' => 'nullable|string',
                'TemplateBase64' => 'nullable|string',
            ]);

            // Check if at least one template is provided
            if (!$request->has('ISOTemplateBase64') && !$request->has('TemplateBase64')) {
                return response()->json([
                    'success' => false,
                    'message' => 'At least one template format is required',
                ], 400);
            }

            // Create or update the biometric data
            $data = $request->all();
            $data['record_id'] = $record_id;
            
            // Use the FingerprintService to store data
            $success = $this->fingerprintService->store($data, $record_id);

            if (!$success) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to store biometric data',
                ], 500);
            }

            // Get the updated record
            $bioData = BiometricData::where('record_id', $record_id)->first();

            return response()->json([
                'success' => true,
                'message' => 'Biometric data stored successfully',
                'data' => $bioData
            ]);
        } catch (Exception $e) {
            Log::error("Error storing biometric data: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while storing biometric data',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Delete biometric data for a record.
     *
     * @param  int  $record_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($record_id)
    {
        try {
            // Use the FingerprintService to delete data
            $success = $this->fingerprintService->delete($record_id);

            if (!$success) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete biometric data',
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Biometric data deleted successfully',
            ]);
        } catch (Exception $e) {
            Log::error("Error deleting biometric data: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting biometric data',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Verify a fingerprint against the stored template for a record.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $record_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request, $record_id)
    {
        try {
            // Validate the request
            $request->validate([
                'ISOTemplateBase64' => 'nullable|string',
                'TemplateBase64' => 'nullable|string',
                'BMPBase64' => 'nullable|string',
            ]);

            // Check if at least one template is provided
            if (!$request->has('ISOTemplateBase64') && !$request->has('TemplateBase64') && !$request->has('BMPBase64')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No fingerprint template provided',
                ], 400);
            }

            // Get the debug mode
            $debug = $request->has('debug') ? (bool) $request->input('debug') : false;
            
            // Match the fingerprint against the specific record
            $result = $this->fingerprintService->match(
                $request->only(['ISOTemplateBase64', 'TemplateBase64', 'BMPBase64']), 
                [$record_id], 
                $debug
            );

            if ($result === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to verify fingerprint',
                ], 500);
            }

            // Return the verification result
            return response()->json([
                'success' => true,
                'match' => $result['matched'],
                'message' => $result['matched'] ? 'Fingerprint verified successfully' : 'Fingerprint did not match',
                'score' => $result['score'] ?? 0,
                'method' => $result['method'] ?? null,
                'debug' => $debug && isset($result['debug']) ? $result['debug'] : null,
            ]);
        } catch (Exception $e) {
            Log::error("Error in fingerprint verification: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during fingerprint verification',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Display the biometric data page.
     *
     * @param  string  $record_id
     * @return \Illuminate\View\View
     */
    public function showPage($record_id)
    {
        return view('sq-fingerprint::biodata', [
            'record_id' => $record_id
        ]);
    }
} 