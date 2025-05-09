<?php

namespace Sq\Fingerprint\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Sq\Fingerprint\Models\BiometricData;
use Sq\Fingerprint\Services\FingerprintService;

class FingerprintController extends Controller
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
     * Display the fingerprint identification page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('sq-fingerprint::identification');
    }

    /**
     * Match a fingerprint against stored templates.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function match(Request $request)
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
            
            // Match the fingerprint against all records
            $result = $this->fingerprintService->match(
                $request->only(['ISOTemplateBase64', 'TemplateBase64', 'BMPBase64']), 
                [], 
                $debug
            );

            if ($result === false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to match fingerprint',
                ], 500);
            }

            // Return the match result
            return response()->json([
                'success' => true,
                'match' => $result['matched'],
                'message' => $result['matched'] ? 'Fingerprint matched successfully' : 'No match found',
                'identifier' => $result['identifier'] ?? null,
                'score' => $result['score'] ?? 0,
                'method' => $result['method'] ?? null,
                'data' => $result['data'] ?? null,
                'debug' => $debug && isset($result['debug']) ? $result['debug'] : null,
            ]);
        } catch (Exception $e) {
            Log::error("Error in fingerprint matching: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during fingerprint matching',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Store a fingerprint template.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'record_id' => 'required|string',
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

            $record_id = $request->input('record_id');
            
            // Use the FingerprintService to store data
            $success = $this->fingerprintService->store($request->all(), $record_id);

            if (!$success) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to store fingerprint template',
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Fingerprint template stored successfully',
            ]);
        } catch (Exception $e) {
            Log::error("Error storing fingerprint template: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while storing fingerprint template',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Delete a fingerprint template.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'record_id' => 'required|string',
            ]);

            $record_id = $request->input('record_id');
            
            // Use the FingerprintService to delete data
            $success = $this->fingerprintService->delete($record_id);

            if (!$success) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete fingerprint template',
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Fingerprint template deleted successfully',
            ]);
        } catch (Exception $e) {
            Log::error("Error deleting fingerprint template: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting fingerprint template',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Verify a fingerprint against a stored template.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'record_id' => 'required|string',
                'ISOTemplateBase64' => 'nullable|string',
                'TemplateBase64' => 'nullable|string',
                'BMPBase64' => 'nullable|string',
            ]);

            $record_id = $request->input('record_id');
            
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
}
