<?php

namespace Sq\Fingerprint\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Sq\Employee\Models\CardInfo;
use Sq\Fingerprint\Match\MatchService;
use Sq\Fingerprint\Models\BiometricData;

class CardInfoBiometricController extends Controller
{
    /**
     * The match service.
     *
     * @var \Sq\Fingerprint\Match\MatchService
     */
    protected $matchService;

    /**
     * Create a new controller instance.
     *
     * @param  \Sq\Fingerprint\Match\MatchService  $matchService
     * @return void
     */
    public function __construct(MatchService $matchService)
    {
        $this->matchService = $matchService;
    }

    /**
     * Display the biometric card identification page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('sq-fingerprint::cardinfo-biometric', [
            'title' => 'Biometric Card Identification'
        ]);
    }

    /**
     * Match fingerprint and return card info details
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function matchFingerprint(Request $request)
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

            // Get fingerprint template
            $fingerprintTemplate = null;
            if ($request->has('ISOTemplateBase64')) {
                $fingerprintTemplate = $request->input('ISOTemplateBase64');
            } elseif ($request->has('TemplateBase64')) {
                $fingerprintTemplate = $request->input('TemplateBase64');
            } elseif ($request->has('BMPBase64')) {
                $fingerprintTemplate = $request->input('BMPBase64');
            }

            // Get all biometric data records
            $biometricRecords = BiometricData::all();
            
            // Directory for temporary storage of templates for matching
            $samplesDir = storage_path('app/fingerprint_samples');
            if (!file_exists($samplesDir)) {
                mkdir($samplesDir, 0755, true);
            }

            // Clean the directory
            array_map('unlink', glob($samplesDir . '/*'));

            // Create temporary files for each record
            $recordIdMap = [];
            foreach ($biometricRecords as $record) {
                $templateData = $record->ISOTemplateBase64 ?? $record->TemplateBase64;
                if (!empty($templateData)) {
                    $filename = 'record_' . $record->record_id . '_' . uniqid() . '.dat';
                    $filepath = $samplesDir . '/' . $filename;
                    file_put_contents($filepath, base64_decode($templateData));
                    $recordIdMap[$filename] = $record->record_id;
                }
            }

            // Perform matching
            $matchedFilename = $this->matchService->match($samplesDir, $fingerprintTemplate);

            // Clean up temporary files
            array_map('unlink', glob($samplesDir . '/*'));

            if (!$matchedFilename || !isset($recordIdMap[$matchedFilename])) {
                return response()->json([
                    'success' => false,
                    'message' => 'No matching fingerprint found',
                ], 404);
            }

            // Get the record ID of the matched fingerprint
            $matchedRecordId = $recordIdMap[$matchedFilename];
            
            // Find the CardInfo record
            $cardInfo = CardInfo::where('id', $matchedRecordId)->first();

            if (!$cardInfo) {
                return response()->json([
                    'success' => false,
                    'message' => 'CardInfo record not found for the matched fingerprint',
                ], 404);
            }

            // Return the CardInfo details
            return response()->json([
                'success' => true,
                'message' => 'Fingerprint matched successfully',
                'data' => $cardInfo->load(['department', 'employeeOptions', 'gate'])
            ]);
        } catch (Exception $e) {
            Log::error("Error in CardInfo fingerprint matching: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during fingerprint matching',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Get all CardInfo records with biometric data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllWithBiometricData()
    {
        try {
            // Get all CardInfo records that have biometric data
            $cardInfoWithBiometricData = CardInfo::whereHas('biometricData')->with([
                'department', 
                'employeeOptions', 
                'gate', 
                'biometricData'
            ])->get();

            return response()->json([
                'success' => true,
                'data' => $cardInfoWithBiometricData
            ]);
        } catch (Exception $e) {
            Log::error("Error retrieving CardInfo with biometric data: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving CardInfo records',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    /**
     * Get a specific CardInfo record with biometric data
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCardInfo($id)
    {
        try {
            $cardInfo = CardInfo::with([
                'department', 
                'employeeOptions', 
                'gate', 
                'biometricData'
            ])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $cardInfo
            ]);
        } catch (Exception $e) {
            Log::error("Error retrieving CardInfo: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving the CardInfo record',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
} 